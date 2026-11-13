<?php
header('Cache-Control: no-store');
$mode = $_GET['mode'] ?? 'success';
$testId = (string)($_POST['test_id'] ?? 'UNKNOWN');

if ($testId === 'HONEY-01' && trim((string)($_POST['website'] ?? '')) !== '') {
    http_response_code(422);
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>'HONEYPOT_TRIGGERED']);
    exit;
}

$entry = [
    'time' => gmdate('c'),
    'test_id' => $testId,
    'session' => $_SERVER['HTTP_X_FORMWATCH_SESSION'] ?? null,
    'field_names' => array_keys($_POST),
    'user_agent' => substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''),0,250),
];
@file_put_contents(dirname(__DIR__).'/storage/submissions.log', json_encode($entry, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)."\n", FILE_APPEND|LOCK_EX);

if ($mode === '500') {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>'TEST_SERVER_ERROR']);
    exit;
}
if ($mode === '422') {
    http_response_code(422);
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>'TEST_VALIDATION_ERROR']);
    exit;
}
if ($mode === 'delay') { sleep(max(0,min(20,(int)($_GET['seconds'] ?? 5)))); }

$accept = $_SERVER['HTTP_ACCEPT'] ?? '';
if (str_contains($accept, 'application/json') || isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>true,'message'=>'Thanks! Your request has been sent.']);
    exit;
}
header('Location: /thank-you.php?test='.rawurlencode($testId), true, 303);
