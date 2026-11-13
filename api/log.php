<?php
// Optional, operator-only diagnostics endpoint. Never publish test session metadata unauthenticated.
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
$token = getenv('FORMTESTS_LOG_TOKEN');
$provided = $_SERVER['HTTP_X_FORMTESTS_LOG_TOKEN'] ?? '';
if (!is_string($token) || $token === '' || !is_string($provided) || !hash_equals($token, $provided)) {
    http_response_code(404);
    echo json_encode(['error' => 'not_found']);
    exit;
}
$file = dirname(__DIR__) . '/storage/submissions.log';
$lines = is_file($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
$lines = array_slice($lines, -100);
echo '[' . implode(',', $lines) . ']';
