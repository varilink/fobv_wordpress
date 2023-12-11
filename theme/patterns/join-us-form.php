<?php
/**
 * Title: FoBV Join Us Form
 * Slug: fobv/join-us-form
 */
?>
<!-- wp:group {"templateLock":"contentOnly","lock":{"move":true,"remove":true},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:html -->
<form id="fobvJoinUsForm" action="/wp-admin/admin-post.php" method="post" enctype="application/x-www-form-urlencoded" novalidate>
<input type="hidden" name="action" value="fobv_join_us">
<!-- /wp:html -->

<!-- wp:shortcode -->
[vari-transaction action='fobv_join_us']
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-nonce-field action='fobv_join_us' name='fobv_join_us_nonce']
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[fobv-payment-reference name='fobv_join_us_reference']
<!-- /wp:shortcode -->

<!-- wp:paragraph -->
<p>Contact Details:</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html -->
<label for="fobvJoinUsFirstName">First Name:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:shortcode -->
[vari-input-tag id='fobvJoinUsFirstName' name='fobv_join_us_first_name' placeholder='Enter your first name']
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-label-tag name='fobv_join_us_first_name_error' for='fobvJoinUsFirstName' class='error']
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html -->
<label for="fobvJoinUsSurname">Surname:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:shortcode -->
[vari-input-tag id='fobvJoinUsSurname' name='fobv_join_us_surname' placeholder='Enter your surname']
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-label-tag name='fobv_join_us_surname_error' for='fobvJoinUsSurname' class='error']
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html -->
<label for="fobvJoinUsEmailAddress">Email Address:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:shortcode -->
[vari-input-tag id='fobvJoinUsEmailAddress' name='fobv_join_us_email_address' placeholder='Enter your email address']
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-label-tag name='fobv_join_us_email_address_error' for='fobvJoinUsEmailAddress' class='error']
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html -->
<label for="fobvJoinUsConfirmEmailAddress">Confirm Email Address:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:shortcode -->
[vari-input-tag id='fobvJoinUsConfirmEmailAddress' name='fobv_join_us_confirm_email_address' placeholder='Repeat your email address to confirm it']
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-label-tag name='fobv_join_us_confirm_email_address_error' for='fobvJoinUsConfirmEmailAddress' class='error']
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html -->
<label for="fobvJoinUsPostcode">Postcode:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:shortcode -->
[vari-input-tag id='fobvJoinUsPostcode' name='fobv_join_us_postcode' placeholder='Enter your postcode']
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-label-tag name='fobv_join_us_postcode_error' for='fobvJoinUsPostcode' class='error']
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html -->
<label for="fobvJoinUsTelephone">Telephone:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:shortcode -->
[vari-input-tag id='fobvJoinUsTelephone' name='fobv_join_us_telephone' placeholder='Optionally enter a contact telephone number']
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[vari-label-tag name='fobv_join_us_telephone_error' for='fobvJoinUsTelephone' class='error']
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph -->
<p>Payment:</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Please select your chosen payment amount and payment method. The payment amount is £10 or £50 depending on whether you wish to join/renew for one year or for life. In light of the current cost of living crisis, we are also offering the option to join/renew for one year for £5.</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"13em"} -->
<div class="wp-block-column" style="flex-basis:13em"><!-- wp:html -->
<label for="fobv_join_us_amount">Payment Amount:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvJoinUsAmount10' name='fobv_join_us_amount' value='10' checked='yes']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvJoinUsAmount10">£10 (One Year)</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvJoinUsAmount5' name='fobv_join_us_amount' value='5']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvJoinUsAmount5">£5 (One Year)</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvJoinUsAmount50' name='fobv_join_us_amount' value='50']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvJoinUsAmount50">£50 (Life)</label>
<!-- /wp:html --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

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
[vari-input-tag type='radio' id='fobvJoinUsMethodCheque' name='fobv_join_us_method' value='Cheque']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvJoinUsMethodCheque">Cheque</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div id="fobvJoinUsMethodChequeHelp" class="wp-block-group"><!-- wp:block /--></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvJoinUsMethodBankTransfter' name='fobv_join_us_method' value='Bank Transfer']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvJoinUsMethodBankTransfer">Bank Transfer</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div id="fobvJoinUsMethodBankTransferHelp" class="wp-block-group"><!-- wp:block /--></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:shortcode -->
[vari-input-tag type='radio' id='fobvJoinUsMethodOnline' name='fobv_join_us_method' value='Online' checked='yes']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for="fobvJoinUsMethodOnline">Online</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p id="fobvJoinUsMethodOnlineHelp">After you have clicked on Next and made a gift aid declaration or declined to do so, you will be taken to a page to instruct your payment, either via PayPal or a credit or debit card.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:html -->
<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
<div class="wp-block-button">
<button id="fobvJoinUsFormSubmit" class="wp-element-button g-recaptcha" type="submit">Next</button>
</div>
</div>
</form>
<script src="/wp-content/themes/fobv-site/assets/js/join-us-form.js"></script>
<!-- /wp:html --></div>
<!-- /wp:group -->
