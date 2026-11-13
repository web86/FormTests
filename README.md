# FormWatch / FormTests

Controlled PHP + vanilla JavaScript testbed for form discovery, submission and AI fallback experiments.

**Live testbed:** https://testbed.web86.ru/  
**Related project:** https://github.com/web86/FormWatch

## Requirements and local run

- PHP 8.1+ (tested syntax target: PHP 8.4)
- Apache with mod_rewrite for pretty `/test/ID` routes; direct `/test.php?id=ID` works as well

```bash
php -S 127.0.0.1:8080 router.php
```

Open http://127.0.0.1:8080/.

## Included scenario families

- BASIC: native HTML and multiple forms
- MODAL: initially hidden form
- DELAY: form added to DOM after 3 seconds
- POPUP: cookie banner and delayed overlay
- AJAX: asynchronous success and HTTP 500
- VALID / COND: browser validation and conditional required fields
- HONEY: visually hidden honeypot
- IFRAME: same-origin iframe
- AI discovery fixtures: open Shadow DOM, click-created modal, SPA-like delayed form, ambiguous similar forms, DOM drift, non-native pseudo-form

Each scenario is listed in `scenarios.php` (19 scenarios total). Human-only expected outcomes are displayed with `?debug=1`; **never use debug mode for automated discovery**, since it adds answer hints to the page.

## AI Discovery evaluation

For each case, record: ordinary Discovery forms_found/ready_forms, whether AI fallback was triggered, safe snapshot available/truncated, model candidate refs, independent AI_VERIFY result, whether a human could apply the candidate to a draft, elapsed time and provider usage. AI Discovery is advisory and **must not submit** forms.

The initial comparisons include BASIC-02 (multiple competing forms), MODAL-01 (hidden form), DELAY-01 (late DOM), and IFRAME-01 (same-origin iframe). AI-focused fixtures cover SHADOW-01, MODAL-02, MODAL-03, SPA-01, BASIC-03, DRIFT-01, and CUSTOM-01. See [the test plan](tests/README.md) for the local Chromium harness. Run `bash tests/smoke.sh` for PHP syntax and HTTP routing across all 19 scenarios.

## Operational safety

- This repository intentionally excludes the archived `storage/submissions.log` and local `.envrc`.
- Generated logs are ignored by Git. `storage/` must be writable if submission logging is needed.
- `/api/log.php` requires the `FORMTESTS_LOG_TOKEN` environment variable and matching `X-FormTests-Log-Token` header. When unset, it returns 404. Do **not** embed the token in any frontend JS.
- `.htaccess` denies direct HTTP access to `storage/` and `*.log`. On non-Apache stacks, configure equivalent protection.
- The test submit endpoint intentionally creates local log records; use only synthetic input and only run actual submission tests on a controlled host.
- Deploying this repository to GitHub does **not** update the live testbed; deploy separately.

## License

No license is declared by this import.
