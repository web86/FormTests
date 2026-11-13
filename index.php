<?php require __DIR__.'/lib.php'; $scenarios=fw_scenarios(); ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>FormWatch Testbed</title><link rel="stylesheet" href="/assets/style.css"></head><body><main class="shell wide">
<h1>FormWatch Testbed</h1><p class="lead">Controlled pages for browser discovery and form-submission regression testing.</p>
<table><thead><tr><th>ID</th><th>Category</th><th>Scenario</th><th>Level</th><th>Expected</th></tr></thead><tbody>
<?php foreach($scenarios as $id=>$s): ?><tr><td><a href="/test.php?id=<?=fw_h($id)?>"><?=fw_h($id)?></a></td><td><?=fw_h($s['category'])?></td><td><?=fw_h($s['title'])?></td><td><?=fw_h((string)$s['level'])?></td><td><code><?=fw_h($s['expected'])?></code></td></tr><?php endforeach; ?>
</tbody></table>
<p class="note">Add <code>?debug=1</code> to a scenario URL for human-only expectations. Do not use debug mode in FormWatch checks.</p>
</main></body></html>
