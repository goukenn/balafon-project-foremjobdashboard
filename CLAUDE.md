# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

`ForemJobDashboardController` is a BALAFON (PHP framework) **project** — a lightweight mini-app plugged into a host Balafon. It has no `composer.json`/`vendor` of its own — it is loaded and autoloaded by a host framework installation living outside this repo (referenced via `IGK_BASE_DIR` / `IGK_APP_DIR`, typically pointing at a `balafon_site_dev` checkout). All routing, ORM, views, hooks, and CLI (`balafon`) tooling come from that framework; this repo only supplies the module's controller, actions, models, views, and config.

The module manages job-search workflow: tracking job offers, applications (candidatures), enterprises/contacts, documents (CV/motivation letters), and imports from external job sites (e.g. FOREM).

## Running / testing

The only local build step is the Tailwind CSS pipeline (see *Front-end* below). Everything else runs through the `balafon` CLI provided by the host framework, and PHPUnit runs against the host framework's vendor directory.

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

The PHPUnit suite is `Lib/Tests/` (`ForemJobDashboardControllerTest.php`, `JobIdentifyTest.php`). Ad-hoc data/debug scripts live in `.test/` (git-ignored, so absent from a fresh checkout; not part of the PHPUnit suite — run individually via `balafon --run`). `Lib/Scripts/` holds runnable maintenance scripts (`download.php`, `store-enterprises.php`).

Project-tracking files at the root: `README.md` (feature overview), `TASK.md` (task list), `PROMPTS.md` (dated log of requirement changes — check it for the intent behind recent features). `balafon.config.json` declares the `required` modules (`igk/authentications/googleAuth2FA`, `igk/authentications/WebAuthn`), `default_user_profile: consultant` and the `workbench.cwd` of the host framework.

## Architecture

### Entry point
`ForemJobDashboardController.php` (root namespace) extends `IGK\Controllers\ApplicationController` and is the single controller for the module. It resolves per-user storage paths (`getOfferDir()`, `getResponseDir()` → `Data/store/<login>/db/{offers,response}/`), exposes a `FileService`, and forces session/auth via `forceSessionUris()`: `@/api/docs`, `@/api/*`, `@/login*` and the public legal pages `@/terms` and `@/privacy` are reachable without a session.

### Request flow: Actions
Business logic lives in `Lib/Classes/Actions/**`, one class per route group, extending `IGK\Actions\ActionBase`. Method naming convention drives HTTP dispatch:
- `index()` / `index_get()` — GET on the action's base route
- `index_post()`, `clear_docs_post()`, etc. — `<name>_post()` handles POST to `<name>`
- Typed parameters (e.g. `index(?Jobs $job = null)`) are framework-resolved model-binding — the framework loads the model instance from the route parameter.

Key action groups: `Jobs/` (edit, offer documents), `Build/` (CV/motivation letter generation), `Api/` (admin + default REST surface, Swagger-documented), `DocBuilder/`, plus top-level `EnterpriseAction`, `SettingsAction`, `StorageAction`, `CapsulateAction`, `DocsAction`.

Each Action generally has a matching `.phtml` view under `Views/<same-relative-path>/` (e.g. `Actions/Jobs/EditAction.php` ↔ `Views/jobs/edit.phtml`).

### Data layer
- **Models**: `Lib/Classes/Models/*.php` (**generated from the schema and git-ignored** — never edit or commit them; e.g. `Jobs`, `JobUsers`, `JobEnterprises`, `JobExternalForms`, `JobInterims`, `JobSearchEngines`, `JobFollows`, `JobMotivations`, `JobExperiences`), namespace `com\igkdev\projects\ForemJobDashboard\Models`, all extend the module's abstract `ModelBase` (`Lib/Classes/Models/ModelBase.php`), which itself extends the framework's `IGK\Models\ModelBase` and binds to `ForemJobDashboardController`. Models expose `FD_*` constants for column names (e.g. `Jobs::FD_USER_ID`) and static finders (`select_all()`, `select_row()`, `GetCache()`), used everywhere instead of raw SQL.
- **Schema**: `Data/data.schema.xml` is the single source of truth for tables — `<DataDefinition>` blocks describe columns/links/defaults, applied via the framework's schema/migration system (not hand-written SQL migrations). Table name constants are generated into `.db.constants.php` (`ForemJobDashboardControllerDbConstants`, prefix `tbigk_foremjobs_*`) — git-ignored and regenerated, never hand-edit it. To change columns/tables: edit `data.schema.xml` only, then run `balafon migrate`; the core regenerates the models and `FD_*` constants. A column change on an already-deployed table needs a `<Migration>` block, not just a `DataDefinition` edit. Schema conventions: no `cl` prefix on column names (use `id`, `title`, …; set the table-level `Prefix` attribute) and `<GenColumn name="updateTime">` instead of hand-written create/update columns; in code `Insert()` takes unprefixed names while conditions/updates use `FD_*`.
- **Factories / Import / Macros / Seeds**: `Lib/Classes/Database/{Factories,Import,Macros,Seeds}` — factories build model instances for tests/seeding, `Import/` handles mapping external job-site data into models, `Macros/` provide reusable query fragments, `Seeds/DataBaseSeeder.php` seeds reference data (categories, types, etc).

### Enums / lookup constants
Many small `abstract class ... { const ... }` lookup types at `Lib/Classes/*.php` (`JobDocTypes`, `ContractTypes`, `SourceTypes`, `StatusTypes`, `SkillTypes`, `EnumAuthorizations`, etc.) mirror corresponding `job_*_types` lookup tables in the schema and are resolved via `GetCacheData()` on the matching model (see `FileService::dirs()` for an example pairing `JobDocTypes` constants with model cache lookups).

### Hooks and cross-cutting behavior
`.global.php` registers framework event hooks at load time. Only `HOOK_USER_CLEAN` is active (cascades deletion of a user's `Jobs`/`JobUsers` rows when a platform user is purged); the `HOOK_WINUI_SETTING_MENU` registration (settings menu entry) is currently commented out. `Lib/Classes/FJDHooks.php` declares module-specific hook name constants — currently only `FOREM_JOB_DOC_DELETING` — for internal event dispatch.

Convention for hooks/filters shared globally across projects (from `PROMPTS.md`): name them `com.igkdev.sys://[filter|hook]/<action-type-path>` with a dedicated constant (e.g. `const FILTER_ACCOUNT_PLAN = 'com.igkdev.sys://filter/account/current-plan'`). A project exposing a hook passes args as `['ctrl' => $project, 'filter' => ..., ...exposed params]`.

### Front-end (Tailwind, layout, landing/legal pages)
- **Tailwind pipeline**: `npm run build` / `npm run watch` compiles `Lib/tailwind/styles.css` → `Data/assets/css/tailwind.css` (git-ignored — rebuild after pulling). `tailwind.config.js` uses the **`tw-` prefix** (always write `tw-*` classes to avoid collisions with the framework's dev CSS), `darkMode: ['selector', '[data-theme="dark"]']`, and scans `Views/**` (including dot-files `.*.pinc`) and `Articles/**` — so classes only generated inside those paths are emitted. The stylesheet is attached in `Views/.header.pinc`.
- **Shared layout includes** in `Views/`: `.header.pinc` (sticky 4-zone grid: title | menu | language + theme toggle | connection; burger menu with theme/language/user up to 1024px; language switch is an ajax POST on `<base>/<lang>`), `.menu.pinc` (trimmed main menu), `.menu.all.pinc` (full list, reused by the landing page "Quick access"), `.footer.pinc` (compact, links to legal pages), `.auth.pinc`. Client JS in `Scripts/main.js`. Theme-wide CSS stays in `Styles/default.pcss`.
- **Pages**: `Views/default.phtml` is the landing page (hero, stats, quick access, search engines, interims, tools), fed by `Actions/DefaultAction.php`. `Views/terms.phtml` and `Views/privacy.phtml` render the legal articles `Articles/terms.{en,fr,nl}.phtml` and `Articles/confidentiality.{en,fr,nl}.phtml`.
- **Follow-up**: `jobs.follow_at` (date, default today + 1 week via `JobUtility::DefaultFollowAt()`, set in `MainTaskModelUtility::addJob`) drives the list highlight in `Views/jobs/default.phtml` (due today = yellow, overdue = orange, hidden once status is `CLOSED`), the sort order in `Jobs/DefaultAction::_payload()`, the landing "to follow up" counter and the edit-form "Snooze +1 week" sub-action (`EditAction::snooze`). The old free-text `jobs.follow` is legacy and no longer used for highlighting.
- **KBO/BCE lookup**: `Services/KboService.php` scrapes the public Belgian registry page by enterprise number (`Normalize()` checks the modulo-97), `EnterpriseAction::kbo_post` returns JSON without storing anything, and `Views/enterprise/.kbo.pinc` (included by the add/edit forms) adds the "Fetch from KBO" button that fills the form for the user to review. Offline test fixture in `Lib/Tests/fixtures/`.
- **CV models**: a user keeps up to `CvModelService::MAX_MODELS` (5) saved CVs in `job_cv_models` (sanitized HTML, `%__key__%` placeholders, one default). `Services/CvModelService.php` owns list/save/delete/limit and the server-side whitelist `Sanitize()`; `Views/build/cv.phtml` dispatches `save`/`delete` through `igk_view_handle_actions` and lists the models (`?m=<id>` loads one). The editor itself is `Scripts/cvbuilder.js` (class `igk-winui-cv-textwyswyg` on a textarea, config in `igk:data`). A new table is created by `balafon --db:initdb ForemJobDashboardController` (`--db:migrate` only applies `<Migration>` blocks).
- **Calendar**: `Views/calendar/default.phtml` (`@/calendar`, `Actions/CalendarAction`) lists a user's appointments (`job_appointments`: interview/call/followup/recontact, optional offer, contact email, `remind_at` recall date, status planned/done/cancelled) with a "To recall" block (`CalendarService::Due`), snooze, and a `mailto:` "Resend mail" link (no SMTP). `CalendarAction` extends `ApiActionBase` (like `EnterpriseAction`), so mutations are plain `<name>_post()` handlers (`save`, `status`, `snooze`, `delete`, `token`) that redirect back to `@/calendar`; the view only renders and its forms POST to `@/calendar/<name>`. Sharing: `CalendarService::BuildIcs` produces the VCALENDAR; one event downloads from `@/calendar/ics?id=`, the whole calendar is a subscribable feed `@/calendar/feed?t=<token>` (token in `job_calendar_feeds`, regenerable) that is public by url (`forceSessionUris` allows `calendar/feed`), plus Google Calendar template/`cid` links and a `webcal://` link for Calendar.app. New tables: `balafon --db:initdb ForemJobDashboardController`.
- **Registration**: public `@/register` (`Actions/RegisterAction`, `Views/register/default.phtml`) creates an inactive `Users` row (`clStatus=-1`, login = optional custom login or the email, email kept in `job_registrations`) and mails a link `@/register/activate?t=<token>` valid 24h. `Services/RegistrationService.php` owns validation, token (only its sha256 is stored) and mailing (`igk_mail_sendmail`, injectable for tests); `Views/register/activate.phtml` activates and offers a resend through `igk_view_handle_actions`. Both URIs are allowed in `forceSessionUris`. New table: `balafon --db:initdb ForemJobDashboardController`.
- **Job edit extras**: `Jobs/EditAction` + `Views/jobs/edit.phtml` manage per-offer external site forms (domain, reference, url, notes; model `JobExternalForms`); `Jobs/MergeAction` builds the merged offers PDF through `IO/OfferArchivePDF.php` / `IO/PDFPrinter.php`, which includes the external form submission.

### Config
`Configs/` holds declarative config consumed by the framework: `routes.php` (extra explicit `Route::` registrations beyond action-name conventions), `profiles.php` (authorization profiles: `admin`/`provider`/`consultant`, referencing `EnumAuthorizations`), `swagger.php` (OAuth2-secured API docs metadata for `Api/*` actions), `views.php` (view overrides, currently empty).

### Storage
Per-user files (uploaded offer PDFs, generated response documents) are stored under `Data/store/<user-login>/db/{offers,response}/`, resolved through `ForemJobDashboardController::getOfferDir()`/`getResponseDir()` and read/deleted via `Services/FileService.php` — never construct these paths manually elsewhere.

### Localization
User-facing strings go through `igk_resources_gets` (aliased `__()`). Translated content lives in `Configs/Lang/lang.fr.presx` and in per-language article files `Articles/*.{en,fr,nl}.phtml`.

### Login / 2FA / WebAuthn
The module owns its own login flow at `@/login`, relying on the framework's default login page.

- **`Lib/Classes/Actions/LoginAction.php`** handles all steps: `index`/`index_post` (login+password, and the passwordless TOTP-code path when `secret` is posted), `exists_post` (step-1 identifier lookup — reports whether a login needs `2fa` and/or has `webauthn` credentials, without revealing which), `webauth_authenticate_post` (verifies a WebAuthn assertion and logs in), `login2fa_post` (verifies the TOTP code after password auth). Session key `fjd_2fa_verified_for` marks a guid as already having passed 2FA for the current session; `webauthn_authenication_challenge` holds the pending WebAuthn challenge between `exists_post` and `webauth_authenticate_post`.
- **`Lib/Classes/Helpers/TwoFactorAuth.php`** is a dependency-free RFC 6238 TOTP implementation (HMAC-SHA1, 30s step, 6 digits) operating on the `auth_2fa_key` column of the shared `users` table, plus QR-code enrollment via `igk/QrCode`.
- **`auth_2fa_key` is not this module's column** — it's added to the shared `%sysprefix%users` table by the host framework's `igk/authentications/googleAuth2FA` module. WebAuthn credential storage similarly comes from `igk/authentications/WebAuthn` (`igk\authentications\WebAuthn\Database\WebAuthnDbUtility`, backed by `lbuchs/webauthn`). Both are declared as `required` modules in `balafon.config.json` — this module adds **no schema migration** of its own for auth.
- **Views**: `Views/login/default.phtml` (multi-step password/2FA/WebAuthn form, Tailwind-styled, client-side step switching + `navigator.credentials.get()` via inline JS) and `Views/login/2fa.phtml` (standalone TOTP code entry after password auth). Both require `igk/Balafon/AdvancedComponent` for the `igk_html_node_password2FAComponent()` field widget.
- **2FA enrollment/disable** (as opposed to login itself) lives in `SettingsAction::security()` (renders the page, including re-deriving any pending-enrollment QR/secret from the session) plus `twofa_generate_post()`/`twofa_enable_post()`/`twofa_disable_post()` (pure side-effect methods — generate a secret, verify+persist it, or clear it). Those three are **not** reached via URL dispatch — see the `Views/jobs/edit.phtml`-style POST sub-action pattern below. `Views/settings/security.phtml` is the view (the settings menu hook in `.global.php` that linked to it is currently commented out).
- `Configs/routes.php` explicitly binds the login POST sub-actions (`login/login2fa`, `login/exists`, `login/webauth_authenticate`). Whether that binding is actually what makes them dispatch, or whether it's incidental (see below), wasn't fully pinned down — but it's proven to work live, so it was left alone rather than "fixed" into breaking. `ForemJobDashboardController::forceSessionUris()` allows any `@/login*` path unauthenticated (regex-matched, same pattern as the existing `@/api/*` allowance).

### POST sub-actions on a plain ActionBase: use igk_view_handle_actions(), not `<name>_post()` URL dispatch
Discovered live while wiring up the 2FA enroll/disable endpoints (`SettingsAction`, a plain `IGK\Actions\ActionBase`, like most Actions in this module — only `DocsAction` extends `MiddlewireActionBase`).

**The actual working pattern, already used throughout this module** (`Views/jobs/edit.phtml`'s `docs`/`contact` handlers, `Views/jobs/add.phtml`'s `store` handler, `Views/jobs/default.phtml`'s `search` handler): a form POSTs to `$ctrl::uri($fname . '/<subaction>')` (the *current view's own path* plus a sub-action segment, e.g. `settings/security/twofa_generate`), and the **view** — not the Action class's URL routing — dispatches it via `igk_view_handle_actions($fname, ['<subaction>' => function() { ... }], $params)` near the top of the `.phtml` file. The closure typically calls into the Action class for the actual side effect (`SettingsAction::CreateInstance($ctrl)->twofa_generate_post()`) and then `igk_navto($ctrl::uri($fname))` to redirect back (POST/redirect/GET) — see `Views/settings/security.phtml`.

Things that looked plausible but **do not work** for a plain `ActionBase` (verified live, not just inferred) — don't retry these:
- Defining `SettingsAction::twofa_generate_post()` and expecting a POST to `@/settings/twofa_generate` to hit it via naming-convention dispatch. It silently falls through to the controller's global default view instead — no exception, no log, just the wrong page back with HTTP 200.
- Adding an extra path segment (`@/settings/security/twofa_generate`, 3 segments instead of 2) on its own does **not** fix that — it just resolves to whatever method matches the *second* segment (`security()` here), with the trailing segment(s) ignored/passed as unused positional args. (An earlier version of this doc claimed the 3-segment shape alone was the fix — it isn't; `igk_view_handle_actions()` is what actually makes it work, and it happens to want that same 3-segment shape because the sub-action segment sits after the view's own path.)
- Explicitly binding `Route::post(SettingsAction::class, 'settings/twofa_generate', [SettingsAction::class, 'twofa_generate_post'])` in `Configs/routes.php`. The 3rd argument to `Route::get()`/`Route::post()`/etc. is **not** a handler binding for a plain `ActionBase` — passing `[SomeAction::class, 'some_method']` there does nothing toward making that method reachable (it appears to be for something like an access/redirect target, not a callable). `DocsAction::drop_post`'s working `Route::post('drop/{id}')` binding is not a counterexample to generalize from — that's a `MiddlewireActionBase`, a different dispatch path entirely.
- A `Views/settings/default.phtml` was still worth adding independent of all this — without *some* default view under the action's base, a POST to a path with no more specific matching view falls through to the controller's own global default instead of even reaching the action's base view. It didn't fix the dispatch problem above, but is a real fix in its own right and doubles as the `@/settings` landing page.

**Bottom line:** when a POST to an `ActionBase` action goes silently missing (200 response, but it's clearly the wrong page, no exception, no log), don't chase routing config — check whether the target method is written to be hit directly at all, or whether it needs to move behind `igk_view_handle_actions()` in the corresponding view instead.


## Styling

Each project provides a dark/light theme via `/Styles/themes/theme.{dark|light}.pcss`, overriding colors:

```php
$cl["accentColor"] = "red";
$cl["primararyColor"] = "gray";
$cl["--var-color"] = "red";
```

`Styles/default.pcss` loads automatically. See `%Lib%\Styles\igk_css_template.pcss` for `.pcss` conventions.

## Localisation

Default language is English (`en`). Translations at `/Configs/Lang/lang.{lang-code}.presx`. Wrap English
keys with `igk_resources_gets` (aliased `__`): `$t->div(__('Welcome to balafon'));`. Translate every key
into all supported languages.


## TESTING
- use `https://local.com:8085/forem` as endpoint for browser view
- create a test class with CLI command `balafon --make:class --test ClassNamePath` testing with phpunit some behaviour