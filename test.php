<?php
require __DIR__.'/lib.php';
$id = $_GET['id'] ?? '';
$s = fw_scenario($id);
if (!$s) { http_response_code(404); exit('Unknown test'); }
fw_page_start($id,$s);

switch ($id) {
case 'BASIC-01':
    echo fw_form($id);
    break;
case 'BASIC-02':
    echo '<section><h2>Newsletter</h2><form action="/api/submit.php" method="post"><input type="hidden" name="test_id" value="BASIC-02-NEWS"><label>Email<input type="email" name="newsletter_email" required></label><button type="submit">Subscribe</button></form></section><hr><section><h2>Contact us</h2>'.fw_form($id).'</section>';
    break;
case 'MODAL-01':
    echo '<button id="open-modal" type="button">Contact us</button><div class="modal" id="modal" hidden><div class="modal-card"><button class="modal-close" type="button" aria-label="Close">×</button><h2>Contact form</h2>'.fw_form($id).'</div></div>';
    break;
case 'DELAY-01':
    echo '<div id="delayed-root"><p>Loading contact widget…</p></div><template id="delayed-template">'.fw_form($id).'</template><script>setTimeout(()=>{document.querySelector("#delayed-root").innerHTML=document.querySelector("#delayed-template").innerHTML},3000)</script>';
    break;
case 'POPUP-01':
    echo fw_form($id).'<div class="cookie-banner" id="cookie-banner"><strong>Cookies</strong><span>This site uses cookies.</span><button id="accept-cookies" type="button">Accept</button></div>';
    break;
case 'POPUP-02':
    echo fw_form($id).'<div class="promo-modal" id="promo" hidden><div><button id="promo-close" type="button">Close ad</button><h2>Special offer</h2><p>Promo popup intentionally interrupts interaction.</p></div></div><script>setTimeout(()=>document.querySelector("#promo").hidden=false,2500)</script>';
    break;
case 'AJAX-01':
    echo fw_form($id,['ajax'=>true,'endpoint'=>'/api/submit.php?mode=success']);
    break;
case 'AJAX-02':
    echo fw_form($id,['ajax'=>true,'endpoint'=>'/api/submit.php?mode=500']);
    break;
case 'VALID-01':
    echo fw_form($id,['extra'=>'<label class="check"><input type="checkbox" name="privacy" value="1" required> I agree to the privacy policy</label>']);
    break;
case 'COND-01':
    echo fw_form($id,['extra'=>'<label>Topic<select name="topic" id="topic" required><option value="">Choose</option><option value="general">General question</option><option value="quote">Request a quote</option></select></label><div id="company-wrap" hidden><label>Company<input name="company" id="company"></label></div>']);
    echo '<script>document.addEventListener("change",e=>{if(e.target.id==="topic"){const w=document.querySelector("#company-wrap"),i=document.querySelector("#company");const on=e.target.value==="quote";w.hidden=!on;i.required=on;}})</script>';
    break;
case 'HONEY-01':
    echo fw_form($id,['extra'=>'<div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>']);
    break;
case 'IFRAME-01':
    echo '<iframe class="form-frame" src="/tests/iframe/form.php" title="Contact form"></iframe>';
    break;
case 'SHADOW-01': case 'MODAL-02': case 'MODAL-03': case 'SPA-01':
case 'BASIC-03': case 'DRIFT-01': case 'CUSTOM-01':
    require __DIR__.'/tests/ai-fixtures.php';
    break;
}
fw_page_end();
