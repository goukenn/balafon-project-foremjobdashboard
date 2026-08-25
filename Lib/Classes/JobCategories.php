<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobCategories.php
// @date: 20250412 16:30:43
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobCategories as ModelsJobCategories;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;
use IGK\Database\ORM\Annotations as ORM;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
* @ORM\InitData()
*/
class JobCategories
{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $model = ModelsJobCategories::class;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $field_name = ModelsJobCategories::FD_NAME;
    /**
    * auto generate doc.
    * @var mixed
    */
    const TechnicalAndIT = 'Technical & IT';
    /**
    * auto generate doc.
    * @var mixed
    */
    const IT = 'Information Technology';
    /**
    * auto generate doc.
    * @var mixed
    */
    const EngineeringAndTelcnicalServices = 'Engineering & Technical Services';
    /**
    * auto generate doc.
    * @var mixed
    */
    const Telecommunications = 'Telecommunications';
    /**
    * auto generate doc.
    * @var mixed
    */
    const DataAndAI = 'Data & Artificial Intelligence';
    /**
    * auto generate doc.
    * @var mixed
    */
    const FinanceAndAccounting = 'Finance & Accounting';
    /**
    * auto generate doc.
    * @var mixed
    */
    const BankingAndInsurance = 'Banking & Insurance';
    /**
    * auto generate doc.
    * @var mixed
    */
    const ConsultingAndAudit = 'Consulting & Audit';
    /**
    * auto generate doc.
    * @var mixed
    */
    const LegalAndComliance = 'Legal & Compliance';
    /**
    * auto generate doc.
    * @var mixed
    */
    const LSC = 'Logistics & Supply Chain';
    /**
    * auto generate doc.
    * @var mixed
    */
    const ManufacturingAndProduction = 'Manufacturing & Production';
    /**
    * auto generate doc.
    * @var mixed
    */
    const ConstructionAndInfrastructure = 'Construction & Infrastructure';
    /**
    * auto generate doc.
    * @var mixed
    */
    const MaintenaceAndFacilityManagement = 'Maintenance & Facility Management';
    /**
    * auto generate doc.
    * @var mixed
    */
    const SalesAndBusinessDevelopment = 'Sales & Business Development';
    /**
    * auto generate doc.
    * @var mixed
    */
    const CustomerSupportAndCallCenter = 'Customer Support & Call Center';
    /**
    * auto generate doc.
    * @var mixed
    */
    const Retail = 'Retail';
    /**
    * auto generate doc.
    * @var mixed
    */
    const MarketingAndColumnication = 'Marketing & Communication';
    /**
    * auto generate doc.
    * @var mixed
    */
    const DesignAndCreativeArts = 'Design & Creative Arts';
    /**
    * auto generate doc.
    * @var mixed
    */
    const MediaAndJournalism = 'Media & Journalism';
    /**
    * auto generate doc.
    * @var mixed
    */
    const EducationAndTraining = 'Education & Training';
    /**
    * auto generate doc.
    * @var mixed
    */
    const PublicAdmistration = 'Public Administration';
    /**
    * auto generate doc.
    * @var mixed
    */
    const NonProfitAndNGO = 'Non-profit & NGO';
    /**
    * auto generate doc.
    * @var mixed
    */
    const HealthcareAndSocialWork = 'Healthcare & Social Work';
    /**
    * auto generate doc.
    * @var mixed
    */
    const PharmaceuticalsAndBioTech = 'Pharmaceuticals & Biotech';
    /**
    * auto generate doc.
    * @var mixed
    */
    const ScientificResearch = 'Scientific Research';
    /**
    * auto generate doc.
    * @var mixed
    */
    const HospitalityAndTourism = 'Hospitality & Tourism';
    /**
    * auto generate doc.
    * @var mixed
    */
    const SecurityServices = 'Security Services';
    /**
    * auto generate doc.
    * @var mixed
    */
    const CleaningAndDomesticHelp = 'Cleaning & Domestic Help';
    /**
    * auto generate doc.
    * @var mixed
    */
    const AgricultureAndEnvironment = 'Agriculture & Environment';
}