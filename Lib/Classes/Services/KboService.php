<?php
// @author: C.A.D. BONDJE DOUE
// @file: KboService.php
// @desc: read public information of a belgian enterprise from the KBO/BCE public search
namespace com\igkdev\projects\ForemJobDashboard\Services;

use DOMDocument;
use DOMElement;
use DOMXPath;

/**
 * Source: BCE/KBO public search (SPF Economie). One request per lookup, by enterprise number only.
 * @package com\igkdev\projects\ForemJobDashboard\Services
 */
class KboService
{
    const URL = 'https://kbopub.economie.fgov.be/kbopub/toonondernemingps.html?lang=fr&ondernemingsnummer=%s';
    const TIMEOUT = 10;
    const NO_DATA = 'Pas de données';

    const MONTHS = [
        'janvier' => 1, 'février' => 2, 'mars' => 3, 'avril' => 4, 'mai' => 5, 'juin' => 6,
        'juillet' => 7, 'août' => 8, 'septembre' => 9, 'octobre' => 10, 'novembre' => 11, 'décembre' => 12,
    ];

    /**
     * normalize a belgian enterprise number to 10 digits (0xxxxxxxxx).
     * accepts "BE 0403.199.702", "403199702", ... returns null when invalid (format or modulo 97 check)
     */
    public static function Normalize(?string $number): ?string
    {
        $n = preg_replace('/\D+/', '', (string)$number);
        if (strlen($n) == 9) {
            $n = '0' . $n;
        }
        if (strlen($n) != 10) {
            return null;
        }
        if ((97 - ((int)substr($n, 0, 8) % 97)) != (int)substr($n, 8, 2)) {
            return null;
        }
        return $n;
    }
    /**
     * format as 0403.199.702
     */
    public static function Format(string $number): string
    {
        return substr($number, 0, 4) . '.' . substr($number, 4, 3) . '.' . substr($number, 7, 3);
    }
    /**
     * get public information. null when not found or when the registry is unreachable.
     * @return null|array{number:string,name:?string,status:?string,start_date:?string,address:?string,locality:?string,legal_form:?string,phone:?string,email:?string,website:?string,source:string}
     */
    public static function Fetch(string $number): ?array
    {
        if (!($n = self::Normalize($number))) {
            return null;
        }
        $html = self::Download(sprintf(self::URL, $n));
        return $html ? self::Parse($html) : null;
    }
    const SEARCH_URL = 'https://kbopub.economie.fgov.be/kbopub/zoeknaamfonetischform.html?lang=fr&_oudeBenaming=on&_ondNP=on&ondNP=true&_ondRP=on&ondRP=true&_vest=on&_filterEnkelActieve=on&filterEnkelActieve=true&actionNPRP=Rechercher&searchWord=%s';

    /**
     * search active enterprises by name in the public registry.
     * @return array<int,array{number:string,name:string}> candidates (first rows of the result page)
     */
    public static function Search(string $name): array
    {
        $html = trim($name) !== '' ? self::Download(sprintf(self::SEARCH_URL, rawurlencode(trim($name)))) : null;
        return $html ? self::ParseSearch($html) : [];
    }
    public static function ParseSearch(string $html): array
    {
        $dom = new DOMDocument();
        $prev = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);
        $xp = new DOMXPath($dom);
        $r = [];
        // a result row: the number is the first link ("toonondernemingps...") and the denomination is the td.benaming cell
        foreach ($xp->query('//tr[td[@class="benaming"]]') as $tr) {
            $a = $xp->query('td/a[contains(@href,"toonondernemingps")]', $tr)->item(0);
            $name = self::Clean($xp->query('td[@class="benaming"]', $tr)->item(0)->textContent);
            if ($a && $name !== '' && ($n = self::Normalize($a->textContent))) {
                $r[] = ['number' => $n, 'name' => $name];
            }
        }
        return $r;
    }
    /**
     * strip legal-form words and punctuation to compare enterprise names
     */
    public static function CompareName(string $name): string
    {
        $s = mb_strtolower($name);
        $s = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $s);
        $s = preg_replace('/\b(sa|nv|bv|bvba|sprl|srl|sc|scrl|cv|vzw|asbl|sas|gmbh|ltd|inc|llc|group|groupe|belgium|belgique|belgie|belgië|europe|international)\b/u', ' ', $s);
        return trim(preg_replace('/\s+/u', ' ', $s));
    }
    /**
     * pick the registry number only when exactly one candidate has the same comparable name.
     * returns null when none or ambiguous (left for manual review)
     */
    public static function PickBest(string $name, array $candidates): ?string
    {
        $key = self::CompareName($name);
        if ($key === '') {
            return null;
        }
        $found = [];
        foreach ($candidates as $c) {
            if (self::CompareName($c['name']) === $key) {
                $found[$c['number']] = true;
            }
        }
        return count($found) === 1 ? array_key_first($found) : null;
    }
    protected static function Download(string $url): ?string
    {
        if (!function_exists('curl_init')) {
            $ctx = stream_context_create(['http' => ['timeout' => self::TIMEOUT, 'header' => "User-Agent: ForemJobDashboard\r\n"]]);
            $r = @file_get_contents($url, false, $ctx);
            return $r === false ? null : $r;
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => self::TIMEOUT,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'ForemJobDashboard',
        ]);
        $r = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return ($r === false || $code != 200) ? null : $r;
    }
    /**
     * parse the "Généralités" table of the fr page. null when no enterprise data is found.
     */
    public static function Parse(string $html): ?array
    {
        $dom = new DOMDocument();
        $prev = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);
        $xp = new DOMXPath($dom);
        $values = [];
        foreach ($xp->query('//div[@id="table"]/table/tr[td[1][@class="QL" or @class="RL"]]') as $tr) {
            $cells = $xp->query('td', $tr);
            if ($cells->length < 2) {
                continue;
            }
            $label = rtrim(self::Clean($cells->item(0)->textContent), ' :');
            if ($label !== '' && !isset($values[$label])) {
                $values[$label] = self::Lines($cells->item(1));
            }
        }
        $number = $values["Numéro d'entreprise"][0] ?? null;
        if (!$number) {
            return null;
        }
        $one = function ($label) use ($values) {
            $v = $values[$label][0] ?? null;
            return ($v === null || stripos($v, self::NO_DATA) === 0) ? null : $v;
        };
        $address = $values['Adresse du siège'] ?? [];
        return [
            'number' => self::Format(self::Normalize($number) ?? preg_replace('/\D+/', '', $number)),
            'name' => $one('Dénomination'),
            'status' => $one('Statut'),
            'start_date' => self::ParseDate($one('Date de début')),
            'address' => $address[0] ?? null,
            'locality' => $address[1] ?? null,
            'legal_form' => $one('Forme légale'),
            'phone' => $one('Numéro de téléphone'),
            'email' => $one('E-mail'),
            'website' => $one('Adresse web'),
            'source' => sprintf(self::URL, preg_replace('/\D+/', '', $number)),
        ];
    }
    protected static function Clean(string $s): string
    {
        return trim(preg_replace('/\s+/u', ' ', str_replace("\xC2\xA0", ' ', $s)));
    }
    /**
     * text lines of a cell (split on <br>), ignoring the "since ..." annotations
     * @return string[]
     */
    protected static function Lines(DOMElement $cell): array
    {
        $lines = [''];
        $walk = function ($node) use (&$walk, &$lines) {
            foreach ($node->childNodes as $c) {
                if ($c instanceof DOMElement) {
                    if ($c->tagName == 'br') {
                        $lines[] = '';
                    } elseif ($c->getAttribute('class') != 'upd' && $c->tagName != 'a') {
                        $walk($c);
                    }
                } else {
                    $lines[count($lines) - 1] .= $c->textContent;
                }
            }
        };
        $walk($cell);
        return array_values(array_filter(array_map([self::class, 'Clean'], $lines), 'strlen'));
    }
    /**
     * "5 décembre 1934" => 1934-12-05
     */
    protected static function ParseDate(?string $s): ?string
    {
        if ($s && preg_match('/^(\d{1,2})\s+(\S+)\s+(\d{4})$/u', $s, $m)) {
            $mo = self::MONTHS[mb_strtolower($m[2])] ?? null;
            if ($mo) {
                return sprintf('%04d-%02d-%02d', $m[3], $mo, $m[1]);
            }
        }
        return null;
    }
}
