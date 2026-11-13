<?php
return [
    'BASIC-01' => ['category'=>'Basic','title'=>'Simple HTML form','level'=>1,'expected'=>'PASS','features'=>['native-form','native-submit']],
    'BASIC-02' => ['category'=>'Basic','title'=>'Two forms on one page','level'=>1,'expected'=>'PASS','features'=>['multiple-forms']],
    'MODAL-01' => ['category'=>'Modal','title'=>'Form opened by button','level'=>2,'expected'=>'PASS','features'=>['modal','user-trigger']],
    'DELAY-01' => ['category'=>'Dynamic','title'=>'Form mounted after 3 seconds','level'=>3,'expected'=>'PASS','features'=>['delayed-render']],
    'POPUP-01' => ['category'=>'Overlay','title'=>'Cookie banner covers submit area','level'=>3,'expected'=>'PASS','features'=>['cookie-banner','overlay']],
    'POPUP-02' => ['category'=>'Overlay','title'=>'Delayed promo popup during filling','level'=>4,'expected'=>'PASS','features'=>['delayed-popup','overlay']],
    'AJAX-01' => ['category'=>'Submit','title'=>'AJAX success without navigation','level'=>2,'expected'=>'PASS','features'=>['fetch','dom-success']],
    'AJAX-02' => ['category'=>'Backend','title'=>'AJAX HTTP 500','level'=>2,'expected'=>'SERVER_ERROR','features'=>['fetch','http-500']],
    'VALID-01' => ['category'=>'Validation','title'=>'Required checkbox blocks submit','level'=>2,'expected'=>'PASS','features'=>['required-checkbox','native-validation']],
    'COND-01' => ['category'=>'Conditional','title'=>'Select reveals required field','level'=>3,'expected'=>'PASS','features'=>['conditional-field','required']],
    'HONEY-01' => ['category'=>'Anti-spam','title'=>'Hidden honeypot must stay empty','level'=>3,'expected'=>'PASS','features'=>['honeypot']],
    'IFRAME-01' => ['category'=>'Iframe','title'=>'Form inside same-site iframe','level'=>3,'expected'=>'PASS','features'=>['iframe']],
];
