<?php
// @author: C.A.D. BONDJE DOUE
// @file: routes.php
// @date: 20240904 08:59:56
use com\igkdev\projects\ForemJobDashboard\Actions\DocsAction;
use IGK\System\Http\Route;

Route::post(DocsAction::class, 'drop/{id}')
->where('id', '\d+');