'use strict';

// @desc: igk-winui-cv-textwyswyg - turns a textarea into a small WYSIWYG editor for a CV.
//        The textarea stays the source of truth: its value is always the sanitized HTML,
//        placeholders are serialized as %__key__%.
//        Configuration (optional) in the textarea's `igk:data` attribute (json):
//        { "placeholders": {key: value}, "labels": {name: text}, "sections": {name: {title, html}} }

(function () {
    const CLASS_NAME = 'igk-winui-cv-textwyswyg';
    const CSS_ID = 'igk-cv-wysiwyg-css';
    const PH_RE = /%__([A-Za-z0-9_]+)__%/g;
    const ALLOWED = {
        B: 1, STRONG: 1, I: 1, EM: 1, U: 1, H2: 1, H3: 1, P: 1, BR: 1, UL: 1, OL: 1, LI: 1, A: 1, SPAN: 1
    };
    const DROP_WITH_CONTENT = { SCRIPT: 1, STYLE: 1, IFRAME: 1, OBJECT: 1, EMBED: 1, TEMPLATE: 1, NOSCRIPT: 1 };
    const DEFAULT_LABELS = {
        bold: 'Bold', italic: 'Italic', underline: 'Underline', h2: 'Title', h3: 'Subtitle',
        ul: 'Bulleted list', ol: 'Numbered list', link: 'Link', undo: 'Undo', redo: 'Redo', clear: 'Clear format',
        insert: 'Insert', sections: 'Sections', preview: 'Preview', linkPrompt: 'Link address (https://…)'
    };
    const DEFAULT_SECTIONS = {
        experience: { title: 'Experience', html: '<h2>Experience</h2><ul><li>Role - Company (dates)</li></ul>' },
        education: { title: 'Education', html: '<h2>Education</h2><ul><li>Degree - School (dates)</li></ul>' },
        skills: { title: 'Skills', html: '<h2>Skills</h2><ul><li>Skill</li></ul>' },
        languages: { title: 'Languages', html: '<h2>Languages</h2><ul><li>Language - level</li></ul>' }
    };

    const CSS = `
.igk-cv-wysiwyg{--cvw-bd:color-mix(in srgb,currentColor 25%,transparent);--cvw-bg:color-mix(in srgb,currentColor 6%,transparent);border:1px solid var(--cvw-bd);border-radius:.6rem;overflow:hidden}
.igk-cv-toolbar{display:flex;flex-wrap:wrap;gap:.25rem;padding:.4rem;border-bottom:1px solid var(--cvw-bd);background:var(--cvw-bg);align-items:center}
.igk-cv-toolbar button,.igk-cv-toolbar select{font:inherit;color:inherit;background:transparent;border:1px solid var(--cvw-bd);border-radius:.4rem;padding:.2rem .55rem;cursor:pointer;min-height:2rem}
.igk-cv-toolbar button:hover,.igk-cv-toolbar select:hover{background:var(--cvw-bg)}
.igk-cv-toolbar button[aria-pressed="true"]{background:var(--cvw-bd)}
.igk-cv-toolbar .igk-cv-sep{width:1px;align-self:stretch;background:var(--cvw-bd);margin:0 .2rem}
.igk-cv-toolbar .igk-cv-toggle{margin-left:auto}
.igk-cv-body{display:grid;grid-template-columns:1fr}
.igk-cv-wysiwyg.igk-cv-with-preview .igk-cv-body{grid-template-columns:1fr 1fr}
.igk-cv-editor,.igk-cv-preview{min-height:18rem;max-height:70vh;overflow:auto;padding:.8rem 1rem;outline:none}
.igk-cv-preview{display:none;border-left:1px solid var(--cvw-bd);background:var(--cvw-bg)}
.igk-cv-wysiwyg.igk-cv-with-preview .igk-cv-preview{display:block}
.igk-cv-editor:focus{box-shadow:inset 0 0 0 2px color-mix(in srgb,currentColor 35%,transparent)}
.igk-cv-editor h2,.igk-cv-preview h2{font-size:1.25rem;margin:.8rem 0 .3rem}
.igk-cv-editor h3,.igk-cv-preview h3{font-size:1.05rem;margin:.6rem 0 .3rem}
.igk-cv-editor ul,.igk-cv-editor ol,.igk-cv-preview ul,.igk-cv-preview ol{padding-left:1.4rem}
.igk-cv-editor ul,.igk-cv-preview ul{list-style:disc}
.igk-cv-editor ol,.igk-cv-preview ol{list-style:decimal}
.igk-cv-ph{display:inline-block;padding:0 .4rem;border-radius:.8rem;background:var(--cvw-bd);font-size:.85em;user-select:all}
@media (max-width:1023px){.igk-cv-wysiwyg.igk-cv-with-preview .igk-cv-body{grid-template-columns:1fr}.igk-cv-preview{border-left:0;border-top:1px solid var(--cvw-bd)}}
`;

    function el(tag, attrs, text) {
        const e = document.createElement(tag);
        if (attrs) {
            Object.keys(attrs).forEach(function (k) { e.setAttribute(k, attrs[k]); });
        }
        if (text != null) {
            e.textContent = text;
        }
        return e;
    }
    function safeHref(v) {
        v = (v || '').trim();
        return /^(https?:\/\/|mailto:)/i.test(v) ? v : null;
    }
    function isPh(n) {
        return n.nodeType == 1 && n.tagName == 'SPAN' && n.hasAttribute('data-ph');
    }
    function phChip(key) {
        const s = el('span', { 'class': 'igk-cv-ph', 'data-ph': key, contenteditable: 'false' }, '%__' + key + '__%');
        return s;
    }
    /**
     * clean a node tree in place: whitelist of tags/attributes. never trusts the source.
     */
    function cleanChildren(parent, outDoc) {
        const out = outDoc.createDocumentFragment();
        Array.prototype.forEach.call(parent.childNodes, function (n) {
            if (n.nodeType == 3) {
                // text: turn %__key__% into chips
                const txt = n.nodeValue;
                let last = 0, m;
                PH_RE.lastIndex = 0;
                while ((m = PH_RE.exec(txt))) {
                    if (m.index > last) { out.appendChild(outDoc.createTextNode(txt.substring(last, m.index))); }
                    out.appendChild(phChip(m[1]));
                    last = m.index + m[0].length;
                }
                if (last < txt.length) { out.appendChild(outDoc.createTextNode(txt.substring(last))); }
                return;
            }
            if (n.nodeType != 1) { return; }
            const tag = n.tagName;
            if (DROP_WITH_CONTENT[tag]) { return; }
            if (isPh(n)) {
                const k = (n.getAttribute('data-ph') || '').replace(/[^A-Za-z0-9_]/g, '');
                if (k) { out.appendChild(phChip(k)); }
                return;
            }
            if (!ALLOWED[tag] || tag == 'SPAN') {
                // unknown wrapper: keep content only (div -> block break)
                const inner = cleanChildren(n, outDoc);
                if (tag == 'DIV' && inner.childNodes.length) {
                    const p = outDoc.createElement('p');
                    p.appendChild(inner);
                    out.appendChild(p);
                } else {
                    out.appendChild(inner);
                }
                return;
            }
            const c = outDoc.createElement(tag.toLowerCase());
            if (tag == 'A') {
                const h = safeHref(n.getAttribute('href'));
                if (h) {
                    c.setAttribute('href', h);
                    c.setAttribute('rel', 'noopener noreferrer');
                    c.setAttribute('target', '_blank');
                }
            }
            if (tag != 'BR') { c.appendChild(cleanChildren(n, outDoc)); }
            out.appendChild(c);
        });
        return out;
    }
    /**
     * sanitize html string => html string (placeholders as chips)
     */
    function sanitize(html) {
        const src = new DOMParser().parseFromString('<body>' + (html || '') + '</body>', 'text/html').body;
        const box = document.implementation.createHTMLDocument('').body;
        box.appendChild(cleanChildren(src, box.ownerDocument));
        return box.innerHTML;
    }
    /**
     * html of an editor node as stored in the textarea: sanitized, chips => %__key__%
     */
    function serialize(node) {
        const box = document.implementation.createHTMLDocument('').body;
        box.appendChild(cleanChildren(node, box.ownerDocument));
        Array.prototype.forEach.call(box.querySelectorAll('span[data-ph]'), function (s) {
            s.replaceWith(box.ownerDocument.createTextNode('%__' + s.getAttribute('data-ph') + '__%'));
        });
        return box.innerHTML;
    }
    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }
    /**
     * stored html => preview html (placeholders replaced by real values, escaped)
     */
    function renderPreview(stored, values) {
        const safe = sanitize(stored);
        const box = document.implementation.createHTMLDocument('').body;
        box.innerHTML = safe;
        Array.prototype.forEach.call(box.querySelectorAll('span[data-ph]'), function (s) {
            const k = s.getAttribute('data-ph');
            const has = Object.prototype.hasOwnProperty.call(values, k) && values[k];
            s.replaceWith(box.ownerDocument.createTextNode(has ? String(values[k]) : '%__' + k + '__%'));
        });
        return box.innerHTML;
    }
    function insertHtmlAtCaret(editor, html) {
        editor.focus();
        const sel = window.getSelection();
        if (!sel.rangeCount || !editor.contains(sel.anchorNode)) {
            const r = document.createRange();
            r.selectNodeContents(editor);
            r.collapse(false);
            sel.removeAllRanges();
            sel.addRange(r);
        }
        document.execCommand('insertHTML', false, sanitize(html));
    }
    function readConfig(textarea) {
        let cfg = {};
        try {
            cfg = JSON.parse(textarea.getAttribute('igk:data') || textarea.getAttribute('data-igk-data') || '{}') || {};
        } catch (e) { cfg = {}; }
        return {
            placeholders: cfg.placeholders || {},
            labels: Object.assign({}, DEFAULT_LABELS, cfg.labels || {}),
            sections: Object.assign({}, DEFAULT_SECTIONS, cfg.sections || {})
        };
    }

    function __init() {
        const ta = this.o;
        if (!ta || ta.tagName != 'TEXTAREA' || ta.getAttribute('data-igk-cv-init')) {
            return;
        }
        ta.setAttribute('data-igk-cv-init', '1');
        if (!document.getElementById(CSS_ID)) {
            const st = el('style', { id: CSS_ID });
            st.textContent = CSS;
            document.head.appendChild(st);
        }
        const cfg = readConfig(ta);
        const L = cfg.labels;

        const wrap = el('div', { 'class': 'igk-cv-wysiwyg' });
        const bar = el('div', { 'class': 'igk-cv-toolbar', role: 'toolbar' });
        const body = el('div', { 'class': 'igk-cv-body' });
        const editor = el('div', { 'class': 'igk-cv-editor', contenteditable: 'true', role: 'textbox', 'aria-multiline': 'true' });
        const preview = el('div', { 'class': 'igk-cv-preview', 'aria-live': 'polite' });
        body.appendChild(editor);
        body.appendChild(preview);
        wrap.appendChild(bar);
        wrap.appendChild(body);

        function btn(label, text, fn) {
            const b = el('button', { type: 'button', 'aria-label': label, title: label, 'aria-pressed': 'false' }, text);
            b.addEventListener('mousedown', function (e) { e.preventDefault(); }); // keep the selection
            b.addEventListener('click', function () { editor.focus(); fn(); sync(); });
            bar.appendChild(b);
            return b;
        }
        function sep() { bar.appendChild(el('span', { 'class': 'igk-cv-sep' })); }
        function cmd(name, value) { document.execCommand(name, false, value || null); }

        const fmtBtns = {};
        fmtBtns.bold = btn(L.bold, 'B', function () { cmd('bold'); });
        fmtBtns.italic = btn(L.italic, 'I', function () { cmd('italic'); });
        fmtBtns.underline = btn(L.underline, 'U', function () { cmd('underline'); });
        sep();
        btn(L.h2, 'H2', function () { cmd('formatBlock', 'h2'); });
        btn(L.h3, 'H3', function () { cmd('formatBlock', 'h3'); });
        btn(L.ul, '• ' + '≡', function () { cmd('insertUnorderedList'); });
        btn(L.ol, '1. ≡', function () { cmd('insertOrderedList'); });
        btn(L.link, '🔗', function () {
            const u = safeHref(window.prompt(L.linkPrompt, 'https://'));
            if (u) { cmd('createLink', u); }
        });
        sep();
        btn(L.undo, '↶', function () { cmd('undo'); });
        btn(L.redo, '↷', function () { cmd('redo'); });
        btn(L.clear, 'Tx', function () { cmd('removeFormat'); cmd('formatBlock', 'p'); });
        sep();

        function menu(label, entries, onPick) {
            if (!entries.length) { return; }
            const s = el('select', { 'aria-label': label });
            s.appendChild(el('option', { value: '' }, label));
            entries.forEach(function (e) { s.appendChild(el('option', { value: e[0] }, e[1])); });
            s.addEventListener('change', function () {
                if (s.value) { onPick(s.value); s.value = ''; sync(); }
            });
            bar.appendChild(s);
        }
        const phKeys = Object.keys(cfg.placeholders);
        menu(L.insert, phKeys.map(function (k) { return [k, k]; }), function (k) {
            insertHtmlAtCaret(editor, '%__' + k + '__%');
        });
        menu(L.sections, Object.keys(cfg.sections).map(function (k) { return [k, cfg.sections[k].title || k]; }), function (k) {
            insertHtmlAtCaret(editor, cfg.sections[k].html || '');
        });
        const tg = btn(L.preview, L.preview, function () {
            const on = wrap.classList.toggle('igk-cv-with-preview');
            tg.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        tg.classList.add('igk-cv-toggle');

        let timer = null;
        function sync() {
            ta.value = serialize(editor);
            preview.innerHTML = renderPreview(ta.value, cfg.placeholders);
            ta.dispatchEvent(new Event('change', { bubbles: true }));
        }
        function refreshState() {
            [['bold', 'bold'], ['italic', 'italic'], ['underline', 'underline']].forEach(function (p) {
                let on = false;
                try { on = document.queryCommandState(p[0]); } catch (e) { }
                fmtBtns[p[1]].setAttribute('aria-pressed', on ? 'true' : 'false');
            });
        }
        editor.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(sync, 150);
        });
        editor.addEventListener('blur', sync);
        document.addEventListener('selectionchange', function () {
            if (editor.contains(window.getSelection().anchorNode)) { refreshState(); }
        });
        editor.addEventListener('paste', function (e) {
            e.preventDefault();
            const cd = e.clipboardData || window.clipboardData;
            const html = cd.getData('text/html');
            document.execCommand('insertHTML', false, html ? sanitize(html) : escapeHtml(cd.getData('text/plain')).replace(/\r?\n/g, '<br>'));
        });
        if (ta.form) {
            ta.form.addEventListener('submit', function () { clearTimeout(timer); ta.value = serialize(editor); });
        }

        editor.innerHTML = sanitize(ta.value);
        ta.parentNode.insertBefore(wrap, ta);
        ta.style.display = 'none';
        wrap.appendChild(ta);
        ta.value = serialize(editor);
        preview.innerHTML = renderPreview(ta.value, cfg.placeholders);
    }

    // @ts-ignore
    igk.system.createNS('igk.winui', {
        cvTextWysiwyg: { sanitize: sanitize, serialize: serialize, renderPreview: renderPreview }
    });
    // @ts-ignore
    igk.winui.initClassControl(CLASS_NAME, __init);
})();
