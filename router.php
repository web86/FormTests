<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) return false;
if ($path === '/') { require __DIR__.'/index.php'; return; }
if (preg_match('#^/test/([A-Z0-9-]+)$#',$path,$m)) { $_GET['id']=$m[1]; require __DIR__.'/test.php'; return; }
http_response_code(404); echo 'Not found';
