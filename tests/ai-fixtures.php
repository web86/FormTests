<?php
// Deliberately adversarial Discovery-only fixtures. Do not run automatic submit.
switch ($id) {
case 'SHADOW-01':
    echo '<div id="fw-shadow-host"></div><template id="fw-shadow-template">'
        .'<style>form{display:grid;gap:12px;font-family:system-ui}input{display:block;padding:8px}button{padding:8px}</style>'
        .fw_form($id).'</template>';
    echo '<script>document.querySelector("#fw-shadow-host").attachShadow({mode:"open"}).append(document.querySelector("#fw-shadow-template").content.cloneNode(true));</script>';
    break;
case 'MODAL-02':
    // Template is inert: no native form in live DOM before click.
    echo '<button type="button" id="fw-open-dynamic-modal" aria-controls="fw-dynamic-modal" aria-expanded="false">Open contact form</button>'
        .'<div id="fw-dynamic-modal" class="modal" hidden></div>'
        .'<template id="fw-dynamic-template"><div class="modal-card"><button type="button" data-dynamic-close="1">Close</button><h2>Contact us</h2>'
        .fw_form($id).'</div></template>';
    echo '<script>(()=>{const b=document.querySelector("#fw-open-dynamic-modal"),m=document.querySelector("#fw-dynamic-modal");b.addEventListener("click",()=>{if(!m.dataset.created){m.append(document.querySelector("#fw-dynamic-template").content.cloneNode(true));m.dataset.created="1"}m.hidden=false;b.setAttribute("aria-expanded","true")});m.addEventListener("click",e=>{if(e.target.closest("[data-dynamic-close]")){m.hidden=true;b.setAttribute("aria-expanded","false")}})})();</script>';
    break;
case 'SPA-01':
    // Vanilla JS simulates client-side mounting; no React/Vue dependency.
    $html = json_encode(fw_form($id), JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_THROW_ON_ERROR);
    echo '<div id="fw-spa-root"><p>Loading contact widget...</p></div><script>setTimeout(()=>{const e=document.querySelector("#fw-spa-root");e.innerHTML='.$html.';e.dataset.mounted="1"},1400);</script>';
    break;
case 'BASIC-03':
    // Three equal structural DTOs: labels/headings are not part of safe AI input.
    foreach ([['Customer support','BASIC-03-SUPPORT'],['Partnership inquiry','BASIC-03-PARTNER'],['Request a quote','BASIC-03-QUOTE']] as [$heading,$testId]) {
        echo '<section class="competing-form"><h2>'.fw_h($heading).'</h2>'.fw_form($testId).'</section>';
    }
    break;
case 'DRIFT-01':
    // Explicit fixture variant. The local browser harness switches the served
    // variant between phases; the public route always starts with two forms.
    $changed = PHP_SAPI === 'cli' && ($fixtureVariant ?? null) === 'changed';
    $form = fw_form($id);
    echo '<div id="fw-drift-zone" data-stage="'.($changed ? 'changed' : 'initial').'"><h2>Contact</h2>'
        .($changed ? str_replace('name="email" type="email"', 'name="email" type="tel"', $form)
            : $form.'<h2>Newsletter</h2>'.fw_form('DRIFT-01-SECONDARY')).'</div>';
    break;
case 'MODAL-03':
    echo '<button type="button" id="open-contact-modal" aria-controls="contact-modal" aria-expanded="false">Contact us</button>'
        .'<div class="modal" id="contact-modal" hidden><div class="modal-card"><button type="button" id="close-contact-modal" aria-label="Close">×</button><h2>Contact form</h2>'
        .fw_form($id).'</div></div>';
    echo '<script>(()=>{const opener=document.querySelector("#open-contact-modal"),modal=document.querySelector("#contact-modal");'
        .'const setOpen=open=>{modal.hidden=!open;opener.setAttribute("aria-expanded",String(open))};'
        .'opener.addEventListener("click",()=>setOpen(true));document.querySelector("#close-contact-modal").addEventListener("click",()=>setOpen(false))})();</script>';
    break;
case 'CUSTOM-01':
    // Native form deliberately absent. Button only changes local text, never sends network request.
    echo '<div id="fw-custom-widget" role="form" aria-label="Custom contact widget" class="test-form">'
        .'<label>Name<input name="name" type="text" required></label><label>Email<input name="email" type="email" required></label>'
        .'<button type="button" id="fw-custom-send">Send request (local demo)</button>'
        .'<p id="fw-custom-status" role="status" aria-live="polite"></p></div>';
    echo '<script>document.querySelector("#fw-custom-send").addEventListener("click",()=>{document.querySelector("#fw-custom-status").textContent="Local UI only — no HTTP request sent."});</script>';
    break;
}
