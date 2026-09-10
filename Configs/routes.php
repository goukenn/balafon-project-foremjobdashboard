<?php
// @author: C.A.D. BONDJE DOUE
// @file: routes.php
// @date: 20240904 08:59:56
use com\igkdev\projects\ForemJobDashboard\Actions\DocsAction;
use com\igkdev\projects\ForemJobDashboard\Actions\LoginAction;
use IGK\System\Http\Route;

Route::post(DocsAction::class, 'drop/{id}')
->where('id', '\d+');

// Login — kept working via naming-convention dispatch (LoginAction is not a
// MiddlewireActionBase; see CLAUDE.md "Route:: gotchas for non-MiddlewireActionBase actions"
// — the 3rd argument below is NOT a handler binding, it's an access/redirect target, and is
// otherwise a no-op here since these entries duplicate what convention dispatch already does).
Route::post(LoginAction::class, 'login/login2fa', [LoginAction::class, 'login2fa_post']);
Route::post(LoginAction::class, 'login/exists', [LoginAction::class, 'exists_post']);
Route::post(LoginAction::class, 'login/webauth_authenticate', [LoginAction::class, 'webauth_authenticate_post']);

// NB: SettingsAction's twofa_generate_post/twofa_enable_post/twofa_disable_post are NOT bound
// here, and don't need to be — they're dispatched from Views/settings/security.phtml via
// igk_view_handle_actions(), not URL routing. See CLAUDE.md ("POST sub-actions on a plain
// ActionBase") for why URL-based dispatch to these doesn't work for a plain ActionBase.

