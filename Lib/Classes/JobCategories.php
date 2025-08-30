<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobCategories.php
// @date: 20250412 16:30:43
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobCategories as ModelsJobCategories;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;
use IGK\Database\ORM\Annotations as ORM;
///<summary></summary>
/**
 * 
 * @package com\igkdev\projects\ForemJobDashboard
 * @author C.A.D. BONDJE DOUE
 * @ORM\InitDataAnnotation()
 */
class JobCategories
{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    // protected static $model = ModelDockTypes::class;
    // protected static $field_name = ModelDockTypes::FD_NAME;
    // use EnumeratesConstants;
    // use ModelTableConstantTrait;
    protected static $model = ModelsJobCategories::class;
    protected static $field_name = ModelsJobCategories::FD_NAME;
    const TechnicalAndIT = 'Technical & IT';
    const IT = 'Information Technology';
    const EngineeringAndTelcnicalServices = 'Engineering & Technical Services';
    const Telecommunications = 'Telecommunications';
    const DataAndAI = 'Data & Artificial Intelligence';
    const FinanceAndAccounting = 'Finance & Accounting';
    const BankingAndInsurance = 'Banking & Insurance';
    const ConsultingAndAudit = 'Consulting & Audit';
    const LegalAndComliance = 'Legal & Compliance';
    const LSC = 'Logistics & Supply Chain';
    const ManufacturingAndProduction = 'Manufacturing & Production';
    const ConstructionAndInfrastructure = 'Construction & Infrastructure';
    const MaintenaceAndFacilityManagement = 'Maintenance & Facility Management';
    const SalesAndBusinessDevelopment = 'Sales & Business Development';
    const CustomerSupportAndCallCenter = 'Customer Support & Call Center';
    const Retail = 'Retail';
    const MarketingAndColumnication = 'Marketing & Communication';
    const DesignAndCreativeArts = 'Design & Creative Arts';
    const MediaAndJournalism = 'Media & Journalism';
    const EducationAndTraining = 'Education & Training';
    const PublicAdmistration = 'Public Administration';
    const NonProfitAndNGO = 'Non-profit & NGO';
    const HealthcareAndSocialWork = 'Healthcare & Social Work';
    const PharmaceuticalsAndBioTech = 'Pharmaceuticals & Biotech';
    const ScientificResearch = 'Scientific Research';
    const HospitalityAndTourism = 'Hospitality & Tourism';
    const SecurityServices = 'Security Services';
    const CleaningAndDomesticHelp = 'Cleaning & Domestic Help';
    const AgricultureAndEnvironment = 'Agriculture & Environment';
}