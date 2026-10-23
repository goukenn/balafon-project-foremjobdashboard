<?php
// @author: C.A.D. BONDJE DOUE
// @file: CalendarService.php
// @desc: user's appointment calendar: storage, due recalls, ICS export (Calendar.app / Google Calendar)
namespace com\igkdev\projects\ForemJobDashboard\Services;

use com\igkdev\projects\ForemJobDashboard\Models\JobAppointments;
use com\igkdev\projects\ForemJobDashboard\Models\JobCalendarFeeds;

class CalendarService
{
    const KINDS = ['interview', 'call', 'followup', 'recontact', 'other'];
    const STATUS_PLANNED = 'planned';
    const STATUS_DONE = 'done';
    const STATUS_CANCELLED = 'cancelled';

    const ERR_TITLE = 'title';
    const ERR_DATE = 'date';
    const ERR_EMAIL = 'email';
    const ERR_NOT_FOUND = 'not_found';
    const ERR_SAVE = 'save';

    /**
     * @return JobAppointments[] ordered by start date
     */
    public static function All(int $user_id): array
    {
        $rows = JobAppointments::select_all([JobAppointments::FD_USER_ID => $user_id]) ?: [];
        usort($rows, function ($a, $b) {
            return strcmp($a->{JobAppointments::FD_START_AT}, $b->{JobAppointments::FD_START_AT});
        });
        return $rows;
    }
    /**
     * an appointment of this user only
     */
    public static function Get(int $user_id, int $id): ?JobAppointments
    {
        $r = JobAppointments::select_row([JobAppointments::FD_ID => $id, JobAppointments::FD_USER_ID => $user_id]);
        return $r ?: null;
    }
    /**
     * planned appointments whose recall date is reached (or whose start passed without being closed)
     * @return JobAppointments[]
     */
    public static function Due(int $user_id, ?string $now = null): array
    {
        $now = $now ?? date('Y-m-d H:i:s');
        return array_values(array_filter(self::All($user_id), function ($a) use ($now) {
            if ($a->{JobAppointments::FD_STATUS} !== self::STATUS_PLANNED) {
                return false;
            }
            $remind = (string)$a->{JobAppointments::FD_REMIND_AT};
            return $remind !== '' ? $remind <= $now : $a->{JobAppointments::FD_START_AT} < $now;
        }));
    }
    /**
     * create (no $id) or update an appointment. Dates are 'Y-m-d H:i' (datetime-local inputs).
     * @param array $d title, kind, start_at, end_at, remind_at, location, contact_email, notes, job_id
     * @return JobAppointments|string the appointment, or an ERR_* code
     */
    public static function Save(int $user_id, ?int $id, array $d)
    {
        $title = trim(preg_replace('/\s+/u', ' ', (string)($d['title'] ?? '')));
        if ($title === '' || mb_strlen($title) > 150) {
            return self::ERR_TITLE;
        }
        $start = self::ParseDate($d['start_at'] ?? '');
        $end = self::ParseDate($d['end_at'] ?? '');
        $remind = self::ParseDate($d['remind_at'] ?? '');
        if (!$start || ($end && $end < $start)) {
            return self::ERR_DATE;
        }
        $email = trim((string)($d['contact_email'] ?? ''));
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return self::ERR_EMAIL;
        }
        $kind = in_array($d['kind'] ?? '', self::KINDS, true) ? $d['kind'] : 'other';
        $values = [
            'title' => $title,
            'kind' => $kind,
            'start_at' => $start,
            'end_at' => $end,
            'remind_at' => $remind,
            'location' => mb_substr(trim((string)($d['location'] ?? '')), 0, 250),
            'contact_email' => $email,
            'notes' => mb_substr(trim((string)($d['notes'] ?? '')), 0, 5000),
            'job_id' => ((int)($d['job_id'] ?? 0)) ?: null,
        ];
        if ($id) {
            $m = self::Get($user_id, $id);
            if (!$m) {
                return self::ERR_NOT_FOUND;
            }
            foreach ($values as $k => $v) {
                $m->{constant(JobAppointments::class . '::FD_' . strtoupper($k))} = $v;
            }
            return $m->save() ? $m : self::ERR_SAVE;
        }
        $m = JobAppointments::insert($values + [
            'guid' => igk_create_guid(),
            'user_id' => $user_id,
        ]);
        return $m ?: self::ERR_SAVE;
    }
    /**
     * @param string $status one of the STATUS_* values
     */
    public static function SetStatus(int $user_id, int $id, string $status): bool
    {
        $m = self::Get($user_id, $id);
        if (!$m || !in_array($status, [self::STATUS_PLANNED, self::STATUS_DONE, self::STATUS_CANCELLED], true)) {
            return false;
        }
        $m->{JobAppointments::FD_STATUS} = $status;
        return (bool)$m->save();
    }
    /**
     * push the recall date forward ($days from now) and keep the appointment planned
     */
    public static function Snooze(int $user_id, int $id, int $days = 1): bool
    {
        $m = self::Get($user_id, $id);
        if (!$m) {
            return false;
        }
        $m->{JobAppointments::FD_REMIND_AT} = date('Y-m-d H:i:s', strtotime('+' . max(1, $days) . ' day'));
        return (bool)$m->save();
    }
    public static function Delete(int $user_id, int $id): bool
    {
        if (!self::Get($user_id, $id)) {
            return false;
        }
        JobAppointments::delete([JobAppointments::FD_ID => $id, JobAppointments::FD_USER_ID => $user_id]);
        return true;
    }

    // + | feed token: the subscription url is secret, calendar apps cannot log in
    public static function FeedToken(int $user_id): string
    {
        $r = JobCalendarFeeds::select_row([JobCalendarFeeds::FD_USER_ID => $user_id]);
        if ($r) {
            return $r->{JobCalendarFeeds::FD_TOKEN};
        }
        return self::RegenerateToken($user_id);
    }
    public static function RegenerateToken(int $user_id): string
    {
        $token = bin2hex(random_bytes(24));
        if ($r = JobCalendarFeeds::select_row([JobCalendarFeeds::FD_USER_ID => $user_id])) {
            $r->{JobCalendarFeeds::FD_TOKEN} = $token;
            $r->save();
        } else {
            JobCalendarFeeds::insert(['user_id' => $user_id, 'token' => $token]);
        }
        return $token;
    }
    /**
     * @return int|null the owner of a feed token
     */
    public static function UserIdByToken(string $token): ?int
    {
        if (!preg_match('/^[a-f0-9]{48}$/', $token)) {
            return null;
        }
        $r = JobCalendarFeeds::select_row([JobCalendarFeeds::FD_TOKEN => $token]);
        return $r ? (int)$r->{JobCalendarFeeds::FD_USER_ID} : null;
    }

    // + | pure helpers (no database)
    /**
     * @return string|null 'Y-m-d H:i:s' from a 'Y-m-d H:i', 'Y-m-dTH:i' or full datetime string
     */
    public static function ParseDate($v): ?string
    {
        $v = trim(str_replace('T', ' ', (string)$v));
        if ($v === '' || !preg_match('/^\d{4}-\d{2}-\d{2}( \d{2}:\d{2}(:\d{2})?)?$/', $v)) {
            return null;
        }
        $t = strtotime($v);
        return $t === false ? null : date('Y-m-d H:i:s', $t);
    }
    /**
     * RFC 5545 text escaping
     */
    public static function IcsEscape(string $s): string
    {
        return str_replace(["\\", ";", ",", "\r\n", "\n", "\r"], ["\\\\", "\\;", "\\,", "\\n", "\\n", "\\n"], $s);
    }
    /**
     * fold a content line to 75 octets (continuation lines start with a space)
     */
    public static function IcsFold(string $line): string
    {
        $out = '';
        $max = 75;
        while (strlen($line) > $max) {
            $cut = $max;
            // never cut inside a multi-byte utf-8 sequence
            while ($cut > 0 && (ord($line[$cut]) & 0xC0) === 0x80) {
                $cut--;
            }
            $out .= substr($line, 0, $cut) . "\r\n ";
            $line = substr($line, $cut);
            // continuation lines carry the leading space: 74 octets of content
            $max = 74;
        }
        return $out . $line;
    }
    /**
     * @param JobAppointments[] $events
     * @param string $name calendar name
     * @return string a VCALENDAR document (UTC times, valid for Calendar.app, Google Calendar, Outlook)
     */
    public static function BuildIcs(array $events, string $name): string
    {
        $utc = function (string $d) {
            return gmdate('Ymd\THis\Z', strtotime($d));
        };
        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//igkdev//ForemJobDashboard//EN',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'X-WR-CALNAME:' . self::IcsEscape($name),
            'REFRESH-INTERVAL;VALUE=DURATION:PT1H',
            'X-PUBLISHED-TTL:PT1H',
        ];
        foreach ($events as $e) {
            $start = $e->{JobAppointments::FD_START_AT};
            $end = $e->{JobAppointments::FD_END_AT} ?: date('Y-m-d H:i:s', strtotime($start) + 3600);
            $status = $e->{JobAppointments::FD_STATUS};
            $lines[] = 'BEGIN:VEVENT';
            $lines[] = 'UID:' . $e->{JobAppointments::FD_GUID} . '@foremjobdashboard';
            $lines[] = 'DTSTAMP:' . $utc($e->{JobAppointments::FD_UPDATE_AT} ?: $start);
            $lines[] = 'DTSTART:' . $utc($start);
            $lines[] = 'DTEND:' . $utc($end);
            $lines[] = 'SUMMARY:' . self::IcsEscape($e->{JobAppointments::FD_TITLE});
            if ($v = $e->{JobAppointments::FD_LOCATION}) {
                $lines[] = 'LOCATION:' . self::IcsEscape($v);
            }
            if ($v = $e->{JobAppointments::FD_NOTES}) {
                $lines[] = 'DESCRIPTION:' . self::IcsEscape($v);
            }
            $lines[] = 'STATUS:' . ($status === self::STATUS_CANCELLED ? 'CANCELLED' : 'CONFIRMED');
            if ($status === self::STATUS_PLANNED && ($r = $e->{JobAppointments::FD_REMIND_AT})) {
                // alarm at the recall date, relative to the start
                $delta = max(0, strtotime($start) - strtotime($r));
                $lines[] = 'BEGIN:VALARM';
                $lines[] = 'ACTION:DISPLAY';
                $lines[] = 'DESCRIPTION:' . self::IcsEscape($e->{JobAppointments::FD_TITLE});
                $lines[] = 'TRIGGER:-PT' . intdiv($delta, 60) . 'M';
                $lines[] = 'END:VALARM';
            }
            $lines[] = 'END:VEVENT';
        }
        $lines[] = 'END:VCALENDAR';
        return implode("\r\n", array_map([self::class, 'IcsFold'], $lines)) . "\r\n";
    }
    /**
     * "Add to Google Calendar" template link for one appointment
     */
    public static function GoogleUrl(JobAppointments $e): string
    {
        $start = $e->{JobAppointments::FD_START_AT};
        $end = $e->{JobAppointments::FD_END_AT} ?: date('Y-m-d H:i:s', strtotime($start) + 3600);
        return 'https://calendar.google.com/calendar/render?' . http_build_query([
            'action' => 'TEMPLATE',
            'text' => $e->{JobAppointments::FD_TITLE},
            'dates' => gmdate('Ymd\THis\Z', strtotime($start)) . '/' . gmdate('Ymd\THis\Z', strtotime($end)),
            'location' => (string)$e->{JobAppointments::FD_LOCATION},
            'details' => (string)$e->{JobAppointments::FD_NOTES},
        ], '', '&', PHP_QUERY_RFC3986);
    }
    /**
     * mailto: link to resend a mail / recontact; null without a contact address
     */
    public static function MailtoUrl(JobAppointments $e): ?string
    {
        $to = trim((string)$e->{JobAppointments::FD_CONTACT_EMAIL});
        if ($to === '') {
            return null;
        }
        return 'mailto:' . rawurlencode($to) . '?' . http_build_query([
            'subject' => $e->{JobAppointments::FD_TITLE},
            'body' => '',
        ], '', '&', PHP_QUERY_RFC3986);
    }
}
