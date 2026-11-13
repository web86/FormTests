#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
for f in index.php lib.php scenarios.php test.php router.php tests/ai-fixtures.php tests/render-ai-fixture.php api/*.php tests/iframe/form.php thank-you.php; do php -l "$f" >/dev/null; done
PORT="${FORMTESTS_TEST_PORT:-18886}"
LOG="$(mktemp)"
php -S "127.0.0.1:$PORT" -t . router.php >"$LOG" 2>&1 &
PID=$!
trap 'kill "$PID" 2>/dev/null || true; wait "$PID" 2>/dev/null || true; rm -f "$LOG"' EXIT
for n in 1 2 3 4 5 6 7 8 9 10; do
  curl -fsS "http://127.0.0.1:$PORT/" >/dev/null 2>&1 && break || sleep 0.2
done
for item in "BASIC-01:test-form" "BASIC-02:newsletter_email" "MODAL-01:open-modal" \
  "DELAY-01:delayed-template" "POPUP-01:cookie-banner" "POPUP-02:promo-close" \
  "AJAX-01:mode=success" "AJAX-02:mode=500" "VALID-01:name=\"privacy\"" \
  "COND-01:company-wrap" "HONEY-01:aria-hidden" "IFRAME-01:iframe/form.php" \
  "SHADOW-01:fw-shadow-host" "MODAL-02:fw-open-dynamic-modal" 'MODAL-03:aria-controls="contact-modal"' \
  "SPA-01:fw-spa-root" "BASIC-03:BASIC-03-SUPPORT" "DRIFT-01:fw-drift-zone" "CUSTOM-01:fw-custom-widget"; do
  id="${item%%:*}"; marker="${item#*:}"
  html="$(curl -fsS "http://127.0.0.1:$PORT/test/$id")"
  [[ "$html" == *"<h1>$id</h1>"* && "$html" == *"$marker"* ]] || { echo "FAIL $id"; exit 1; }
  echo "PASS route $id"
done
iframe="$(curl -fsS "http://127.0.0.1:$PORT/tests/iframe/form.php")"
[[ "$iframe" == *'value="IFRAME-01"'* ]]
[[ "$(curl -sS -o /dev/null -w '%{http_code}' "http://127.0.0.1:$PORT/tests/render-ai-fixture.php?id=DRIFT-01")" == 404 ]]
public_drift="$(curl -fsS "http://127.0.0.1:$PORT/test.php?id=DRIFT-01&fixtureVariant=changed")"
[[ "$public_drift" == *'data-stage="initial"'* && "$public_drift" == *'DRIFT-01-SECONDARY'* ]]
initial="$(php tests/render-ai-fixture.php DRIFT-01 initial)"
changed="$(php tests/render-ai-fixture.php DRIFT-01 changed)"
[[ "$initial" == *'data-stage="initial"'* && "$initial" == *'DRIFT-01-SECONDARY'* && "$initial" == *'name="email" type="email"'* ]]
[[ "$changed" == *'data-stage="changed"'* && "$changed" != *'DRIFT-01-SECONDARY'* && "$changed" == *'name="email" type="tel"'* ]]
echo "PASS isolated DRIFT-01 variants"
echo "PASS PHP syntax and HTTP routes; JS browser/AI runtime tests not included."
