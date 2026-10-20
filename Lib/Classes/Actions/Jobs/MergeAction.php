<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs/MergeAction.php
// @desc: regenerate the merged offers archive (one PDF document, one section per offer)
// @date: 20261020
namespace com\igkdev\projects\ForemJobDashboard\Actions\Jobs;

use com\igkdev\projects\ForemJobDashboard\EnterpriseResponseTemplateManager;
use com\igkdev\projects\ForemJobDashboard\IO\OfferArchivePDF;
use com\igkdev\projects\ForemJobDashboard\JobDocTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\JobForemJobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobStatusTypes;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use IGK\Actions\ActionBase;
use IGK\System\Http\Request;
use IGK\System\IO\Path;
use IGK\System\Modules;

/**
 * Build one merged PDF for a period.
 *
 * The merge is done by rendering every offer into a single FPDF document
 * (OfferArchivePDF, FPDF lib loaded by igk/pdflib; FPDF cannot import existing PDF files). Stored
 * documents are therefore listed in each section, and template responses are
 * printed as text; stored files are not embedded.
 *
 * POST is reached through igk_view_handle_actions() in Views/jobs/merge.phtml
 * (see CLAUDE.md: POST sub-actions on a plain ActionBase).
 *
 * @package com\igkdev\projects\ForemJobDashboard\Actions\Jobs
 * @author C.A.D. BONDJE DOUE
 */
class MergeAction extends ActionBase
{
    const MAX_RESPONSE_LINES = 40;

    protected function getProjectUser()
    {
        if ($user = $this->getController()->getUserProfile()) {
            return $user->user();
        }
    }
    /**
     * validate a Y-m-d date, fallback to $default
     */
    public static function NormalizeDate(?string $value, string $default): string
    {
        $value = trim((string)$value);
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $m) && checkdate((int)$m[2], (int)$m[3], (int)$m[1])) {
            return $value;
        }
        return $default;
    }
    /**
     * build and download the merged pdf.
     * @return bool false when no offer exists for the period (nothing is sent)
     */
    public function build_post(?Request $request = null): bool
    {
        // TMPDBG
        @set_time_limit(15);
        register_shutdown_function(function () { @file_put_contents('/private/tmp/job_archive/dbg.txt', json_encode(error_get_last()) . "\n", FILE_APPEND); });
        $request = $request ?? Request::getInstance();
        $from = $request->get('from') ?? ($_POST['from'] ?? null);
        $to = $request->get('to') ?? ($_POST['to'] ?? null);
        $from = self::NormalizeDate($from, date('Y-m-d', strtotime('-3 months')));
        $to = self::NormalizeDate($to, date('Y-m-d'));
        if ($from > $to) {
            list($from, $to) = [$to, $from];
        }
        $user = $this->getProjectUser() ?? igk_die('missing project user');
        $ctrl = $this->getController();
        igk_require_module(Modules::igk_pdflib());
        // existing model code may emit deprecation notices: keep them out of the PDF stream
        $prev_level = error_reporting(error_reporting() & ~(E_DEPRECATED | E_USER_DEPRECATED));
        $ob_level = ob_get_level();
        ob_start();

        $rows = array_filter(Jobs::select_all([Jobs::FD_USER_ID => $user->jbu_id]) ?: [], function ($r) use ($from, $to) {
            $d = substr((string)$r->Create_At, 0, 10);
            return $d >= $from && $d <= $to;
        });
        if (!$rows) {
            while (ob_get_level() > $ob_level) {
                ob_end_clean();
            }
            error_reporting($prev_level);
            return false;
        }
        usort($rows, function ($a, $b) {
            return strcmp((string)$a->Create_At, (string)$b->Create_At);
        });

        $info_id = JobDocTypes::GetCacheData(JobDocTypes::INFO)->id;
        $response_id = JobDocTypes::GetCacheData(JobDocTypes::RESPONSE)->id;
        $rep = new EnterpriseResponseTemplateManager;
        $rep->name = $user->display();
        $pdf = new OfferArchivePDF(sprintf('Archive Forem Jobs - %s au %s - généré le %s', $from, $to, date('Y-m-d')));
        $pdf->SetAuthor('C.A.D BONDJE DOUE');
        $pdf->SetTitle(sprintf('Forem - %s / %s', $from, $to));
        foreach ($rows as $row) {
            $ent = $row->enterprise_id ? JobEnterprises::GetCache('id', $row->enterprise_id) : null;
            $st = JobStatusTypes::GetCache('id', $row->status_id);
            $src = JobSourceTypes::GetCache('id', $row->from_id);
            $fref = JobForemJobs::select_row([JobForemJobs::FD_JOB_ID => $row->id]);
            $docs = [];
            $docs_info = [];
            $response = null;
            $info = JobDocs::select_row([
                JobDocs::FD_JOB_ID => $row->id,
                JobDocs::FD_JOB_DOC_TYPE_ID => $info_id,
            ]);
            if ($info && ($r = json_decode($info->value))) {
                $docs[] = 'INFO';
                if (!empty($r->path)) {
                    $docs_info[] = sprintf('Document offre : %s (non intégré)', basename($r->path));
                }
            }
            $resp = JobDocs::select_row([
                JobDocs::FD_JOB_ID => $row->id,
                JobDocs::FD_JOB_DOC_TYPE_ID => $response_id,
            ]);
            if ($resp && ($r = json_decode($resp->value))) {
                $docs[] = 'RESPONSE';
                if (($r->type ?? null) == 'template') {
                    $rep->job_title = $row->title;
                    $response = $rep->treat($r->content);
                } elseif (!empty($r->path)) {
                    $docs_info[] = sprintf('Document réponse : %s (non intégré)', basename($r->path));
                }
            }
            $pdf->addOffer([
                'id' => $row->id,
                'ref' => $fref ? $fref->reference : null,
                'title' => (string)$row->title,
                'enterprise' => $ent ? (string)$ent->name : '-',
                'date' => substr((string)$row->Create_At, 0, 10),
                'from' => $src ? (string)$src->{JobSourceTypes::FD_NAME} : '-',
                'status' => $st ? (string)$st->{JobStatusTypes::FD_NAME} : '-',
                'docs' => $docs,
                'docs_info' => $docs_info,
                'description' => (string)$row->description,
                'response' => $response,
            ]);
        }
        $content = $pdf->Output('S');
        while (ob_get_level() > $ob_level) {
            ob_end_clean();
        }
        error_reporting($prev_level);

        $tdir = igk_io_tempdir('forem');
        $tfile = Path::Combine($tdir, sprintf('forem_offres_%s_%s.pdf', $from, $to));
        igk_io_w2file($tfile, $content);
        igk_download_file(basename($tfile), $tfile, 'application/pdf');
        @unlink($tfile);
        @rmdir($tdir);
        igk_exit();
        return true;
    }
}
