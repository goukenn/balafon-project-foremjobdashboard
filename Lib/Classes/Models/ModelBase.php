<?php 
// @author: C.A.D. BONDJE DOUE
// @date: 20260824 18:09:05
namespace com\igkdev\projects\ForemJobDashboard\Models; 
use IGK\Models\ModelBase as Model;
use ForemJobDashboardController;


/** 
 */
abstract class ModelBase extends Model {
	/**
	 * source controller 
	 */
	protected $controller = \ForemJobDashboardController::class; 
}
