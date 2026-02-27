<?php 
// @author: C.A.D. BONDJE DOUE
// @date: 20251112 14:38:45
namespace com\igkdev\projects\ForemJobDashboard\Models; 
use IGK\Models\ModelBase as Model;
use ForemJobDashboardController;

/**
* auto generate doc.
*/
abstract class ModelBase extends Model {
	/**
	 * source controller 
	 */
	protected $controller = \ForemJobDashboardController::class; 
}