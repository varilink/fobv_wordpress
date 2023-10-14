<?php
/**
 * Title: FoBV Subscribe Form
 * Slug: fobv/subscribe-form
 */
?>
<!-- wp:html {"lock":{"move":true,"remove":true}} -->
<form id="fobvSubscribeForm" action="/wp-admin/admin-post.php" method="post" enctype="application/x-www-form-urlencoded" novalidate>
<input type="hidden" name="action" value="fobv_subscribe">
<!-- /wp:html -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-nonce-field action='fobv_subscribe' name='fobv_subscribe_nonce']
<!-- /wp:shortcode -->

<!-- wp:columns {"style":{"spacing":{"margin":{"bottom":"0"}}}} -->
<div class="wp-block-columns" style="margin-bottom:0"><!-- wp:column {"verticalAlignment":"top","width":"8em"} -->
<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:8em"><!-- wp:html {"lock":{"move":true,"remove":true}} -->
<label for="fobvSubscribeEmailAddress">Email Address:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-input-tag id='fobvSubscribeEmailAddress' name='fobv_subscribe_email_address' placeholder='Enter your email address']
<!-- /wp:shortcode -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-label-tag name='fobv_subscribe_email_address_error' class='error' for='fobvSubscribeEmailAddress']
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"textColor":"custom-color-4","fontSize":"small"} -->
<p class="has-custom-color-4-color has-text-color has-small-font-size">We need this to send bulletins to you but will never share it with anyone else.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"style":{"spacing":{"margin":{"bottom":"0"}}}} -->
<div class="wp-block-columns" style="margin-bottom:0"><!-- wp:column {"verticalAlignment":"center","width":"8em"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:8em"><!-- wp:html {"lock":{"move":true,"remove":true}} -->
<label for="fobvSubscribeFirstName">First Name:</label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-input-tag id='fobvSubscribeFirstName' name='fobv_subscribe_first_name' placeholder='Optionally enter your first name']
<!-- /wp:shortcode -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-label-tag name='fobv_subscribe_first_name_error' class='error' for='fobvSubscribeFirstName']
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"textColor":"custom-color-4","fontSize":"small"} -->
<p class="has-custom-color-4-color has-text-color has-small-font-size">We may use this only to personalise emails to you.</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center","width":"8em"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:8em"><!-- wp:html {"lock":{"move":true,"remove":true}} -->
<label for="fobvSubscribeSurname">Surname:<label>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-input-tag id='fobvSubscribeSurname' name='fobv_subscribe_surname' placeholder='Optionally enter your surname']
<!-- /wp:shortcode -->

<!-- wp:shortcode {"lock":{"move":true,"remove":true}} -->
[vari-label-tag name='fobv_subscribe_email_error' class='error' for='fobvSubscribeSurname']
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"textColor":"custom-color-4","fontSize":"small"} -->
<p class="has-custom-color-4-color has-text-color has-small-font-size">We may use this only to personalise emails to you.</p>
<!-- /wp:paragraph -->

<!-- wp:html {"lock":{"move":true,"remove":true}} -->
<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
<div class="wp-block-button"><button class="wp-element-button" type="submit">Subscribe</button></div>
</div>
</form>
<script src="/wp-content/themes/fobv-site/assets/js/subscribe-form.js"></script>
<!-- /wp:html -->
