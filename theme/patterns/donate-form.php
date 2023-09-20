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
[fobv-payment-reference name='fobv_donate_reference']
<!-- /wp:shortcode -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-nonce-field action='fobv_donate' name='fobv_donate_nonce']
<!-- /wp:shortcode -->

<!-- wp:paragraph -->
<p>Select the amount that you wish to donate and click "Next". If you want to make a larger donation by card you can Contact Us.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"templateLock":"all","lock":{"move":true,"remove":true},"style":{"spacing":{"blockGap":"0.5em"}},"layout":{"type":"flex","orientation":"vertical"}} -->
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
[vari-input-tag type='radio' id='fobvDonateAmount30' name='fobv_donate_amount' value='30' last='yes']
<!-- /wp:shortcode -->

<!-- wp:html -->
<label for='fobvDonateAmount30'>£30</label>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[vari-label-tag name="fobv_donate_amount_error" class="error" for="fobv_donate_amount"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p>We would like to make contact with you to thank you personally for your donation. If you are okay for us to do that then please provide us with your email address. However, if you would rather not do so then you can leave this field blank.</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
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

<!-- wp:columns -->
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
<div class="wp-block-button"><button class="wp-element-button" type="submit">Next</button></div>
</div>
</form>
<script src="/wp-content/themes/fobv-site/assets/js/donate-form.js"></script>
<!-- /wp:html -->
