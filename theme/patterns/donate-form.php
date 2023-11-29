<?php
/**
 * Title: FoBV Donate Form
 * Slug: fobv/donate-form
 */
?>
<!-- wp:html {"lock":{"move":true,"remove":true}} -->
<form id="fobvDonateForm" action="/wp-admin/admin-post.php" method="post" enctype="application/x-www-form-urlencoded" novalidate>
<input type="hidden" name="action" value="fobv_donate">
<input type="hidden" name="fobv_donate_method" value="Online">
<!-- /wp:html -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-nonce-field action='fobv_donate' name='fobv_donate_nonce']
<!-- /wp:shortcode -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-transaction action='fobv_donate']
<!-- /wp:shortcode -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[fobv-payment-reference name='fobv_donate_reference']
<!-- /wp:shortcode -->

<!-- wp:paragraph -->
<p>Select the amount that you wish to donate and click "Next". If you want to make a larger donation by card you can Contact Us.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"templateLock":"all","lock":{"move":true,"remove":true},"style":{"spacing":{"blockGap":"0.5em"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:group {"templateLock":"all","lock":{"move":true,"remove":true},"style":{"spacing":{"blockGap":"0.25em"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-input-tag type='radio' id='fobvDonateAmount5' name='fobv_donate_amount' value='5']
<!-- /wp:shortcode -->

<!-- wp:html {"lock":{"move":true,"remove":true}} -->
<label for='fobvDonateAmount5'>£5</label>&nbsp;
<!-- /wp:html -->

<!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvDonateAmoun10' name='fobv_donate_amount' value='10']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for='fobvDonateAmount10'>£10</label>&nbsp;
<!-- /wp:html -->

<!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvDonateAmount20' name='fobv_donate_amount' value='20']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for='fobvDonateAmount20'>£20</label>&nbsp;
<!-- /wp:html -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-input-tag type='radio' id='fobvDonateAmount50' name='fobv_donate_amount' value='50']
<!-- /wp:shortcode -->

<!-- wp:html {"lock":{"move":true,"remove":true}} -->
<label for='fobvDonateAmount50'>£50</label>&nbsp;
<!-- /wp:html -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-input-tag type='radio' id='fobvDonateAmountOther' name='fobv_donate_amount' value='Other']
<!-- /wp:shortcode -->

<!-- wp:html {"lock":{"move":true,"remove":true}} -->
<label for='fobvDonateAmountOther'>Other</label>&nbsp;£
<!-- /wp:html -->

<!-- wp:shortcode -->
[vari-input-tag id="fobvDonateAmountOtherValue" name="fobv_donate_amount_other_value"]
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-label-tag name="fobv_donate_amount_other_value_error" class="error" for="fobv_donate_amount_other_value"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[vari-label-tag name="fobv_donate_amount_error" class="error" for="fobv_donate_amount"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:columns {"templateLock":"all","lock":{"move":true,"remove":true}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html -->
<label for="fobv_join_us_method">Payment Method:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvDonateMethodCheque' name='fobv_donate_method' value='Cheque']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvDonateMethodCheque">Cheque</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"lock":{"move":false,"remove":false}} -->
<p id="fobvDonateMethodChequeHelp">Cheques should be made payable to "The Friends of Bennerley Viaduct" and be posted to Castledine House, 5-9 Heanor Road, Ilkeston DE7 8DY. Please write the reference [fobv-payment-reference] on the back.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvDonateMethodBankTransfter' name='fobv_donate_method' value='Bank Transfer']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvDonateMethodBankTransfer">Bank Transfer</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"lock":{"move":false,"remove":false}} -->
<p id="fobvDonateMethodBankTransferHelp">Please instruct your bank transfer to:<br>Payee: Friends of Bennerley Viaduct<br>Account Number = 34642813<br>Sort Code = 40-19-15<br>Reference = [fobv-payment-reference clear='yes']</p>
<!-- /wp:paragraph -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvDonateMethodOnline' name='fobv_donate_method' value='Online' checked='yes']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvDonateMethodOnline">Online</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"lock":{"move":false,"remove":false}} -->
<p id="fobvDonateMethodOnlineHelp">When you click on Submit, you will be taken to a page to instruct your payment, either via PayPal or a credit or debit card.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph -->
<p>We would like to make contact with you to thank you personally for your donation. If you are okay for us to do that then please provide us with your email address. However, if you would rather not do so then you can leave this field blank.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"templateLock":"all","lock":{"move":true,"remove":true}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html {"lock":{"move":true,"remove":true}} -->
<label for="fobvDonateEmailAddress">Email Address:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column {"width":""} -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"0.5em"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-input-tag id="fobvDonateEmailAddress" name="fobv_donate_email_address" placholder="If you are okay for us to contact you, enter your email address"]
<!-- /wp:shortcode -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-label-tag name="fobv_donate_email_address_error" class="error" for="fobv_donate_email_address"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"templateLock":"all","lock":{"move":true,"remove":true}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html {"lock":{"move":true,"remove":true}} -->
<label for="fobvDonateConfirmEmailAddress">Confirm Email Address:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"0.5em"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-input-tag id="fobvDonateConfirmEmailAddress" name="fobv_donate_confirm_email_address" placehoder="Repeat any email address entered above to confirm it"]
<!-- /wp:shortcode -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-label-tag name="fobv_donate_confirm_email_address_error" class="error" for="fobv_donate_confirm_email_address"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:html {"lock":{"move":true,"remove":true}} -->
<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
<div class="wp-block-button"><button class="wp-element-button g-recaptcha" type="submit" data-sitekey="6LdpFqcZAAAAAKRjxMkXmIS3ABny6VUVlnbc9AcB" data-callback='onDonateSubmit' data-action='donate'>Next</button></div>
</div>
</form>
<script src="/wp-content/themes/fobv-site/assets/js/donate-form.js"></script>
<script>
  function onDonateSubmit(token) {
    document.getElementById("fobvDonateForm").submit();
  }
</script>
<!-- /wp:html -->
