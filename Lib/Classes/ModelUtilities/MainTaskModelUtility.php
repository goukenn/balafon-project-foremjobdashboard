<?php
// @author: C.A.D. BONDJE DOUE
// @file: MainTaskModelUtility.php
// @desc: module utility MainTaskModelUtility
// @date: 20240904 20:10:49
namespace com\igkdev\projects\ForemJobDashboard\ModelUtilities;
use com\igkdev\projects\ForemJobDashboard\ContactDataInfo;
use com\igkdev\projects\ForemJobDashboard\ContractTypes;
use com\igkdev\projects\ForemJobDashboard\Helpers\JobUtility;
use com\igkdev\projects\ForemJobDashboard\Models\JobContacts;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\JobDoctypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobForemJobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobResponses;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use com\igkdev\projects\ForemJobDashboard\RegisterType;
use com\igkdev\projects\ForemJobDashboard\SourceTypes;
use com\igkdev\projects\ForemJobDashboard\StatusTypes;
use IGK\Database\DataAdapterBase;
use IGK\Database\DbConstants;
use IGK\Database\DbQueryCondition;
use IGK\Helper\Activator;
use IGK\Models\Users;
use IGK\System\Database\DbUtils;
use IGKDbModelUtility;
use IGKException;

/**
 * view entry point
 * @package com\igkdev\projects\ForemJobDashboard\ModelUtilities
 * @author C.A.D. BONDJE DOUE
 */
class MainTaskModelUtility extends IGKDbModelUtility
{
    /**
    * auto generate doc.
    * @var mixed
    */
    static $sm_ownerForems = [];
    /**
     * register user
     * @param Users $user 
     * @return ?JobUsers
     */
    public function registerUser(Users $user)
    {
        $ru = JobUsers::insertIfNotExists([
            JobUsers::FD_GUID => $user->clGuid
        ]);
        if ($ru === true) {
            $ru = JobUsers::last();
        }
        return $ru;
    }
    /**
    * auto generate doc.
    * @return null|JobUsers
    */
    public function last()
    {
        return JobUsers::Get("id", JobUsers::last_id());
    }
    /**
     * get is system users is registrated user 
     * @param Users $user 
     * @return bool 
     */
    public function isRegisterUser(Users $user)
    {
        return JobUSers::select_row([
            JobUsers::FD_GUID => $user->clGuid
        ]) != null;
    }
    /**
    * auto generate doc.
    * @return object|null|void
    */
    public function addJob(string $title, JobUsers $user, ?int $timespan = null, ?string $description = null, 
        string $type=RegisterType::REAL)
    {
        $date = !is_null($timespan) && ($timespan > 0) ? date('Y-m-d', $timespan) : JobUsers::FC_NOW;
        $d = [
            Jobs::FD_GUID => igk_create_guid(),
            Jobs::FD_TITLE => $title,
            Jobs::FD_FROM_ID => SourceTypes::GetCacheData(SourceTypes::WEB),
            Jobs::FD_TYPE_ID =>  RegisterType::GetCacheData($type),
            Jobs::FD_CONTRACT_ID => ContractTypes::GetCacheData(ContractTypes::EMPOYEE),
            Jobs::FD_STATUS_ID => StatusTypes::GetCacheData(StatusTypes::OPENED),
            Jobs::FD_USER_ID => $user->id,
            Jobs::FD_IDENTIFY => JobUtility::CreateJobIdentify($title, '', null),
            Jobs::FD_DESCRIPTION => $description,
            Jobs::FD_SUMMARY => null,
            Jobs::FD_PATH => '',
            Jobs::FD_PRINTABLE => 1,
            Jobs::FD_FOLLOW_AT => JobUtility::DefaultFollowAt(),
            Jobs::FD_CREATE_AT => $date,
            Jobs::FD_UPDATE_AT => $date
        ];
        $l = Jobs::insert($d);
        return $l;
    }
    /**
    * auto generate doc.
    * @param Jobs $job
    * @return bool
    */
    public function isForemJobs(Jobs $job): bool
    {
        if (($user = JobUsers::GetCache(JobUsers::FD_ID, $job->user_id)) instanceof JobUsers) {
            $ids = self::GetOwnerForemReferenceJob($user);
            return in_array($job->id, $ids->keys);
        }
        return false;
    }
    /**
     * add a job to forem reference
     * @param Jobs $job 
     * @param string $reference 
     * @return null|bool|DataAdapterBase 
     */
    public function registerForemJob(Jobs $job, string $reference)
    {
        if (!is_numeric($reference)) {
            igk_die("only numeric value allowed");
        }
        $cl_ref = JobForemJobs::FD_REFERENCE;
        $reference = JobForemJobs::strPadValue($cl_ref, $reference);
        $cond = [JobForemJobs::FD_JOB_ID => $job->{Jobs::FD_ID}, $cl_ref => $reference];
        return JobForemJobs::insertIfNotExists($cond);
    }
    /**
    * auto generate doc.
    * @param JobUsers $user
    */
    public static function GetOwnerForemReferenceJob(JobUsers $user)
    {
        if ($ids = igk_getv(self::$sm_ownerForems, $user->id)) {
            return $ids;
        }
        $q = JobForemJobs::prepare(JobForemJobs::table())
            ->join([Jobs::table() => [Jobs::column(Jobs::FD_ID) . '=' . JobForemJobs::column(JobForemJobs::FD_JOB_ID)]])
            ->columns(
                array_merge(
                    Jobs::columnList('j_', DbUtils::OnlyColumnFilterRegex(implode("|", [
                        Jobs::FD_ID,
                        Jobs::FD_TITLE,
                        Jobs::FD_USER_ID
                    ]))),
                    JobForemJobs::columnOnlyArray(['prefix' => 'jref_', JobForemJobs::FD_ID, JobForemJobs::FD_REFERENCE])
                )
            )
            ->where([Jobs::column(Jobs::FD_USER_ID) => $user->id]);
        $keys = [];
        $pts = [];
        foreach ($q->query_fetch() as $row) {
            $keys[] = intval($row['j_id']);
            $pts[$row['j_id']] = $row;
        }
        $rows = $pts;
        $r = (object)compact('keys', 'rows');
        self::$sm_ownerForems[$user->id] = $r;
        return $r;
    }
    /**
    * auto generate doc.
    * @return mixed
    */
    public function selectAllUserJobApplication(JobUsers $user, ?string $search = null)
    {
        $cond = [];
        $options = [
            'OrderBy' => [
                Jobs::FD_CREATE_AT
            ],
        ];
        $cond[Jobs::FD_USER_ID] = $user->id;
        if ($search) {
            $cond[] = DbQueryCondition::Create([
                Jobs::FD_CREATE_AT => $search . '%',
                Jobs::FD_TITLE => $search
            ], DbQueryCondition::OP_OR);
        }
        return Jobs::select_all($cond, $options);
    }
    /**
    * auto generate doc.
    * @return {row: JobContacts, data: ContactDataInfo}
    */
    public function getContact($id)
    {
        $v = JobContacts::GetCache(JobContacts::primaryKey(), $id);
        return (object)['row' => $v, 'data' => Activator::CreateNewInstance(ContactDataInfo::class,  json_decode($v->data ?? '{}'))];
    }
    /**
    * auto generate doc.
    * @return string|void
    */
    public function getSourceTypeFromJob(Jobs $job)
    {
        if ($l = JobSourceTypes::GetCache(JobSourceTypes::FD_ID, $job->from_id)) {
            return $l->name;
        }
    }
    /**
    * auto generate doc.
    * @return mixed
    */
    public function listJobs($user, ?string $search = null)
    {
        $ad = Jobs::model()->getDataAdapter();
        $cond =     [
                'jbs_user_id' => $user->jbu_id
            ];
        if ($search) {
            $cond[] = DbQueryCondition::Create([
                '@@' . Jobs::FD_CREATE_AT => $ad->escape_string($search) . '%',
                '@@' . Jobs::FD_TITLE => '%' . $ad->escape_string($search) . '%',
            ], DbQueryCondition::OP_OR);
        }
        $r = Jobs::select_all($cond);
        return $r;
    }
    /**
    * auto generate doc.
    * @return void
    */
    public function storeJobDocument(Jobs $job, $s, JobDoctypes $responseType, $force_insert = false) {
            $cond = [
                JobDocs::FD_JOB_ID => $job->id,
                JobDocs::FD_JOB_DOC_TYPE_ID => $responseType->id,
            ];
            if (!$force_insert && ($hvi = JobDocs::select_row($cond))) {
                $hvi->{JobDocs::FD_VALUE} =  $s;
                $hvi->save();
            } else {
                $cond[JobDocs::FD_VALUE] = $s;
                JobDocs::insert($cond);
            }
    }
}