# AI Discovery test planning

Current scenarios in `scenarios.php` are a baseline for ordinary Discovery and FormWatch submission monitoring.

| ID | Ordinary discovery expectation | AI fallback expectation |
|---|---|---|
| BASIC-01 | One ready form | No AI needed |
| BASIC-02 | Two forms, ambiguous | AI proposes appropriate native form(s); human selects |
| MODAL-01 | May see hidden form or miss it | Hidden form without a verified opener is not applicable |
| DELAY-01 | Depends on discovery observation timing | AI cannot invent a form absent from the captured DOM |
| POPUP-01/02 | Standard form in DOM | Read-only discovery should not dismiss overlays |
| AJAX-01/02 | One normal form | AI not needed; errors belong to submission checks |
| VALID-01 | Native required checkbox | Discovery must not submit or assert validation success |
| COND-01 | Dynamic conditional input | Verify stable structure; unknown choices require manual setup |
| HONEY-01 | Hidden decoy control | Never fill honeypot |
| IFRAME-01 | Same-origin iframe | AI_VERIFY checks origin and structure read-only |

For each test: record ordinary forms_found / ready_forms, AI phase, candidate refs, verification result, model call count/cost/latency, and POST count (=0 for AI Discovery). Any missing/outdated structure must fail closed.

The machine-readable expectations in `tests/expected-ai-discovery.json` cover Shadow DOM, delayed mounting, click-created forms, ambiguous ordinary results, structural drift, and non-native widgets. MODAL-03 adds a hidden native form with an explicit `aria-controls` opener. MODAL-01 is the negative control.

DRIFT-01 serves two forms on its ordinary URL. The CLI renderer provides `initial` and `changed` variants. In a local harness, serve the initial variant for Discovery, then switch the same run-specific URL to the changed variant before `AI_VERIFY`. The harness owns the phase switch. Browser verification must reject stale snapshots. From the FormWatch checkout, run the browser harness with:

```sh
FORMTESTS_FIXTURE_ROOT=/path/to/FormTests node --test apps/worker/test/formtests-ai-discovery.browser.test.mjs
```

Run isolated local/authorized staging tests only. Never enable real submissions or live provider without separate approval.
