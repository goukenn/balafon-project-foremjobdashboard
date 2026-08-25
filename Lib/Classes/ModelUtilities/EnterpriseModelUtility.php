<?php
// @author: C.A.D. BONDJE DOUE
// @file: EnterpriseModelUtility.php
// @desc: module utility EnterpriseModelUtility
// @date: 20240913 19:03:01
namespace com\igkdev\projects\ForemJobDashboard\ModelUtilities;
use com\igkdev\projects\ForemJobDashboard\Models\JobContacts;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprisesContacts;
use com\igkdev\projects\ForemJobDashboard\Models\JobMessages;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use IGK\Database\IDbQueryResult;
use Exception;
use IGKDbModelUtility;
use IGKException;

/**
 * view entry point
 * @package com\igkdev\projects\ForemJobDashboard\ModelUtilities
 * @author C.A.D. BONDJE DOUE
 */
class EnterpriseModelUtility extends IGKDbModelUtility
{
    /**
     * return the primary model use by this database model utility 
     * @return JobEnterprises 
     */
    public function primary()
    {
        return JobEnterprises::model();
    }
    /**
    * auto generate doc.
    * @param string $name
    * @param null|string $vat
    */
    public function add(string $name, ?string $vat = null)
    {
        return $this->primary()->AddIfNotExists($name, $vat);
    }
    /**
    * auto generate doc.
    * @param JobEnterprises $model
    * @param JobContacts $contact
    */
    public function addContactTo(JobEnterprises $model, JobContacts $contact)
    {
        return JobEnterprisesContacts::model()->AddIfNotExists($model->id, $contact->id);
    }
    /**
     * enterprise contacts
     */
    public function getContacts(JobEnterprises $model)
    {
        $q = JobEnterprisesContacts::model()->prepare()
            ->columns(JobContacts::columnList())
            ->where([$model->column($model::FD_ID) => $model->id])
            ->join([JobContacts::table() => [
                JobContacts::column(JobContacts::FD_ID) . "=" . JobEnterprisesContacts::column(JobEnterprisesContacts::FD_CONTACT_ID)
            ]]);
        return $q->execute();
    }
    /**
    * auto generate doc.
    * @return bool|null|IDbQueryResult
    */
    public function getUserContacts(JobEnterprises $model, JobUsers $user)
    {
        $q = JobEnterprisesContacts::model()->prepare()
            ->columns(JobContacts::columnList())
            ->where([
                $model->column($model::FD_ID) => $model->id,
                $user->model($user::FD_ID) => $user->id
            ])
            ->join([JobContacts::table() => [
                JobContacts::column(JobContacts::FD_ID) . "=" . JobEnterprisesContacts::column(JobEnterprisesContacts::FD_CONTACT_ID)
            ]]);
        return $q->execute();
    }
    /**
     * registern enterprise
     * @param string $e 
     * @return mixed|void 
     */
    public function registerEnterprise(string $e){
        if ($e){
            $e = JobEnterprises::insertIfNotExists([JobEnterprises::FD_NAME=>$e]);
            if ($e){
                if ($e === true){
                    $e = JobEnterprises::last();
                }
               return $e->{JobEnterprises::FD_ID};
            } 
        } else {
            if ($e = JobEnterprises::GetCache(JobEnterprises::FD_NAME, $e, true)){
                return  $e->{JobEnterprises::FD_ID};
            } 
        }
    }
    /**
     * get offert documents 
     * @param mixed $id 
     * @return void 
     */
    public function getOffersDocumentToPrint($id){
        return null;
    }
    /**
     * retrieve enterprise offert reponse message 
     * @param int $id offer id
     * @return void 
     */
    public function getJobEnterpriseResponse($id){
        $c = JobMessages::select_all([
            JobMessages::FN_OFFER_ID()=>$id
        ]);
        return $c;
    }
}