<?php
// CLI-only renderer for isolated browser fixtures.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit(1);
}
[$script, $id, $fixtureVariant] = array_pad($argv, 3, null);
if (!in_array($id, ['SHADOW-01', 'SPA-01', 'BASIC-03', 'MODAL-01', 'MODAL-02', 'MODAL-03', 'DRIFT-01', 'CUSTOM-01'], true)
    || !in_array($fixtureVariant, [null, 'initial', 'changed'], true)
    || ($fixtureVariant === 'changed' && $id !== 'DRIFT-01')) {
    exit(2);
}
$_GET = ['id' => $id];
require dirname(__DIR__) . '/test.php';
