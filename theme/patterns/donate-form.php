<?php
/**
 * Title: FoBV Donate Form
 * Slug: fobv/donate-form
 */
?>
<!-- wp:group {"templateLock":"contentOnly","lock":{"move":true,"remove":true},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:html -->
<form id="fobvDonateForm" action="/wp-admin/admin-post.php" method="post" enctype="application/x-www-form-urlencoded" novalidate>
<input type="hidden" name="action" value="fobv_donate">
<input type="hidden" name="fobv_donate_method" value="Online">
<!-- /wp:html -->

<!-- wp:shortcode -->
[vari-nonce-field action='fobv_donate' name='fobv_donate_nonce']
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-transaction action='fobv_donate']
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[fobv-payment-reference name='fobv_donate_reference']
<!-- /wp:shortcode -->

<!-- wp:paragraph -->
<p>Select the amount that you wish to donate and click "Next". If you want to make a larger donation by card you can Contact Us.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.5em"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"0.25em"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvDonateAmount5' name='fobv_donate_amount' value='5']
<!-- /wp:shortcode -->

<!-- wp:html -->
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

<!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvDonateAmount50' name='fobv_donate_amount' value='50']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for='fobvDonateAmount50'>£50</label>&nbsp;
<!-- /wp:html -->

<!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvDonateAmountOther' name='fobv_donate_amount' value='Other']
<!-- /wp:shortcode -->

<!-- wp:html -->
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

<!-- wp:columns -->
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

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div id="fobvDonateMethodChequeHelp" class="wp-block-group"><!-- wp:block /--></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvDonateMethodBankTransfter' name='fobv_donate_method' value='Bank Transfer']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvDonateMethodBankTransfer">Bank Transfer</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div id="fobvDonateMethodBankTransferHelp" class="wp-block-group"><!-- wp:block /--></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvDonateMethodOnline' name='fobv_donate_method' value='Online' checked='yes']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvDonateMethodOnline">Online</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p id="fobvDonateMethodOnlineHelp">After you have clicked on Next and made a gift aid declaration or declined to do so, you will be taken to a page to instruct your payment, either via PayPal or a credit or debit card.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph -->
<p>We would like to make contact with you to thank you personally for your donation. If you are okay for us to do that then please provide us with your email address. However, if you would rather not do so then you can leave this field blank.</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html -->
<label for="fobvDonateEmailAddress">Email Address:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column {"width":""} -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"0.5em"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag id="fobvDonateEmailAddress" name="fobv_donate_email_address" placholder="If you are okay for us to contact you, enter your email address"]
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-label-tag name="fobv_donate_email_address_error" class="error" for="fobv_donate_email_address"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html -->
<label for="fobvDonateConfirmEmailAddress">Confirm Email Address:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"0.5em"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag id="fobvDonateConfirmEmailAddress" name="fobv_donate_confirm_email_address" placehoder="Repeat any email address entered above to confirm it"]
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-label-tag name="fobv_donate_confirm_email_address_error" class="error" for="fobv_donate_confirm_email_address"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:html -->
<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
<div class="wp-block-button">
<button id="fobvDonateFormSubmit" class="wp-element-button g-recaptcha" type="submit">Next</button>
</div>
</div>
</form>
<script src="/wp-content/themes/fobv-site/assets/js/donate-form.js"></script>
<!-- /wp:html --></div>
<!-- /wp:group -->
