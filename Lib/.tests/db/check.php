<?php
 // @command: balafon --run src/application/Projects/ForemJobDashboard/Lib/.tests/db/check.php
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\JobDoctypes;
use IGK\Helper\JSon;
use IGK\System\Console\Colorize;
use IGK\System\Console\Logger;

$ctrl = ForemJobDashboardController::ctrl(true);
$d = JobDocs::select_all([JobDocs::FD_JOB_DOC_TYPE_ID=>3]);
$src = file_get_contents('/Volumes/Data/wwwroot/core/Projects/ForemJobDashboard/Data/models/response_Model2.template');
$cr = json_encode(
    (object)[
        'content' => $src,
        'type' => 'template',
        'size' => strlen($src)
    ],
     JSON_UNESCAPED_UNICODE
);
$src = file_get_contents('/Volumes/Data/wwwroot/core/Projects/ForemJobDashboard/Data/models/response_Model3.template');
$cr2 = json_encode(
    (object)[
        'content' => $src,
        'type' => 'template',
        'size' => strlen($src)
    ],
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
);
$src = file_get_contents('/Volumes/Data/wwwroot/core/Projects/ForemJobDashboard/Data/models/response_Model1.template');
$cr3 = json_encode(
    (object)[
        'content' => $src,
        'type' => 'template',
        'size' => strlen($src)
    ],
    JSON_UNESCAPED_UNICODE
);
$s1 = 'Objet : Ru00e9ponse u00e0 votre candidature u2013 %__job_title__%nnMonsieur/Madame %__name__%,nnNous vous remercions sincu00e8rement pour lu2019intu00e9ru00eat que vous avez portu00e9 u00e0 notre entreprise et pour le temps consacru00e9 u00e0 votre candidature.nnApru00e8s une analyse attentive de votre profil, nous avons le regret de vous informer que nous ne donnerons pas suite u00e0 votre candidature pour le poste du2019informaticien analyste PHP.nnCette du00e9cision ne remet pas en question la qualitu00e9 de votre parcours, mais ru00e9sulte du2019un choix difficile parmi de nombreuses candidatures qualifiu00e9es.nnNous vous souhaitons le meilleur pour la suite de votre carriu00e8re.nnBien cordialement,nn%__contact__%n%__enterprise_info__%';
$s2 = 'Objet : Refus de candidature u2013 %__job_title__%nnBonjour %__name__%nnMerci pour votre candidature. Apru00e8s u00e9tude de votre dossier, nous ne donnerons pas suite favorablement u00e0 votre demande.nnNous vous souhaitons une bonne continuation dans vos recherches.nnCordialement,n n%__contact__%n%__enterprise_info__%';
$s3 = 'Objet : Réponse à votre candidature – %__job_title__%nnMonsieur/Madame %__name__%,nnNous vous remercions sincèrement pour l’intérêt que vous avez porté à notre entreprise et pour le temps consacré à votre candidature.nnAprès une analyse attentive de votre profil, nous avons le regret de vous informer que nous ne donnerons pas suite à votre candidature pour le poste d’informaticien analyste PHP.nnCette décision ne remet pas en question la qualité de votre parcours, mais résulte d’un choix difficile parmi de nombreuses candidatures qualifiées.nnNous vous souhaitons le meilleur pour la suite de votre carrière.nnBien cordialement,nn%__contact__%n%__enterprise_info__%';
$cr4 = json_encode(
    (object)[
        'content' => "Objet : Suite à votre candidature\n\nBonjour %__name__%,\n\nMerci d’avoir postulé au poste d’analyste %__job_title__%. Nous avons été ravis de découvrir votre parcours et vos expériences.\n\nAprès réflexion, nous avons finalement décidé de poursuivre le processus avec un autre profil qui correspond davantage aux besoins immédiats du poste.\n\nCela dit, votre profil reste intéressant et nous le conserverons pour d’éventuelles opportunités futures.\n\nNous vous souhaitons plein de réussite dans vos démarches.\n\nBien à vous,\n\n%__contact__%\n%__enterprise_info__%",
        'type' => 'template',
        'size' => strlen($src)
    ],
    JSON_UNESCAPED_UNICODE
);
$list = JobDocs::select_all([JobDocs::FD_JOB_DOC_TYPE_ID => 3]);
$update = 0;
$l = [];
$checks = [
    'Objet : Suite à votre candidaturennBonjour %__name__%,nnMerci d’avoir postulé au poste d’analyste %__job_title__%. Nous avons été ravis de découvrir votre parcours et vos expériences.nnAprès réflexion, nous avons finalement décidé de poursuivre le processus avec un autre profil qui correspond davantage aux besoins immédiats du poste.nnCela dit, votre profil reste intéressant et nous le conserverons pour d’éventuelles opportunités futures.nnNous vous souhaitons plein de réussite dans vos démarches.nnBien à vous,nn%__contact__%n%__enterprise_info__%'
    =>$cr4,
    'Objet : Suite à votre candidaturennBonjour %__name__%,nnMerci d’avoir postulé au poste d’analyste PHP chez [Nom de l’entreprise]. Nous avons été ravis de découvrir votre parcours et vos expériences.nnAprès réflexion, nous avons finalement décidé de poursuivre le processus avec un autre profil qui correspond davantage aux besoins immédiats du poste.nnCela dit, votre profil reste intéressant et nous le conserverons pour d’éventuelles opportunités futures.nnNous vous souhaitons plein de réussite dans vos démarches.nnBien à vous,nn%__contact__%n%__enterprise_info__%'
    =>$cr4,
    'Objet : Suite u00e0 votre candidaturennBonjour %__name__%,nnMerci du2019avoir postulu00e9 au poste du2019analyste PHP chez [Nom de lu2019entreprise]. Nous avons u00e9tu00e9 ravis de du00e9couvrir votre parcours et vos expu00e9riences.nnApru00e8s ru00e9flexion, nous avons finalement du00e9cidu00e9 de poursuivre le processus avec un autre profil qui correspond davantage aux besoins immu00e9diats du poste.nnCela dit, votre profil reste intu00e9ressant et nous le conserverons pour du2019u00e9ventuelles opportunitu00e9s futures.nnNous vous souhaitons plein de ru00e9ussite dans vos du00e9marches.nnBien u00e0 vous,nn%__contact__%n%__enterprise_info__%'
    =>$cr4,
    'Objet : Refus de candidature u2013 %__job_title__%nnBonjour %__name__%\n\nMerci pour votre candidature. Apru00e8s u00e9tude de votre dossier, nous ne donnerons pas suite favorablement u00e0 votre demande.nnNous vous souhaitons une bonne continuation dans vos recherches.nnCordialement,\n \n%__contact__%\n%__enterprise_info__%'=>
    $cr2,
    'Objet : Refus de candidature – %__job_title__%nnBonjour %__name__%nnMerci pour votre candidature. Après étude de votre dossier, nous ne donnerons pas suite favorablement à votre demande.nnNous vous souhaitons une bonne continuation dans vos recherches.nnCordialement,n n%__contact__%n%__enterprise_info__%'
    => $cr2,
    'Objet : Refus de candidature u2013 %__job_title__%nnBonjour %__name__%\n\nMerci pour votre candidature. Apru00e8s u00e9tude de votre dossier, nous ne donnerons pas suite favorablement u00e0 votre demande.nnNous vous souhaitons une bonne continuation dans vos recherches.nnCordialement,\n \n%__contact__%\n%__enterprise_info__%'
    => $cr2,
    'Objet : Suite \u00e0 votre candidature\n\nBonjour %__name__%,\n\nMerci d\u2019avoir postul\u00e9 au poste d\u2019analyste %__job_title__%. Nous avons \u00e9t\u00e9 ravis de d\u00e9couvrir votre parcours et vos exp\u00e9riences.\n\nApr\u00e8s r\u00e9flexion, nous avons finalement d\u00e9cid\u00e9 de poursuivre le processus avec un autre profil qui correspond davantage aux besoins imm\u00e9diats du poste.\n\nCela dit, votre profil reste int\u00e9ressant et nous le conserverons pour d\u2019\u00e9ventuelles opportunit\u00e9s futures.\n\nNous vous souhaitons plein de r\u00e9ussite dans vos d\u00e9marches.nnBien \u00e0 vous,\n\n%__contact__%\n%__enterprise_info__%'    
    => $cr4,
    "Objet : Suite à votre candidature\n\nBonjour %__name__%,\n\nMerci d’avoir postulé au poste d’analyste %__job_title__%. Nous avons été ravis de découvrir votre parcours et vos expériences.\n\nAprès réflexion, nous avons finalement décidé de poursuivre le processus avec un autre profil qui correspond davantage aux besoins immédiats du poste.\n\nCela dit, votre profil reste intéressant et nous le conserverons pour d’éventuelles opportunités futures.\n\nNous vous souhaitons plein de réussite dans vos démarches.nnBien à vous,\n\n%__contact__%\n%__enterprise_info__%"
    =>$cr4
];
$missing = [];
while (count($list) > 0) {
    $r = array_shift($list);
    if ($data = json_decode($r->jdv_value)) {
        if (is_numeric($data)){
            $r->jdv_value = $cr; $update++; 
            $r->save();
            continue;
        } 
        if ($data->type == 'template') {
            $l[$data->content] = 1;
            if ($data->content == $s1) { 
                $r->jdv_value = $cr; 
                $update++;
                $r->save();
            }
            else if ($data->content == $s2) { 
                $r->jdv_value = $cr2; 
                $update++;
                $r->save();
            }
            else if ($data->content == $s3) { 
                $r->jdv_value = $cr3; 
                $update++;
                $r->save();
            } else {
                if ($gn = igk_getv($checks , $data->content)){
                    $t = json_decode($gn); 
                    $r->jdv_value = $gn; 
                    $update++;
                    $r->save(); 
                } else {
                    if (!isset($missing[$data->content])){
                        echo 'mising : '.$data->content, PHP_EOL, PHP_EOL;
                        $missing[$data->content] = 1;
                    }
                }
            }
        }
    }
} 
Logger::SetColorizer(new Colorize);
Logger::print("update : " . $update);
Logger::print(json_encode($l, JSON_PRETTY_PRINT));
igk_exit();