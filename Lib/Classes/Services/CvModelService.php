<?php
// @author: C.A.D. BONDJE DOUE
// @file: CvModelService.php
// @desc: user's saved cv models (sanitized html), limited per user
namespace com\igkdev\projects\ForemJobDashboard\Services;

use com\igkdev\projects\ForemJobDashboard\Models\JobCvModels;
use DOMDocument;
use DOMNode;

class CvModelService
{
    /** max models per user */
    const MAX_MODELS = 5;
    const MAX_NAME = 100;
    const MAX_CONTENT = 60000;

    const ERR_NAME = 'name';
    const ERR_LIMIT = 'limit';
    const ERR_NOT_FOUND = 'not_found';
    const ERR_DUPLICATE = 'duplicate';
    const ERR_SAVE = 'save';

    const ALLOWED = ['b', 'strong', 'i', 'em', 'u', 'h2', 'h3', 'p', 'br', 'ul', 'ol', 'li', 'a'];

    /**
     * @return JobCvModels[] default first, then by name
     */
    public static function All(int $user_id): array
    {
        $rows = JobCvModels::select_all([JobCvModels::FD_USER_ID => $user_id]) ?: [];
        usort($rows, function ($a, $b) {
            return [-(int)$a->{JobCvModels::FD_IS_DEFAULT}, mb_strtolower($a->{JobCvModels::FD_NAME})]
                <=> [-(int)$b->{JobCvModels::FD_IS_DEFAULT}, mb_strtolower($b->{JobCvModels::FD_NAME})];
        });
        return $rows;
    }
    /**
     * a model of this user only
     */
    public static function Get(int $user_id, int $id): ?JobCvModels
    {
        $r = JobCvModels::select_row([JobCvModels::FD_ID => $id, JobCvModels::FD_USER_ID => $user_id]);
        return $r ?: null;
    }
    /**
     * create (no $id) or update a model.
     * @return JobCvModels|string the model, or an ERR_* code
     */
    public static function Save(int $user_id, ?int $id, string $name, string $content, bool $default = false)
    {
        $name = trim(preg_replace('/\s+/u', ' ', $name));
        if ($name === '' || mb_strlen($name) > self::MAX_NAME) {
            return self::ERR_NAME;
        }
        $content = substr(self::Sanitize($content), 0, self::MAX_CONTENT);
        $all = self::All($user_id);
        $model = null;
        foreach ($all as $m) {
            if ($id && $m->{JobCvModels::FD_ID} == $id) {
                $model = $m;
            } elseif (mb_strtolower($m->{JobCvModels::FD_NAME}) === mb_strtolower($name)) {
                return self::ERR_DUPLICATE;
            }
        }
        if ($id && !$model) {
            return self::ERR_NOT_FOUND;
        }
        if (!$model && count($all) >= self::MAX_MODELS) {
            return self::ERR_LIMIT;
        }
        if ($default || (!$model && !$all)) {
            JobCvModels::update([JobCvModels::FD_IS_DEFAULT => 0], [JobCvModels::FD_USER_ID => $user_id]);
            $default = true;
        }
        if ($model) {
            $model->{JobCvModels::FD_NAME} = $name;
            $model->{JobCvModels::FD_CONTENT} = $content;
            if ($default) {
                $model->{JobCvModels::FD_IS_DEFAULT} = 1;
            }
            return $model->save() ? $model : self::ERR_SAVE;
        }
        $m = JobCvModels::insert([
            'guid' => igk_create_guid(),
            'user_id' => $user_id,
            'name' => $name,
            'content' => $content,
            'is_default' => $default ? 1 : 0,
        ]);
        return $m ?: self::ERR_SAVE;
    }
    public static function Delete(int $user_id, int $id): bool
    {
        $m = self::Get($user_id, $id);
        if (!$m) {
            return false;
        }
        $was_default = (int)$m->{JobCvModels::FD_IS_DEFAULT};
        JobCvModels::delete([JobCvModels::FD_ID => $id, JobCvModels::FD_USER_ID => $user_id]);
        if ($was_default && ($rest = self::All($user_id))) {
            $rest[0]->{JobCvModels::FD_IS_DEFAULT} = 1;
            $rest[0]->save();
        }
        return true;
    }
    /**
     * whitelist html cleaner (the browser side cleaner is only a convenience).
     * placeholders %__key__% are plain text and kept as is.
     */
    public static function Sanitize(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }
        $dom = new DOMDocument();
        $prev = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?><body>' . $html . '</body>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);
        $body = $dom->getElementsByTagName('body')->item(0);
        $out = '';
        if ($body) {
            foreach ($body->childNodes as $n) {
                $out .= self::Node($n);
            }
        }
        return $out;
    }
    private static function Node(DOMNode $n): string
    {
        if ($n->nodeType == XML_TEXT_NODE) {
            return htmlspecialchars($n->nodeValue, ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');
        }
        if ($n->nodeType != XML_ELEMENT_NODE) {
            return '';
        }
        $tag = strtolower($n->nodeName);
        if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'template', 'noscript'], true)) {
            return '';
        }
        $inner = '';
        foreach ($n->childNodes as $c) {
            $inner .= self::Node($c);
        }
        if ($tag == 'div') {
            return $inner === '' ? '' : '<p>' . $inner . '</p>';
        }
        if (!in_array($tag, self::ALLOWED, true)) {
            return $inner;
        }
        if ($tag == 'br') {
            return '<br>';
        }
        $attr = '';
        if ($tag == 'a') {
            $h = trim($n->getAttribute('href'));
            if (preg_match('/^(https?:\/\/|mailto:)/i', $h)) {
                $attr = ' href="' . htmlspecialchars($h, ENT_QUOTES, 'UTF-8') . '" rel="noopener noreferrer" target="_blank"';
            }
        }
        return "<$tag$attr>$inner</$tag>";
    }
}
