<?php
function fw_scenarios(): array { return require __DIR__ . '/scenarios.php'; }
function fw_scenario(string $id): ?array { $all = fw_scenarios(); return $all[$id] ?? null; }
function fw_h(string $v): string { return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function fw_debug_enabled(): bool { return isset($_GET['debug']) && $_GET['debug'] === '1'; }
function fw_form(string $testId, array $opts = []): string {
    $ajax = $opts['ajax'] ?? false;
    $endpoint = $opts['endpoint'] ?? '/api/submit.php';
    $extra = $opts['extra'] ?? '';
    $success = $opts['success'] ?? 'Thanks! Your request has been sent.';
    $attrs = $ajax ? ' data-ajax="1" data-endpoint="'.fw_h($endpoint).'" data-success="'.fw_h($success).'"' : ' action="'.fw_h($endpoint).'" method="post"';
    return '<form class="test-form"'.$attrs.'><input type="hidden" name="test_id" value="'.fw_h($testId).'">'
        .'<label>Name<input name="name" type="text" required autocomplete="off"></label>'
        .'<label>Email<input name="email" type="email" required autocomplete="off"></label>'
        .'<label>Phone<input name="phone" type="tel" autocomplete="off"></label>'
        .$extra
        .'<button type="submit">Send request</button><div class="form-status" aria-live="polite"></div></form>';
}
function fw_page_start(string $id, array $scenario): void {
    ?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=fw_h($id.' — '.$scenario['title'])?></title><link rel="stylesheet" href="/assets/style.css"></head><body>
    <main class="shell"><p><a href="/">← Test matrix</a></p><h1><?=fw_h($id)?></h1><p class="lead"><?=fw_h($scenario['title'])?></p>
    <?php if (fw_debug_enabled()): ?><aside class="debug"><strong>Human debug</strong><br>Expected: <?=fw_h($scenario['expected'])?><br>Level: <?=fw_h((string)$scenario['level'])?><br>Features: <?=fw_h(implode(', ', $scenario['features']))?></aside><?php endif; ?>
    <?php
}
function fw_page_end(): void { ?><script src="/assets/app.js"></script></main></body></html><?php }
