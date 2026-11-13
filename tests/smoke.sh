#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
for f in index.php lib.php scenarios.php test.php router.php tests/ai-fixtures.php api/*.php tests/iframe/form.php thank-you.php; do php -l "$f" >/dev/null; done
PORT="${FORMTESTS_TEST_PORT:-18886}"
LOG="$(mktemp)"
php -S "127.0.0.1:$PORT" -t . router.php >"$LOG" 2>&1 &
PID=$!
trap 'kill "$PID" 2>/dev/null || true; wait "$PID" 2>/dev/null || true; rm -f "$LOG"' EXIT
for n in 1 2 3 4 5 6 7 8 9 10; do
  curl -fsS "http://127.0.0.1:$PORT/" >/dev/null 2>&1 && break || sleep 0.2
done
for item in "SHADOW-01:fw-shadow-host" "MODAL-02:fw-open-dynamic-modal" "SPA-01:fw-spa-root" "BASIC-03:BASIC-03-SUPPORT" "DRIFT-01:fw-drift-zone" "CUSTOM-01:fw-custom-widget"; do
  id="${item%%:*}"; marker="${item#*:}"
  curl -fsS "http://127.0.0.1:$PORT/test.php?id=$id" | grep -Fq "$marker" || { echo "FAIL $id"; exit 1; }
  echo "PASS route $id"
done
echo "PASS PHP syntax and HTTP routes; JS browser/AI runtime tests not included."
