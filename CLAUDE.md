# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

`ForemJobDashboard` is a **project module** for the IGK/"balafon" PHP application framework (`igk-php`), not a standalone app. It has no `composer.json`/`vendor` of its own — it is loaded and autoloaded by a host framework installation living outside this repo (referenced via `IGK_BASE_DIR` / `IGK_APP_DIR`, typically pointing at a `balafon_site_dev` checkout). All routing, ORM, views, hooks, and CLI (`balafon`) tooling come from that framework; this repo only supplies the module's controller, actions, models, views, and config.

The module manages job-search workflow: tracking job offers, applications (candidatures), enterprises/contacts, documents (CV/motivation letters), and imports from external job sites (e.g. FOREM).

## Running / testing

There is no local build step. Everything runs through the `balafon` CLI provided by the host framework, and PHPUnit runs against the host framework's vendor directory.

```sh
# initialize/seed the database for this module
balafon --db:initdb ForemjobDashboard
balafon --run .test/db/jobresearch/db-download.php --querydebug

# run the module's test suite (uses phpunit.xml.dist)
/Volumes/Data/Dev/PHP/balafon_site_dev/src/application/Packages/vendor/bin/phpunit --bootstrap Lib/Tests/autoload.php Lib/Tests

# watch mode (see phpunit-watcher.yml)
phpunit-watcher watch
```

`phpunit.xml.dist` sets `IGK_BASE_DIR`, `IGK_APP_DIR`, and `IGK_TEST_CONTROLER` env vars pointing at the host framework checkout — these paths are machine-specific (currently `/Volumes/Data/Dev/PHP/balafon_site_dev/...`). `Lib/Tests/autoload.php` bootstraps by locating `balafon.config.xml` up the directory tree and delegates to the framework's own test autoloader (`Lib/igk/Lib/Tests/autoload.php`).

Ad-hoc data/debug scripts live in `Lib/.tests/` (not part of the PHPUnit suite — run individually via `balafon --run`, e.g. `Lib/.tests/main.php`, `db/check.php`, `db/clean.desc.php`, `treatment.php`).

## Architecture

### Entry point
`ForemJobDashboardController.php` (root namespace) extends `IGK\Controllers\ApplicationController` and is the single controller for the module. It resolves per-user storage paths (`getOfferDir()`, `getResponseDir()` → `Data/store/<login>/db/{offers,response}/`), exposes a `FileService`, and forces session/auth on `@/api/docs` and `@/api/*` routes.

### Request flow: Actions
Business logic lives in `Lib/Classes/Actions/**`, one class per route group, extending `IGK\Actions\ActionBase`. Method naming convention drives HTTP dispatch:
- `index()` / `index_get()` — GET on the action's base route
- `index_post()`, `clear_docs_post()`, etc. — `<name>_post()` handles POST to `<name>`
- Typed parameters (e.g. `index(?Jobs $job = null)`) are framework-resolved model-binding — the framework loads the model instance from the route parameter.

Key action groups: `Jobs/` (edit, offer documents), `Build/` (CV/motivation letter generation), `Api/` (admin + default REST surface, Swagger-documented), `DocBuilder/`, plus top-level `EnterpriseAction`, `SettingsAction`, `StorageAction`, `CapsulateAction`, `DocsAction`.

Each Action generally has a matching `.phtml` view under `Views/<same-relative-path>/` (e.g. `Actions/Jobs/EditAction.php` ↔ `Views/jobs/edit.phtml`).

### Data layer
- **Models**: `Lib/Classes/Models/*.php`, namespace `com\igkdev\projects\ForemJobDashboard\Models`, all extend the module's abstract `ModelBase` (`Lib/Classes/Models/ModelBase.php`), which itself extends the framework's `IGK\Models\ModelBase` and binds to `ForemJobDashboardController`. Models expose `FD_*` constants for column names (e.g. `Jobs::FD_USER_ID`) and static finders (`select_all()`, `select_row()`, `GetCache()`), used everywhere instead of raw SQL.
- **Schema**: `Data/data.schema.xml` is the single source of truth for tables — `<DataDefinition>` blocks describe columns/links/defaults, applied via the framework's schema/migration system (not hand-written SQL migrations). Table name constants are generated into `.db.constants.php` (`ForemJobDashboardControllerDbConstants`, prefix `tbigk_foremjobs_*`) — this file is regenerated, don't hand-edit column/table names without updating the schema.
- **Factories / Import / Macros / Seeds**: `Lib/Classes/Database/{Factories,Import,Macros,Seeds}` — factories build model instances for tests/seeding, `Import/` handles mapping external job-site data into models, `Macros/` provide reusable query fragments, `Seeds/DataBaseSeeder.php` seeds reference data (categories, types, etc).

### Enums / lookup constants
Many small `abstract class ... { const ... }` lookup types at `Lib/Classes/*.php` (`JobDocTypes`, `ContractTypes`, `SourceTypes`, `StatusTypes`, `SkillTypes`, `EnumAuthorizations`, etc.) mirror corresponding `job_*_types` lookup tables in the schema and are resolved via `GetCacheData()` on the matching model (see `FileService::dirs()` for an example pairing `JobDocTypes` constants with model cache lookups).

### Hooks and cross-cutting behavior
`.global.php` registers framework event hooks at load time — e.g. `HOOK_WINUI_SETTING_MENU` (adds the module's settings menu entry) and `HOOK_USER_CLEAN` (cascades deletion of a user's `Jobs`/`JobUsers` rows when a platform user is purged). `Lib/Classes/FJDHooks.php` declares module-specific hook name constants (e.g. `FOREM_JOB_DOC_DELETING`) for internal event dispatch.

### Config
`Configs/` holds declarative config consumed by the framework: `routes.php` (extra explicit `Route::` registrations beyond action-name conventions), `profiles.php` (authorization profiles: `admin`/`provider`/`consultant`, referencing `EnumAuthorizations`), `swagger.php` (OAuth2-secured API docs metadata for `Api/*` actions), `views.php` (view overrides, currently empty).

### Storage
Per-user files (uploaded offer PDFs, generated response documents) are stored under `Data/store/<user-login>/db/{offers,response}/`, resolved through `ForemJobDashboardController::getOfferDir()`/`getResponseDir()` and read/deleted via `Services/FileService.php` — never construct these paths manually elsewhere.

### Localization
User-facing strings go through `igk_resources_gets` (aliased `__()`). Translated content lives in `Configs/Lang/lang.fr.presx` and in per-language article files `Articles/*.{en,fr,nl}.phtml`.

### Login / 2FA / WebAuthn
The module owns its own login flow at `@/login`, ported from the sibling `AssimilTraining` project's pattern rather than relying on the framework's default login page.

- **`Lib/Classes/Actions/LoginAction.php`** handles all steps: `index`/`index_post` (login+password, and the passwordless TOTP-code path when `secret` is posted), `exists_post` (step-1 identifier lookup — reports whether a login needs `2fa` and/or has `webauthn` credentials, without revealing which), `webauth_authenticate_post` (verifies a WebAuthn assertion and logs in), `login2fa_post` (verifies the TOTP code after password auth). Session key `fjd_2fa_verified_for` marks a guid as already having passed 2FA for the current session; `webauthn_authenication_challenge` holds the pending WebAuthn challenge between `exists_post` and `webauth_authenticate_post`.
- **`Lib/Classes/Helpers/TwoFactorAuth.php`** is a dependency-free RFC 6238 TOTP implementation (HMAC-SHA1, 30s step, 6 digits) operating on the `auth_2fa_key` column of the shared `users` table, plus QR-code enrollment via `igk/QrCode`.
- **`auth_2fa_key` is not this module's column** — it's added to the shared `%sysprefix%users` table by the host framework's `igk/authentications/googleAuth2FA` module. WebAuthn credential storage similarly comes from `igk/authentications/WebAuthn` (`igk\authentications\WebAuthn\Database\WebAuthnDbUtility`, backed by `lbuchs/webauthn`). Both are declared as `required` modules in `balafon.config.json` — this module adds **no schema migration** of its own for auth.
- **Views**: `Views/login/default.phtml` (multi-step password/2FA/WebAuthn form, Tailwind-styled, client-side step switching + `navigator.credentials.get()` via inline JS) and `Views/login/2fa.phtml` (standalone TOTP code entry after password auth). Both require `igk/Balafon/AdvancedComponent` for the `igk_html_node_password2FAComponent()` field widget.
- **2FA enrollment/disable** (as opposed to login itself) lives in `SettingsAction::security()`/`twofa_generate_post()`/`twofa_enable_post()`/`twofa_disable_post()` + `Views/settings/security.phtml`, linked from the settings menu in `.global.php`.
- `Configs/routes.php` explicitly binds the login POST sub-actions (`login/login2fa`, `login/exists`, `login/webauth_authenticate`) since naming-convention dispatch alone doesn't reliably route them. `ForemJobDashboardController::forceSessionUris()` allows any `@/login*` path unauthenticated (regex-matched, same pattern as the existing `@/api/*` allowance).
