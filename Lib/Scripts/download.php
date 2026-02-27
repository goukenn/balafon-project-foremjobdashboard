<?php
// @author: C.A.D. BONDJE DOUE
// @filename: download.php
// @date: 20250219 14:20:52
// @desc: generate class comment 
// + | --------------------------------------------------------------------
// + | generate comment end file 
// + |
use com\igkdev\projects\ForemJobDashboard\EnterpriseResponseTemplateManager;
use com\igkdev\projects\ForemJobDashboard\IO\PDFPrinter;
use com\igkdev\projects\ForemJobDashboard\JobDocTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\JobForemJobs;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobDoctypes as ModelJobDoctypes;
use com\igkdev\projects\ForemJobDashboard\ModelUtilities\MainTaskModelUtility;
use IGK\Helper\IO;
use IGK\Helper\ViewHelper;
use IGK\Models\Users;
use IGK\System\Console\Logger;
use IGK\System\IO\Path;
use IGK\System\Modules;
use IGK\System\Regex\Replacement;
igk_require_module(Modules::igk_pdflib());
$ctrl = ForemJobDashboardController::ctrl(true);
$user = (isset($user) ? igk_get_user_bylogin($user->clLogin) : null) ?? ForemJobDashboardController::SignInUser();
$e_utility = $ctrl->modelUtility('enterprise');
$dir = $output ?? ViewHelper::Dir();
$v_tab_dump_responses = [];
$v_tab_dump_responses[] = <<<EOF
Objet : Votre candidature - Poste de %title%
Madame, Monsieur %name%,
Nous vous remercions pour votre candidature au poste de %title%.
Votre profil a retenu notre attention et nous avons apprécié la richesse de votre parcours. Néanmoins, nous avons le regret de vous informer que nous ne pourrons pas donner suite à votre candidature, ayant retenu d'autres profils correspondant plus étroitement aux exigences spécifiques du poste.
Nous vous remercions de votre compréhension et vous souhaitons une excellente continuation dans vos démarches professionnelles.
Cordialement,

%RH Service%
EOF;
$v_tab_dump_responses[] = <<<EOF
Objet : Réponse à votre candidature
Bonjour %name%,
Je vous remercie sincèrement pour l'intérêt que vous avez manifesté envers notre entreprise et pour le temps que vous avez consacré à votre candidature pour le poste de [Intitulé du poste].
J'ai eu le plaisir de découvrir votre parcours qui reflète une expérience professionnelle riche et des compétences indéniables.
Cependant, après une analyse minutieuse de toutes les candidatures reçues, je dois vous informer que nous avons fait le choix de poursuivre le processus avec d'autres profils dont l'expérience correspond plus étroitement aux spécificités techniques du poste. Cette décision a été difficile à prendre et ne diminue en rien la qualité de votre dossier.
Je tiens à vous encourager vivement dans vos recherches et reste persuadé(e) que vous trouverez rapidement une opportunité qui saura valoriser pleinement vos talents.
Avec mes meilleurs vœux de réussite,

%RH Service%
EOF;
$v_tab_dump_responses[] = <<<EOF
Objet : Suite à votre candidature - %title%
Madame, Monsieur %name%,
Nous vous remercions chaleureusement pour votre candidature au poste de %title% au sein de notre structure.
Nous avons étudié avec grand intérêt votre CV qui met en évidence un parcours professionnel remarquable et des compétences de qualité.
Malheureusement, nous ne sommes pas en mesure de donner une suite positive à votre candidature pour ce poste précis. Face au nombre important de candidatures reçues, nous avons dû faire des choix en fonction de critères très spécifiques liés aux besoins immédiats de l'équipe.
Cependant, votre profil a particulièrement retenu notre attention et nous souhaiterions garder contact avec vous. Avec votre accord, nous conserverons votre candidature dans notre vivier de talents et vous recontacterons dès qu'une opportunité plus adaptée à votre profil se présentera.
Nous vous souhaitons beaucoup de succès dans vos projets professionnels.
Bien cordialement,

%RH Service%
EOF;
$v_tab_dump_responses[] = <<<EOF
Object: response à votre candidature
Madame, Monsieur,
Votre cadidature a été prise en compte au poste de %title%. 
Nous reviendrons vers vous dans les plus bref délais.
Cordialement,

%RH Service%
EOF;
$v_tab_dump_responses[] = <<<EOF
Object: confirmation de la réception de la candidature - %title%
Bonjour,

Nous accusons bonne réception de votre CV et vous en remercions.

Celui-ci sera examiné attentivement dans les plus brefs délais.

Sans retour de notre part, cela indiquera que votre profil ne correspond pas à nos besoins actuels. Néanmoins, il sera conservé dans notre réserve de recrutement pour de futures opportunités.

A bientôt,
EOF;
$v_tab_dump_responses[] = <<<EOF
Object: Candidature au poste de %title%

Merci d'avoir posé votre candidature au poste de %title%
Nous avons bien reçu votre candidature.
Nous vous tiendrons au courant de la suite de la procédure.

Cordialement,
L'équipe de HR
EOF;

/**
* auto generate doc.
* @param mixed $responses
* @param mixed $title
* @param null|string $enterprise
* @param null|string $name
* @param null|string $rh_service
*/
function get_dump_response($responses,  $title, ?string $enterprise = null, ?string $name = null, ?string $rh_service = null)
{
    $src = $responses[rand(0, count($responses) - 1)];
    $rp = new Replacement;
    if (is_array($title)) {
        foreach ($title as $k => $v) {
            $rp->add('/%' . $k . '%/', $v ?? '');
        }
    } else {
        $rp->add('/%title%/', $title ?? '');
        $rp->add('/%enterprise%/', $enterprise ?? '');
        $rp->add('/%name%/', $name ?? '');
        $rp->add('/%RH Service%/', $rh_service ?? '');
    }
    return $rp->replace($src);
}
// igk_wln_e(get_dump_response($responses, 'java'));
/// comming from test - 
if (!function_exists("igk_io_rmdir")) {

    /**
    * auto generate doc.
    * @return bool
    */
    function igk_io_rmdir($dir, $recursive = true, $callback = null)
    {
        if (!is_dir($dir))
            return false;
        $pdir = array($dir);
        $kdir = array($dir);
        $d = 1;
        $leave = 0;
        while ($dir = array_pop($pdir)) {
            $hdir = opendir($dir);
            if (!$hdir)
                return false;
            while (($f = readdir($hdir))) {
                if (($f == ".") || ($f == ".."))
                    continue;
                $v = igk_dir($dir . "/" . $f);
                if ($callback && !$callback($v)) {
                    $leave = 1;
                    continue;
                }
                if (is_link($v)) {
                    @unlink($v);
                    continue;
                }
                if (is_dir($v)) {
                    if ($recursive) {
                        array_push($pdir, $v);
                        array_push($kdir, $v);
                    } else {
                        $d = 0;
                        break;
                    }
                } else if (is_file($v) || is_link($v)) {
                    if ($recursive)
                        unlink($v);
                    else {
                        $d = 0;
                        break;
                    }
                }
            }
            closedir($hdir);
        }
        if ($leave) {
            return false;
        }
        while ($d && ($dir = array_pop($kdir))) {
            if (is_link($dir)) {
                unlink($dir);
            } else {
                @rmdir($dir);
            }
        }
        return igk_count($kdir) == 0;
    }
}
igk_wln(__FILE__ . ":" . __LINE__,  "lk");
if (($main = $ctrl::modelUtility("MainTask")) instanceof MainTaskModelUtility) {
    $cuser = $main->registerUser($user);
    $tempdir = (isset($output) ? $output : null) ??  igk_io_tempdir('forem');
    igk_io_w2file($tempdir . "/README.md", "# ");
    igk_io_w2file($tempdir . "/DELETEME.md", "# please delete me");
    // copy 
    $bfile = $ctrl->getDeclaredDir() . '/Data/docs';
    $bln = strlen($bfile);
    foreach (IO::GetFiles($bfile, "/\.(docx|pdf)$/") as $f) {
        $c = Path::Combine($tempdir . "/docs", substr($f, $bln));
        IO::CreateDir(dirname($c));
        copy($f, $c);
    }
    $info_doc_id = JobDocTypes::GetCacheData(JobDocTypes::INFO)->id;
    $response_doc_id = JobDocTypes::GetCacheData(JobDocTypes::RESPONSE)->id;
    $missing_enterprise  = 0;
    $missing_def = [];
    $tinfo = Jobs::select_all([Jobs::FD_USER_ID => $cuser->id]); //  $main->getJobs($cuser);
    $folders = [];
    $printer = new PDFPrinter;
    $count_ = 0;
    $_cl_name = JobEnterprises::FD_NAME;
    $dispay_name = $user->clLogin == 'cbondje@igkdev.com' ? 'Charles' :  $user->display();
    $rep = new EnterpriseResponseTemplateManager;
    $rep->name = $dispay_name;
    foreach ($tinfo as $row) {
        $store = false;
        if ($row instanceof Jobs) {
            $date = explode("-", explode(" ", $row->Create_At, 2)[0], 4);
            $y = $date[0];
            $m = $date[1];
            $d = $date[2];
            // exported date
            $path = isset($forem_presentation) && $forem_presentation ?
                $path = Path::Combine(...[$y,  $m.'_'.$y]) :
                $path = Path::Combine(...[$y, $m, $d]); // exported date 
            $tdir = Path::Combine($tempdir, $path);
            if (!isset($folders[$path])) {
                IO::CreateDir($tdir);
                $folders[$path] = 1;
            }
            // + | info docs
            $docs = JobDocs::select_row([
                JobDocs::FD_JOB_ID => $row->id,
                JobDocs::FD_JOB_DOC_TYPE_ID => $info_doc_id
            ]);
            $responses =  JobDocs::select_row([
                JobDocs::FD_JOB_ID => $row->id,
                JobDocs::FD_JOB_DOC_TYPE_ID => $response_doc_id
            ]);
            $foremjobs = JobForemJobs::select_row([
                JobForemJobs::FD_JOB_ID => $row->id,
            ]);
            $enterprise = $row->enterprise_id ? JobEnterprises::Get('id', $row->enterprise_id) : null;
            if (!$enterprise) {
                Logger::danger('missing enterprise for - ' . $row->id);
                $missing_def[] = $row->id;
                $missing_enterprise++;
                $enterprise = JobEnterprises::createEmptyRow();
                $enterprise->name = 'NOT_DEFINE.' . $row->id;
                //continue;
            }
            $c = $printer->printJob($row);
            $name = strtoupper(preg_replace('/\s+/', '_',  $enterprise ? $enterprise->{$_cl_name} : 'unknown'));
            $is_forem = $foremjobs != null;
            $mark = Path::Combine($tdir, $is_forem ? 'Forem/' . $foremjobs->reference : $name);
            // print description infomation 
            $lib = [];
            igk_io_w2file($tfile = Path::Combine($mark, "details_offre_" . $row->id . '_' . $count_ . ".pdf"), $c);
            $store = true;
            // + | create and update file to time 
            if ($r = (new DateTime($row->Create_At))->getTimestamp()) {
                @touch($tfile, $r);
            }
            if ($docs) {
                $r = json_decode($docs->value);
                $ext = igk_getv([
                    'application/pdf' => '.pdf'
                ], $r->type, '.pdf');
                igk_io_w2file(
                    Path::Combine($mark, 'offer_doc' . $ext),
                    file_get_contents(Path::CombineAndFlattenPath($ctrl->getOfferDir(), $r->path))
                );
                $store = true;
            }
            $e_id = $row->id();
            // $docs = $e_utility->getOffersDocumentToPrint($e_id);
            // $responses = $e_utility->getJobEnterpriseResponse($e_id);
            if ($row->description)
                $lib['description.txt'] = $row->description;
            // render response
            // if ($docs) {
            // esxtract store document 
            //igk_io_w2file(Path::Combine($tdir, "response.txt"), '');
            //     foreach($docs as $kdoc){
            //     }
            // } 
            if ($responses) {
                $r = json_decode($responses->value, false, 512);
                if ($r->type == 'template') {
                    $src = $r->content;
                    $rep->job_title = $row->title;
                    $src = $rep->treat($src);
                    igk_io_w2file(
                        Path::Combine($mark, 'response_template.txt'),
                        $src
                    );
                } else {
                    $ext = igk_getv([
                        'application/pdf' => '.pdf'
                    ], $r->type, '.pdf');
                    if (file_exists($tfile = Path::CombineAndFlattenPath($ctrl->getResponseDir(), $r->path))) {
                        igk_io_w2file(
                            Path::Combine($mark, 'response' . $ext),
                            file_get_contents($tfile)
                        );
                    }
                }
            } else {
                if ([0, 1][rand(0, 1)]) {
                    $ts = get_dump_response($v_tab_dump_responses, $row->title, $name,  $rep->name);
                    $main->storeJobDocument(
                        $row,
                        json_encode((object)[
                            'content' => $ts,
                            'type' => 'template',
                            'size' => strlen($ts)
                        ], JSON_UNESCAPED_UNICODE),
                        ModelJobDoctypes::GetCache(ModelJobDoctypes::FD_NAME, JobDocTypes::RESPONSE)
                    );
                    $lib['response.txt'] = $ts;
                }
            }
            if (isset($row->motivation))
                $lib['motivation.txt'] = $row->motivation;
            foreach ($lib as $n => $m) {
                igk_io_w2file(Path::Combine($mark, $n), $m);
                $store = true;
            }
            $count_++;
        }
    }
    if ($outzip) {
        $odir = igk_io_tempdir('forem');
        $tfile = Path::Combine($odir, date("Ymd_") . 'foremjobs.zip');
        $zip = new ZipArchive();
        if ($hzip = $zip->open($tfile, ZipArchive::CREATE)) {
            $g = igk_zip_dir($tempdir, $zip, 'jobs');
            $zip->close();
        }
        igk_download_file('forem-archive.zip', $tfile, 'application/octect-stream');
        igk_io_rmdir($tempdir);
    }
    if ($missing_enterprise > 0) {
        Logger::danger(sprintf('missing enterprise: %s', $missing_enterprise));
        Logger::info(json_encode($missing_def));
    }
} else {
    igk_die('failed');
}
Logger::info(json_encode(compact(
    'missing_enterprise'
)));