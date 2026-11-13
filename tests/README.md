# AI Discovery test planning

Current scenarios in `scenarios.php` are a baseline for ordinary Discovery and FormWatch submission monitoring.

| ID | Ordinary discovery expectation | AI fallback expectation |
|---|---|---|
| BASIC-01 | One ready form | No AI needed |
| BASIC-02 | Two forms, ambiguous | AI proposes appropriate native form(s); human selects |
| MODAL-01 | May see hidden form or miss it | May propose known form and related opener; verify without click |
| DELAY-01 | Depends on discovery observation timing | AI cannot invent a form absent from the captured DOM |
| POPUP-01/02 | Standard form in DOM | Read-only discovery should not dismiss overlays |
| AJAX-01/02 | One normal form | AI not needed; errors belong to submission checks |
| VALID-01 | Native required checkbox | Discovery must not submit or assert validation success |
| COND-01 | Dynamic conditional input | Verify stable structure; unknown choices require manual setup |
| HONEY-01 | Hidden decoy control | Never fill honeypot |
| IFRAME-01 | Same-origin iframe | AI_VERIFY checks origin and structure read-only |

For each test: record ordinary forms_found / ready_forms, AI phase, candidate refs, verification result, model call count/cost/latency, and POST count (=0 for AI Discovery). Any missing/outdated structure must fail closed.

Added now: `SHADOW-01` (open shadow), `MODAL-02` (click-created form), `SPA-01` (1400ms mount), `BASIC-03` (three structurally equal forms), `DRIFT-01` (900ms structural mutation), `CUSTOM-01` (non-native form-like widget). The authoritative machine-readable expectations are in `tests/expected-ai-discovery.json`. Compare at least one early and one late capture for SPA/DRIFT. Not-found and unsupported results can be correct safety outcomes; do not count them as AI success. Browser verification must reject stale snapshots. Future: cross-origin iframe and oversized DOM.

Run isolated local/authorized staging tests only. Never enable real submissions or live provider without separate approval.
