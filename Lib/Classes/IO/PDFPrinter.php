<?php
// @author: C.A.D. BONDJE DOUE
// @file: PDFPrinter.php
// @date: 20240905 10:37:55
namespace com\igkdev\projects\ForemJobDashboard\IO;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\JobForemJobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobStatusTypes;
use com\igkdev\projects\ForemJobDashboard\ModelUtilities\MainTaskModelUtility;
use function igk_resources_gets as __;
///<summary></summary>
/**
 * 
 * @package com\igkdev\projects\ForemJobDashboard\IO
 * @author C.A.D. BONDJE DOUE
 */
class PDFPrinter
{
    private $m_faker;
    public function __construct()
    {
        $this->m_faker = \Faker\Factory::create('fr');
    }
    public function treatText(?string $txt=null){
        if (null === $txt)return $txt;
        $txt = str_replace('é', "\xe9",  $txt);
        $txt = str_replace('è', "\xe8",  $txt);
        $txt = str_replace('ï', "\xef",  $txt);
        return $txt;
    }
    /**
     * 
     * @param Jobs $job 
     * @param mixed $doc 
     * @return string|false|void 
     */
    public function printJob(Jobs $job, $doc = null)
    {
        $date_format = igk_configs()->get('date_format', 'Y-m-d');
        $render = is_null($doc);
        $doc =  $doc ?? new \igk\pdflib\PDFDocument();
        $doc->p()
            ->setStyle("color: black; margin-left:10px; font-size: 28pt; line-height:15mm")
            ->Content = __("title.OFFER");
        $c = 0;
        $e = $job->enterprise_id ? JobEnterprises::GetCache('id', $job->enterprise_id): null;
        $tg = [
            "Date" => date($date_format, strtotime($job->Create_At)),
            "Title" =>  $this->treatText($job->title),
            // "Contact" =>  $this->getFakeName(), // "ICT-JOB",
            "Status" => JobStatusTypes::GetCache('id', $job->status_id)->{JobStatusTypes::FD_NAME},
            "From" => JobSourceTypes::GetCache('id', $job->from_id)->{JobSourceTypes::FD_NAME},
            "Enterprise" => $this->treatText($e ? $e->name : '-'),
            "Description" =>$this->treatText( $job->description),
            "Follows" => implode(",", []),  
            "Type" => JobRegisterTypes::GetCache('id', $job->type_id)->name[0],
            "Response"=>"?"
        ];
        if (($main = $job->getController()->modelUtility("MainTask")) instanceof MainTaskModelUtility) {
            if ($main->isForemJobs($job)) {
                $fref =  JobForemJobs::Get(JobForemJobs::FD_JOB_ID, $job->{Jobs::FD_ID});
                $tg["ForemReference"] = $fref->reference;
            }
        }
        $host = $doc->p();
        $host->setStyle("color: black; margin-left:10px; left: 50mm; font-size: 24pt; line-height:10pt");
        foreach (
            $tg
            as $k => $v
        ) {
            //  $y = 30 + ($c * $tsize);
            $host->span()
                ->Content = sprintf("%s: %s", $k, $this->styleValue($k, $v, $doc));
            $c++;
        }
        if ($render) {
            ob_start();
            $doc->output();
            $c = ob_get_contents();
            ob_end_clean();
            return $c;
        }
    }
    public function getFakeName()
    {
        return implode(" ", array_filter([
            $this->m_faker->title(),
            $this->m_faker->firstName(),
            $this->m_faker->lastName(),
            $this->m_faker->email()
        ]));
    }
    /**
     * 
     * @param mixed $v 
     * @param mixed $document 
     * @return string 
     */
    public function styleValue($k, $v, $document)
    {   
        if (in_array($l = strtolower($k), explode("|", "status"))){
            $cl = igk_getv(
                [
                    "opened"=>"#09760E",
                    "closed"=>""
                ],
             $l);
            $span =  $document::CreateWebNode("span");
            $span->setStyle(sprintf("color: %s;", $cl))
            ->content = $v;
            return $span->render();
        }
        return $v;
    }
}