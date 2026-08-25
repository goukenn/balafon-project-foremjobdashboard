<?php
// @author: C.A.D. BONDJE DOUE
// @file: routes.php
// @date: 20240904 08:59:56
use com\igkdev\projects\ForemJobDashboard\Actions\DocsAction;
use com\igkdev\projects\ForemJobDashboard\Actions\LoginAction;
use IGK\System\Http\Route;

Route::post(DocsAction::class, 'drop/{id}')
->where('id', '\d+');

// Login — password, TOTP 2FA and WebAuthn, explicitly bound (naming-convention dispatch
// would fall back to index() for these state-changing sub-actions).
Route::post(LoginAction::class, 'login/login2fa', [LoginAction::class, 'login2fa_post']);
Route::post(LoginAction::class, 'login/exists', [LoginAction::class, 'exists_post']);
Route::post(LoginAction::class, 'login/webauth_authenticate', [LoginAction::class, 'webauth_authenticate_post']);