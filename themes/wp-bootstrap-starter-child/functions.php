<?php

// Include php files
include get_theme_file_path('/includes/shortcodes.php');

// Enqueue needed scripts
function needed_styles_and_scripts_enqueue() {

    // Add-ons


    // Custom script
    wp_enqueue_script( 'wpbs-custom-script', get_stylesheet_directory_uri() . '/assets/javascript/script.js' , array( 'jquery' ) );

    // enqueue style
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );


}
add_action( 'wp_enqueue_scripts', 'needed_styles_and_scripts_enqueue' );

function cc_mime_types($mimes) {
$mimes['svg'] = 'image/svg+xml';
return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


add_filter( 'widget_text', 'do_shortcode' );

//Dynamic Year
function site_year(){
	ob_start();
	echo date( 'Y' );
	$output = ob_get_clean();
    return $output;
}
add_shortcode( 'site_year', 'site_year' );

/**
 *
 * Customisations follow. It may be possible to split these out in to different
 * files, e.g. as separate plugins.
 *
 * Customisation descriptions follow, further notes at the top of each
 * customisation section:
 * 1.  Function Overrides
 *     Override selected functions in the parents theme's template-tags.php
 *     using a child template-tags.php.
 * 2.  Bootstrap Styling
 *     Replace parent theme's bootstrap styles with my child version reflecting
 *     SAAS variations to the parent.
 * 3.  Call to Action Common Functions
 *     Functions that are common to at least two of the calls to action and so
 *     are defined in their own section.
 * 4.  Varilink Donations (varilink_donations)
 *     Implementation of the Varilink Donations call to action.
 * 5.  Varilink Join (varilink_join)
 *     Implementation of the Varilink Join call to action.
 * 6.  Varilink Renew (varilink_renew)
 *     Implementation of the Varilink Renew call to action.
 * 7.  Varilink Subscribe (varilink_subscribe)
 *     Implementation of the Varilink Subscribe call to action.
 * 8.  Varilink Gift Aid (varilink_gift_aid)
 *     Payment handling step to capture Gift Aid declarations
 * 9.  Custom Widgets
 *     Definition of a custom meta widget
 * 10. PayPal Webhook
 *     Functions to handle the PayPal Webhook callback via a REST API
 *
 */

// -----------------------------------------------------------------------------
// 1. Function Overrides
//
// Require my own template-tags.php child template file. There is a
// tempate-tags.php in the parent theme that defines several functions. My child
// template-tags.php file defines child theme versions of those functions where
// I want the behaviour to be different.

require ( 'inc/template-tags.php') ;

// -----------------------------------------------------------------------------
// 2. Bootstrap Styling
//
// Dequeue the parent theme's bootstrap stylesheet and enqueue my child version
// with whatever variations that I want instead.

function wp_bootstrap_starter_child_scripts ( ) {
  wp_dequeue_style ( 'wp-bootstrap-starter-bootstrap-css' ) ;
  wp_enqueue_style(
    'wp-bootstrap-starter-bootstrap-css' ,
    get_template_directory_uri ( ) . '-child/assets/css/bootstrap.min.css'
  );
}

add_action ( 'wp_enqueue_scripts' , 'wp_bootstrap_starter_child_scripts' ) ;

// -----------------------------------------------------------------------------
// 3. Call to Action Common Functions
//
// Functions that are common to two or more of the calls to action.

// A reference that is used for payments in fobv_join and fobv_renew
// calls to action
$reference = rand ( 10000001 , 99999999 ) ;

function fobv_start_form ( $form_id ) {

  // Function to return the opening <form> tag for any form

  return "
<form id=\"$form_id\" action=\"" . admin_url ( 'admin-post.php' ) . '" class="needs-validation" method="post" enctype="application/x-www-form-urlencoded" novalidate>' ;
}

function fobv_contact_details ( $instance ) {

  // Function to return form inputs to capture basic (name and email) contact
  // details for new or renewed memberships.

  return '
<div class="form-row mb-3">
  <label for="' . $instance . 'InputFirstName" class="col-3 pt-1">First Name:</label>
  <input id="' . $instance . 'InputFirstName" name="first_name" type="text" class="form-control col-9" placeholder="Enter your first name" aria-label="First Name" required>
  <div class="invalid-feedback">
    You must enter your first name
  </div>
</div>
<div class="form-row mb-3">
  <label for="' . $instance . 'InputSurname" class="col-3 pt-1">Surname:</label>
  <input id="' . $instance . 'InputSurname" name="surname" type="text" class="form-control col-9" placeholder="Enter your surname" aria-label="Surname" required>
  <div class="invalid-feedback">
    You must enter your surname
  </div>
</div>
<div class="form-row mb-3">
  <label for="' . $instance . 'InputEmailAddress" class="col-3 pt-1">Email Address:</label>
  <input id="' . $instance . 'InputEmailAddress" name="email" type="email" class="form-control col-9" placeholder="Enter your email address" aria-label="Email Address" required>
  <div class="invalid-feedback">
    You must enter a valid email address that you can be contacted via
  </div>
</div>
<div class="form-row">
  <label for="' . $instance . 'InputConfirmEmailAddress" class="col-3 pt-1">Confirm Email Address:</label>
  <input id="' . $instance . 'InputConfirmEmailAddress" name="confirm_email" type="email" class="form-control col-9" placeholder="Repeat your email address to confirm it" aria-label="Confirm Email Address" required>
  <div class="invalid-feedback">
    You must exactly match the email address that you entered above to confirm it
  </div>
</div>
' ;
}

function fobv_payment_details ( $instance ) {

  // Function to return form inputs to capture payment details for new or
  // renewed memberships.

  global $reference ;

  return '
<!-- Payment Details -->
<div class="row">
  <div class="col-sm-10 offset-sm-1 shadow p-3 mb-5 bg-white rounded">
    <p class="lead">Payment</p>
    <p>
      Please select your chosen payment amount and payment method. The payment amount is £5 or £50 depending on whether you wish to join/renew for one year or for life.
    </p>
    <fieldset class="form-group">
      <div class="row">
        <legend class="col-form-label col-sm-2">Payment Amount:</legend>
        <div class="col-sm-10 mt-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="amount" id="' . $instance . 'AnnualAmount" value="5" checked required>
            <label class="form-check-label" for="' . $instance . 'AnnualAmount">
              £5 (One Year)
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="amount" id="' . $instance . 'LifeAmount" value="50" required>
            <label class="form-check-label" for="' . $instance . 'AnnualAmount">
              £50 (Life)
            </label>
          </div>
        </div>
      </div>
    </fieldset>
    <fieldset class="form-group">
      <div class="row">
        <legend class="col-form-label col-sm-2">Payment Method:</legend>
        <div id="' . $instance . 'PaymentMethods" class="accordion col-sm-10 mt-2">
          <!-- Cash -->
          <div class="form-check">
            <input class="form-check-input" type="radio" name="method" id="' . $instance . 'InputCash" value="cash" data-toggle="collapse" data-target="#' . $instance . 'InputCashHelp" required>
            <label class="form-check-label" for="' . $instance . 'InputCash">
              Cash
            </label>
          </div>
          <div id="' . $instance . 'InputCashHelp" class="collapse" data-parent="#' . $instance . 'PaymentMethods">
            <p>
              Please give your cash payment to an officer of The Friends of Bennerley Viaduct when you first attend a membership meeting. Do not send cash payments through the post.
            </p>
          </div>
          <!-- /Cash -->
          <!-- Cheque -->
          <div class="form-check">
            <input class="form-check-input" type="radio" name="method" id="' . $instance . 'InputCheque" value="cheque" data-toggle="collapse" data-target="#' . $instance . 'InputChequeHelp" required>
            <label class="form-check-label" for="' . $instance . 'InputCheque">
              Cheque
            </label>
          </div>
          <div id="' . $instance . 'InputChequeHelp" class="collapse" data-parent="#' . $instance . 'PaymentMethods">
            <p>
              Cheques should be made payable to "The Friends of Bennerley Viaduct" and be posted to Castledine House, 5-9 Heanor Road, Ilkeston DE7 8DY. Please write the reference ' . $reference . ' on the back.
            </p>
          </div>
          <!-- /Cheque -->
          <!-- Bank Transfer -->
          <div class="form-check">
            <input class="form-check-input" type="radio" name="method" id="' . $instance . 'InputBankTransfer" value="bank_transfer" data-toggle="collapse" data-target="#' . $instance . 'InputBankTransferHelp" required>
            <label class="form-check-label" for="' . $instance . 'InputBankTransfer">
              Bank Transfer
            </label>
          </div>
          <div id="' . $instance . 'InputBankTransferHelp" class="collapse" data-parent="#' . $instance . 'PaymentMethods">
            <p>
              Please instruct your bank transfer to:<br>
              Payee = The Friends of Bennerley Viaduct<br>
              Account Number = 23286563<br>
              Sort Code = 60-11-37<br>
              and please use the reference ' . $reference . ' for the transaction.
            </p>
          </div>
          <!-- /Bank Transfer -->
          <!-- Online -->
          <div class="form-check">
            <input class="form-check-input" type="radio" name="method" id="' . $instance  . 'InputOnline" value="online" data-toggle="collapse" data-target="#' . $instance . 'InputOnlineHelp" checked required>
            <label class="form-check-label" for="' . $instance . 'InputOnline">
              Online
            </label>
          </div>
          <div id="' . $instance . 'InputOnlineHelp" class="collapse show" data-parent="#' . $instance . 'PaymentMethods">
            <p>
              When you click on Submit, you will be taken to a page to instruct your payment, either via PayPal or a debit or credit card.
            </p>
          </div>
          <!-- /Online -->
        </div>
      </div>
    </fieldset>
  </div>
</div>
' ;
}

function fobv_mailchimp_subscriber (
  $email , $first_name , $surname , $interests_in
) {

  // Returns Mailchimp merge_fields and optionally interests reflecting the
  // peculiarities of the FoBV setup whereby interests are used in test but in
  // live we use custom merge_fields.

  if ( $first_name != '' &&  $surname != '' ) {
    $merge_fields = [ 'FNAME' => $first_name , 'LNAME' => $surname ] ;
  } elseif ( $first_name != '' ) {
    $merge_fields = [ 'FNAME' => $first_name ] ;
  } elseif ( $surname != '' ) {
    $merge_fields = [ 'LNAME' => $surname ] ;
  } else {
    $merge_fields = [ ] ;
  }

  if ( $interests_in ) {

    // The subscriber has selected special interest categories

    if ( FOBV_MAILCHIMP_LIST_ID === FOBV_MAILCHIMP_TEST_LIST_ID ) {

      // This is the test list, use interest categories

      $keys = [
        FOBV_MAILCHIMP_MEMBERS_INTEREST_CATEGORY , FOBV_MAILCHIMP_VOLUNTEERING_INTEREST_CATEGORY
      ] ;

      if (
        in_array ( 'membership' , $interests_in , TRUE )
        &&
        in_array ( 'volunteering' , $interests_in , TRUE )
      ) {
        $interests_out = array_combine ( $keys , [ TRUE , TRUE ] ) ;
      } elseif (
        in_array ( 'membership' , $interests_in , TRUE )
      ) {
        $interests_out = array_combine ( $keys , [ TRUE , FALSE ] ) ;
      } else {
        $interests_out = array_combine ( $keys , [ FALSE , TRUE ] ) ;
      }

    } else {

      // The is the live list, use custom merge fields to capture interests

      if (
        in_array ( 'membership' , $interests_in , TRUE )
        &&
        in_array ( 'volunteering' , $interests_in , TRUE )
      ) {
        $merge_fields [ FOBV_MAILCHIMP_MEMBERS_MERGE_FIELD ] = 'interested' ;
        $merge_fields [ FOBV_MAILCHIMP_VOLUNTEERING_MERGE_FIELD ] = 'interested' ;
      } elseif ( in_array ( 'membership' , $interests_in , TRUE ) ) {
        $merge_fields [ FOBV_MAILCHIMP_MEMBERS_MERGE_FIELD ] = 'interested' ;
      } else {
        $merge_fields [ FOBV_MAILCHIMP_VOLUNTEERING_MERGE_FIELD ] = 'interested' ;
      }

    }

  } elseif ( FOBV_MAILCHIMP_LIST_ID === FOBV_MAILCHIMP_TEST_LIST_ID ) {

    // The subscriber has NOT selected special interest categories and we're using the test list so we need to reflect this in the interests

    $interests_out = [
      FOBV_MAILCHIMP_MEMBERS_INTEREST_CATEGORY => FALSE ,
      FOBV_MAILCHIMP_VOLUNTEERING_INTEREST_CATEGORY => FALSE
    ] ;

  }

  if ( $interests_out ) {
    // return [ $interests_out , $merge_fields ] ;
    return [ $merge_fields ] ;
  } else {
    unset ( $merge_fields [ FOBV_MAILCHIMP_MEMBERS_MERGE_FIELD ] ) ;
    unset ( $merge_fields [ FOBV_MAILCHIMP_VOLUNTEERING_MERGE_FIELD ] ) ;
    return [ $merge_fields ] ;
  }

}

function fobv_membership_handle_form ( ) {

  if ( function_exists ( 'varilink_write_log' ) ) {
    ob_start ( ) ;
    var_dump ( $_POST ) ;
    $post = ob_get_clean ( ) ;
    varilink_write_log ( $post ) ;
  }

  // Common inputs. These are submitted by both join and renew actions.
  $email = $_POST [ 'email' ] ;
  $first_name = $_POST [ 'first_name' ] ;
  $amount = $_POST [ 'amount' ] ;
  $method = $_POST [ 'method' ] ;
  $reference = $_POST [ 'reference' ] ;
  $surname = $_POST [ 'surname' ] ;
  $gift_aid = $_POST [ 'gift_aid' ] ;

  if ( function_exists ( 'varilink_write_log' ) ) {
    varilink_write_log ( "About to determine notification email recipient" ) ;
    varilink_write_log ( 'FOBV_OVERRIDE_EMAIL:' ) ;
    varilink_write_log ( FOBV_OVERRIDE_EMAIL ) ;
  }

  // Environment values for the confirmation email to the membership secretary.
  $to = (
    preg_match ( FOBV_OVERRIDE_EMAIL , $email )
      ? $email
      : FOBV_MEMBERSHIP_EMAIL . ',' . FOBV_TREASURER_EMAIL . ',' . FOBV_MAILCHIMP_EMAIL
  ) ;

  if ( function_exists ( 'varilink_write_log' ) ) {
    varilink_write_log ( "Notification email recipient=$to" ) ;
  }

  $subject = (
    FOBV_ENV === 'prod'
      ? 'Membership Action Notification'
      : '[TEST] Membership Action Notification'
  ) ;
  $contact_details =
    "Contact Details\r\n" .
    "---------------\r\n" .
    "First Name: $first_name\r\n" .
    "Surname: $surname\r\n" .
    "Email Address: $email\r\n" ;
  $payment =
    "Payment\r\n" .
    "-------\r\n" .
    "Amount: $amount\r\n" .
    "Method: $method\r\n" .
    "Reference: $reference\r\n" ;

  // Send membership welcom email

  function wpdocs_set_html_mail_content_type ( ) {
    return 'text/html';
  }

  add_filter ( 'wp_mail_content_type' , 'wpdocs_set_html_mail_content_type' ) ;

  $message =
    '<p>Thank you for either joining or renewing your membership to the Friends of Bennerley Viaduct. Please find below a link to information about our group which you may find helpful. If you have any questions about the group and how we work, please do not hesitate to get in contact with me.</p>' .
    '<a href="https://bennerleyviaduct.us12.list-manage.com/track/click?u=c7b4f78d87142e3b04cd3a365&id=a509ec4720&e=a1acb9eb6a">Membership Information</a>' .
    '<p>Adrian Chatfield<br>Membership Secretary</p>' .
    '<a href="mailto://membership@bennerleyviaduct.org.uk">membership@bennerleyviaduct.org.uk</a>' ;

  wp_mail ( $email , 'Welcome to the Friends of Bennerley Viaduct' , $message , array ( 'Reply-To: membership@bennerleyviaduct.org.uk' ) ) ;

  remove_filter ( 'wp_mail_content_type' , 'wpdocs_set_html_mail_content_type' ) ;

  if ( !$age && !$gender ) {

    // This is a renew

    $message =
      "Membership renewal captured via the website as follows\r\n" .
      "\r\n" .
      $contact_details .
      "\r\n"  .
      $payment ;

    if ( $gift_aid === 'on' ) {

      $address1 = $_POST [ 'address1' ] ;
      $address2 = $_POST [ 'address2' ] ;
      $address3 = $_POST [ 'address3' ] ;
      $address4 = $_POST [ 'address4' ] ;
      $postcode = $_POST [ 'postcode' ] ;

      $message .=
        "\r\n" .
        "\r\n" .
        "The member elected for Gift Aid to be collected in respect of their membership fee and provided the following address:\r\n" .
        "Address Line 1: $address1\r\n" .
        "Address Line 2: $address2\r\n" .
        "Address Line 3: $address3\r\n" .
        "Address Line 4: $address4\r\n" .
        "Postcode: $postcode\r\n" ;

    } else {

      $message .=
        "\r\n" .
        "\r\n" .
        'The member did NOT elect for Gift Aid to be collected in respect of their membership fee.' ;

    }

  } else {

    // Inputs specific to a join, i.e. not a renew.
    $address1 = $_POST [ 'address1' ] ;
    $address2 = $_POST [ 'address2' ] ;
    $address3 = $_POST [ 'address3' ] ;
    $address4 = $_POST [ 'address4' ] ;
    $postcode = $_POST [ 'postcode' ] ;
    $gender = $_POST [ 'gender' ] ;
    $age_group = $_POST [ 'age_group' ] ;

    $message =
      "New member captured via the website as follows\r\n" .
      "\r\n" .
      $contact_details .
      "Address Line 1: $address1\r\n" .
      "Address Line 2: $address2\r\n" .
      "Address Line 3: $address3\r\n" .
      "Address Line 4: $address4\r\n" .
      "Postcode: $postcode\r\n" .
      "\r\n"  .
      "Demographic\r\n" .
      "-----------\r\n" .
      "Gender: $gender\r\n" .
      "Age Group: $age_group\r\n" .
      "\r\n" .
      $payment ;

    if ( $gift_aid === 'on' ) {

      $message .=
        "\r\n" .
        "\r\n" .
        'The new member elected for Gift Aid to be collected in respect of their membership fee.' ;

    } else {

      $message .=
        "\r\n" .
        "\r\n" .
        'The new member did NOT elect for Gift Aid to be collected in respect of their membership fee.' ;

    }

  }

  // Check if member (join or renew) is subscribed to the Mailchimp bulletin
  // and with an interest in membership news indicated.

  if ( FOBV_MAILCHIMP_LIST_ID === FOBV_MAILCHIMP_TEST_LIST_ID ) {
    $fields = 'status,interests' ;
  } else {
    $fields = 'status,merge_fields' ;
  }

  $response = varilink_mailchimp_information_about_a_list_member (
    FOBV_MAILCHIMP_API_KEY ,
    FOBV_MAILCHIMP_API_ROOT ,
    FOBV_MAILCHIMP_LIST_ID ,
    $email ,
    $fields
  ) ;

  if ( $response ) {

    if ( function_exists ( 'varilink_write_log' ) ) {
      varilink_write_log (
        'New/renewing memember in Mailchimp list as follows:'
      ) ;
      ob_start ( ) ;
      var_dump ( $response ) ;
      varilink_write_log ( ob_get_clean ( ) ) ;
    }

    function interested_in_volunteering ( $response ) {

      $return = FALSE ;

      if ( FOBV_MAILCHIMP_LIST_ID === FOBV_MAILCHIMP_TEST_LIST_ID ) {

        $volunteering = FOBV_MAILCHIMP_VOLUNTEERING_INTEREST_CATEGORY ;
        $return = $response -> interests -> $volunteering ;

      } else {

        $volunteering = FOBV_MAILCHIMP_VOLUNTEERING_MERGE_FIELD ;

        if (
          $response -> merge_fields -> $volunteering != ''
        ) {
          $return = TRUE ;
        }

      }

      return $return ;

    }

    if ( $response -> status === 'subscribed' ) {

      // Member is already subscribed, just make sure that membership interests
      // are selected.

      if ( interested_in_volunteering ( $response ) ) {
        if ( function_exists ( 'varilink_write_log' ) ) {
          varilink_write_log ( 'Subscribed member interested in volunteering') ;
        }
        $interests = [ 'volunteering' , 'membership' ] ;
      } else {
        $interests = [ 'membership' ] ;
        if ( function_exists ( 'varilink_write_log' ) ) {
          varilink_write_log ( 'Subscribed member NOT interested in volunteering') ;
        }
      }

      $subscriber = fobv_mailchimp_subscriber (
        $email , $first_name , $surname , $interests
      ) ;

      $merge_fields = array_pop ( $subscriber ) ;

      $request = [
        'email_address' => $email ,
        'status_if_new' => 'subscribed' , // Can't be new, should use patch API
        'status' => 'subscribed' ,
        'merge_fields' => $merge_fields
      ] ;

      if ( $subscriber ) { $request [ 'interests' ] = array_pop ( $subscriber ) ; }

      varilink_mailchimp_add_or_update_list_member (
        FOBV_MAILCHIMP_API_KEY ,
        FOBV_MAILCHIMP_API_ROOT,
        FOBV_MAILCHIMP_LIST_ID ,
        $request
      ) ;

      $message .=
        "\r\n" .
        "\r\n" .
        'The member was already subscribed to our Mailchimp list. Their subscription has been tagged with an interest in membership news, if it wasn\'t already.';

    } elseif ( $response -> status === 'unsubscribed' ) {

    } elseif ( $response -> status === 'cleaned' ) {

    } elseif ( $response -> status === 'pending' ) {

      // Member has a pending subscription.

      if ( interested_in_volunteering ( $response ) ) {
        if ( function_exists ( 'varilink_write_log' ) ) {
          varilink_write_log ( 'Pending member interested in volunteering') ;
        }
        $interests = [ 'volunteering' , 'membership' ] ;
      } else {
        $interests = [ 'membership' ] ;
        if ( function_exists ( 'varilink_write_log' ) ) {
          varilink_write_log ( 'Pending member NOT interested in volunteering') ;
        }
      }

      $subscriber = fobv_mailchimp_subscriber (
        $email , $first_name , $surname , $interests
      ) ;

      $merge_fields = array_pop ( $subscriber ) ;

      $request = [
        'email_address' => $email ,
        'status_if_new' => 'pending' ,
        'status' => 'pending' ,
        'merge_fields' => $merge_fields
      ] ;

      if ( $subscriber ) { $request [ 'interests' ] = array_pop ( $subscriber ) ; }

      varilink_mailchimp_add_or_update_list_member (
        FOBV_MAILCHIMP_API_KEY ,
        FOBV_MAILCHIMP_API_ROOT,
        FOBV_MAILCHIMP_LIST_ID ,
        $request
      ) ;

      $message .=
        "\r\n" .
        "\r\n" .
        'The member already had a PENDING subscription to our Mailchimp list. Their subscription has been tagged with an interest in membership news, if it wasn\'t already, and a reminder to confirm their subscription has been sent to them.';

    } elseif ( $response -> status === 'transactional' ) {

    }
  } else {

    if ( function_exists ( 'varilink_write_log' ) ) {
      varilink_write_log ( 'New/renewing memember NOT in Mailchimp list:' ) ;
    }

    // Member is not a subscriber

    $interests = [ 'membership' ] ;

    $subscriber = fobv_mailchimp_subscriber (
      $email , $first_name , $surname , $interests
    ) ;

    $merge_fields = array_pop ( $subscriber ) ;

    $request = [
      'email_address' => $email ,
      'status_if_new' => 'pending' ,
      'status' => 'pending' ,
      'merge_fields' => $merge_fields
    ] ;

    if ( $subscriber ) { $request [ 'interests' ] = array_pop ( $subscriber ) ; }

    varilink_mailchimp_add_or_update_list_member (
      FOBV_MAILCHIMP_API_KEY ,
      FOBV_MAILCHIMP_API_ROOT,
      FOBV_MAILCHIMP_LIST_ID ,
      $request
    ) ;

    $message .=
      "\r\n" .
      "\r\n" .
      'The member is not a subscriber to our Mailchimp list. A PENDING subscripiton, including an interest in membership news has been created and they have been sent an email asking them to confirm their subscription.';

  }

  // Send notification email

  $headers = 'From: ' . FOBV_EMAIL_SENDER ;
  wp_mail ( $to , $subject , $message , $headers ) ;

  if ( function_exists ( 'varilink_write_log' ) ) {
    varilink_write_log ( "Email with subject $subject sent to $to" ) ;
  }

  // Take payment immediately if the payment method is online

  if ( $method === 'online' ) {

    $access_token = varilink_paypal_get_access_token (
      FOBV_PAYPAL_API_DOMAIN ,
      FOBV_PAYPAL_APP_CLIENT_ID ,
      FOBV_PAYPAL_APP_SECRET
    ) ;

    $request = [
      'intent' => 'CAPTURE' ,
      'purchase_units' => [
        [
          'custom_id' => "$reference" ,
          'description' => 'The Friends of Bennerley Viaduct membership fee' ,
          'amount' => [
            'currency_code' => 'GBP' ,
            'value' => "$amount"
          ]
        ]
      ] ,
      'application_context' => [
        'brand_name' => FOBV_PAYPAL_BRAND_NAME ,
        'locale' => 'en-GB' ,
        'shipping_preference' => 'NO_SHIPPING' ,
        'user_action' => 'PAY_NOW' ,
        'return_url' => get_page_link ( FOBV_MEMBERSHIP_CONFIRMATION_PAGE_ID ) ,
        'cancel_url' => get_page_link ( FOBV_MEMBERSHIP_CONFIRMATION_PAGE_ID )
      ]
    ] ;

    $response = varilink_paypal_create_order (
      FOBV_PAYPAL_API_DOMAIN , $access_token , $request
    ) ;

    // Change to get approve link by rel name and not array offset
    wp_redirect ( $response -> links [ 1 ] -> href ) ;

  } else {

    wp_redirect ( get_page_link ( FOBV_MEMBERSHIP_CONFIRMATION_PAGE_ID ) ) ;

  }

}

add_action ( 'admin_post_nopriv_fobv_membership_form' , 'fobv_membership_handle_form' ) ;

add_action ( 'admin_post_fobv_membership_form' , 'fobv_membership_handle_form' ) ;

// -----------------------------------------------------------------------------
// 4. FoBV Donations (fobv_donations)
//
// The FoBV Donations call to action.
//

function fobv_donations_output_form ( ) {

  // Output the form to accept donations

  $output = '
<!-- fobv_donations_form -->' .
fobv_start_form ( 'fobv_donations_form' ) . '
  <input type="hidden" name="action" value="fobv_gift_aid_form" />
  <input type="hidden" name="next_action" value="fobv_donations_form" />
  ' . wp_nonce_field ( 'fobv_donations_form' , 'fobv_donations_nonce' , true , false ) . '
  <div class="form-group">
    <small class="form-text text-muted">Select the amount that you wish to donate</small>
  </div>
  <div class="form-group">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" id="donationAmount5" name="amount" value="5" required>
      <label class="form-check-label" for="donationAmount5">£5</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" id="donationAmount10" name="amount" value="10" required>
      <label class="form-check-label" for="donationAmount10">£10</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" id="donationAmount20" name="amount" value="20" required>
      <label class="form-check-label" for="donationAmount20">£20</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" id="donationAmountOther" name="amount" value="30" required>
      <label class="form-check-label" for="donationAmount30">£30</label>
      <div class="invalid-feedback ml-2 mb-1">
        You must select the amount that you wish to donate
      </div>
    </div>
  </div>
  <p>
    We would like to make contact with you to thank you personally for your donation. If you are okay for us to do that then please provide us with your email address. However, if you would rather not do so then you can leave this field blank.
  </p>
  <div class="form-row mb-3">
    <label class="col-3 pt-1" for="inputEmailAddress">Email Address:</label>
    <input id="inputEmailAddress" name="email" type="email" class="form-control col-9" placeholder="If you are okay for us to contact you, enter your email address" aria-label="Email Address">
    <div class="invalid-feedback">
      If you enter an email address for us to contact you, then it must be a valid one.
    </div>
  </div>
  <div class="form-row mb-3">
    <label for="inputConfirmEmailAddress" class="col-3 pt-1">Confirm Email Address:</label>
    <input id="inputConfirmEmailAddress" name="confirm_email" type="text" class="form-control col-9" placeholder="If you entered an email address above, repeat it here to confirm it" aria-label="Confirm Email Address" disabled>
    <div class="invalid-feedback">
      You must exactly match the email address that you entered above to confirm it.
    </div>
  </div>
  <div class="form-row">
    <button id="buttonSubmit" type="submit" class="btn btn-primary col-2">Submit</button>
    <label for="buttonSubmit" class="col-10 pt-1">
      Personal data provided to us is protected by our <a href="' .
      get_page_link ( FOBV_PRIVACY_POLICY_PAGE_ID ) .
      '" target="_blank">privacy policy</a>' . '
    </label>
  </div>
</form>
<!-- /varilink_donations_form -->
'
  ;
  return $output ;
}

// Add a shortcode so that the donations form can be incorporate into a page
add_shortcode ( 'fobv_donations_form' , 'fobv_donations_output_form' ) ;

function fobv_donations_handle_form ( ) {

  // Handle submit from the FoBV donations form

  $amount     = $_POST [ 'amount' ] ;
  $email      = $_POST [ 'email' ] ;
  $first_name = $_POST [ 'first_name' ] ;
  $surname    = $_POST [ 'surname' ] ;
  $address1   = $_POST [ 'address1' ] ;
  $address2   = $_POST [ 'address2' ] ;
  $address3   = $_POST [ 'address3' ] ;
  $address4   = $_POST [ 'address4' ] ;
  $postcode   = $_POST [ 'postcode' ] ;

  array_key_exists ( 'gift_aid' , $_POST )
    ? $gift_aid = $_POST [ 'gift_aid' ]
    : $gift_aid = '' ;

  $access_token = varilink_paypal_get_access_token (
    FOBV_PAYPAL_API_DOMAIN , FOBV_PAYPAL_APP_CLIENT_ID , FOBV_PAYPAL_APP_SECRET
  ) ;

  $request = [
    'intent' => 'CAPTURE' ,
    'purchase_units' => [
      [
        'description' => 'Donation to The Friends of Bennerley Viaduct' ,
        'amount' => [
          'currency_code' => 'GBP' ,
          'value' => "$amount"
        ]
      ]
    ] ,
    'application_context' => [
      'brand_name' => FOBV_PAYPAL_BRAND_NAME ,
      'locale' => 'en-GB' ,
      'shipping_preference' => 'NO_SHIPPING' ,
      'user_action' => 'PAY_NOW' ,
      'return_url' => get_page_link ( FOBV_DONATION_RECEIVED_PAGE_ID ) ,
      'cancel_url' => get_page_link ( FOBV_DONATE_TO_OUR_CAUSE_PAGE_ID )
    ]
  ] ;

  $response = varilink_paypal_create_order (
    FOBV_PAYPAL_API_DOMAIN , $access_token , $request
  ) ;

  $to = (
    preg_match ( FOBV_OVERRIDE_EMAIL , $email )
      ? $email
      : FOBV_TREASURER_EMAIL
  ) ;
  $subject = 'Donation to ' . FOBV_PAYPAL_BRAND_NAME ;
  if ( $email ) {
    $message = "A donation of $amount was initiated via the website. This does not mean that the donor followed through to payment. The donor gave their email address as $email." ;
  } else {
    $message = "A donation of $amount was initiated via the website. This does not mean that the donor followed through to payment. The donor chose not to provide their email address." ;
  }
  if ( $gift_aid === 'on' ) {
    $message .= 'The donor elected to make a Gift Aid declaration and provided details as follows:' ;
    $message .= "\r\nFirst name=$first_name" ;
    $message .= "\r\nSurname=$surname" ;
    $message .= "\r\nAddress Line 1=$address1" ;
    $message .= "\r\nAddress Line 2=$address2" ;
    $message .= "\r\nAddress Line 3=$address3" ;
    $message .= "\r\nAddress Line 4=$address4" ;
    $message .= "\r\nPostcode=$postcode" ;
  } else {
    $message .= 'The donor elected NOT to make a Gift Aid declaration.' ;
  }
  $headers = 'From: ' . FOBV_EMAIL_SENDER ;
  wp_mail ( $to , $subject , $message , $headers ) ;

  if ( function_exists ( 'varilink_write_log' ) ) {
    varilink_write_log ( "Email $subject sent to $to" ) ;
  }

  // Change to get approve link by rel name and not array offset
  wp_redirect ( $response -> links [ 1 ] -> href ) ;

}

add_action ( 'admin_post_nopriv_fobv_donations_form' , 'fobv_donations_handle_form' ) ;

add_action ( 'admin_post_fobv_donations_form' , 'fobv_donations_handle_form' ) ;

// -----------------------------------------------------------------------------
// 5. FoBV Join (fobv_join)
//
// The FoBV Join call to action.
//

function fobv_join_output_form ( ) {

  // Output to form to accept new members

  global $reference ;

  $output = '
<!-- fobv_join_form -->' .
fobv_start_form ( 'fobv_join_form' ) . '
  <input type="hidden" name="action" value="fobv_gift_aid_form" />
  <input type="hidden" name="next_action" value="fobv_membership_form">
  ' . wp_nonce_field ( 'fobv_join_form' , 'fobv_join_nonce' , true , false ) . '
  <input type="hidden" name="reference" value="' . $reference . '">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 shadow p-3 mb-5 bg-white rounded">
      <p class="lead">Contact Details</p>' .
fobv_contact_details ( 'join' ) . '
      <div class="form-row mt-3 mb-3">
        <label for="inputAddress1" class="col-3 pt-1">Address Line 1:</label>
        <input id="inputAddress1" name="address1" type="text" class="form-control col-9" placeholder="Enter the first line of your address" aria-label="Address" required>
        <div class="invalid-feedback">
          You must enter at least two lines of your address
        </div>
      </div>
      <div class="form-row mb-3">
        <label for="inputAddress2" class="col-3 pt-1">Address Line 2:</label>
        <input id="inputAddress2" name="address2" type="text" class="form-control col-9" placeholder="Enter the second line of your address" aria-label="Address" required>
        <div class="invalid-feedback">
          You must enter at least two lines of your address
        </div>
      </div>
      <div class="form-row mb-3">
        <label for="inputAddress3" class="col-3 pt-1">Address Line 3:</label>
        <input id="inputAddress3" name="address3" type="text" class="form-control col-9" placeholder="Enter the third line of your address" aria-label="Address">
      </div>
      <div class="form-row mb-3">
        <label for="inputAddress4" class="col-3 pt-1">Address Line 4:</label>
        <input id="inputAddress4" name="address4" type="text" class="form-control col-9" placeholder="Enter the fourth line of your address" aria-label="Address">
      </div>
      <div class="form-row">
        <label for="inputPostcode" class="col-3 pt-1">Postcode:</label>
        <input id="inputPostcode" name="postcode" type="text" class="form-control col-9" placeholder="Enter your postcode" aria-label="Postcode" required>
        <div class="invalid-feedback">
          You must enter your post code
        </div>
      </div>

    </div>
  </div>

  <!-- Start of Demographic Section -->
  <div class="row">
    <div class="col-sm-10 offset-sm-1 shadow p-3 mb-5 bg-white rounded">

      <p class="lead">Demographic</p>

      <fieldset class="form-group">

        <div class="form-row align-items-center">

          <legend class="col-form-label col-sm-2">Gender:</legend>

          <div class="col-sm-10">

            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" name="gender" id="inputGenderMale" value="male" required>
              <label class="custom-control-label" for="inputGenderMale">Male</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" name="gender" id="inputGenderFemale" value="female" required>
              <label class="custom-control-label" for="inputGenderFemale">Female</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" name="gender" id="inputGenderNone" value="none" required>
              <label class="custom-control-label" for="inputGenderNone">Prefer not to say</label>
              <div class="invalid-feedback">
                You must select one of the Gender options above
              </div>
            </div>

          </div>

        </div>

      </fieldset>

      <fieldset class="form-group">

        <div class="row">

          <legend class="col-form-label col-sm-2">Age Group:</legend>

          <div class="col-sm-10">

            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" name="age_group" id="inputAgeGroupUnder16" value="under 16" required>
              <label class="custom-control-label" for="inputAgeGroupUnder16">Under 16</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" name="age_group" id="inputAgeGroup16-24" value="16-24" required>
              <label class="custom-control-label" for="inputAgeGroup16-24">16-24</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" name="age_group" id="inputAgeGroup25-44" value="25-44" required>
              <label class="custom-control-label" for="inputAgeGroup25-44">25-44</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" name="age_group" id="inputAgeGroup45-64" value="45-64" required>
              <label class="custom-control-label" for="inputAgeGroup45-64">45-64</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" name="age_group" id="inputAgeGroup65Plus" value="65+" required>
              <label class="custom-control-label" for="inputAgeGroup65Plus">65+</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" name="age_group" id="inputAgeGroupNone" value="none" required>
              <label class="custom-control-label" for="inputAgeGroupNoe">Prefer not to say</label>
              <div class="invalid-feedback">
                You must select one of the Age Group options above
              </div>
            </div>

          </div>

        </div>

      </fieldset>

    </div>
  </div>' .
fobv_payment_details ( 'join' ) . '
  <div class="row justify-content-center">
    <button id="buttonJoinSubmit" type="submit" class="btn btn-primary col-2 pl-2">Submit</button>
    <label for="buttonJoinSubmit" class="col-9 pt-1">
      Personal data provided to us is protected by our <a href="' .
      get_page_link ( FOBV_PRIVACY_POLICY_PAGE_ID ) .
      '" target="_blank">privacy policy</a>' . '
    </label>
  </div>
</form>
<!-- /fobv_join_form -->
'
;
return $output ;
}

// Add shortcode for display of the FoBV Join form on a page
add_shortcode ( 'fobv_join_form' , 'fobv_join_output_form' ) ;

// -----------------------------------------------------------------------------
// 6. FoBV Renew (fobv_renew)
//
// Implementation of the FoBV Renew call to action.
//

function fobv_renew_output_form ( ) {

  // Function to output the FoBV Renew form.

  global $reference ;

  $output = '
<!-- fobv_renew_form -->' .
fobv_start_form ( 'fobv_renew_form' ) . '
  <input type="hidden" name="action" value="fobv_gift_aid_form" />
  <input type="hidden" name="next_action" value="fobv_membership_form">
  ' . wp_nonce_field ( 'fobv_renew_form' , 'fobv_renew_nonce' , true , false ) .
  '
  <input type="hidden" name="reference" value="' . $reference . '">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 shadow p-3 mb-5 bg-white rounded">
      <p class="lead">Contact Details</p>' .
fobv_contact_details ( 'renew' ) . '
    </div>
  </div>' .
fobv_payment_details ( 'renew' ) . '
<div class="row justify-content-center">
  <button id="buttonJoinSubmit" type="submit" class="btn btn-primary col-2 pl-2">Submit</button>
  <label for="buttonJoinSubmit" class="col-9 pt-1">
    Personal data provided to us is protected by our <a href="' .
    get_page_link ( FOBV_PRIVACY_POLICY_PAGE_ID ) .
    '" target="_blank">privacy policy</a>' . '
  </label>
</div>
</form>
<!-- /fobv_renew_form -->
'
;
return $output ;
}

// Add a shortcode so that FoBV Renew form can be incorporated in a page
add_shortcode ( 'fobv_renew_form' , 'fobv_renew_output_form' ) ;

// -----------------------------------------------------------------------------
// 7. FoBV Subscribe (fobv_subscribe)
//
// Implementation of the FoBV Subscribe call to action.
//

function fobv_subscribe_output_form ( ) {

  // Function to output the Varilink Subscribe form

  $output = '
<!-- fobv_subscribe_form -->
' .
fobv_start_form ( 'fobv_subscribe_form' ) . '
<input type="hidden" name="action" value="fobv_subscribe_form" />
' . wp_nonce_field ( 'fobv_subscribe_form' , 'fobv_subscribe_nonce' , true , false ) . '
<div class="form-group row">
  <label class="col-sm-3" for="mcEmail">Email Address</label>
  <div class="col-sm-9">
    <input name="mc_email" class="form-control" id="mcEmail" required type="email">
    <small id="emailHelp" class="form-text text-muted">
      You <span class="font-weight-bold">must</span> provide an email address for us to send bulletins to. We will never share your email address with anyone else.
    </small>
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3" for="mcFirstName">First Name</label>
  <div class="col-sm-9">
    <input name="mc_first_name" class="form-control" id="mcFirstName" type="text">
    <small id="firstNameHelp" class="form-text text-muted">
      Optionally provide us with your first name so that we may personalise our communication with you.
    </small>
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3" for="mcSurname">Surname</label>
  <div class="col-sm-9">
    <input name="mc_surname" class="form-control" id="mcSurname" type="text">
    <small id="surnameHelp" class="form-text text-muted">
      Optionally provide us with your surname so that we may personalise our communication with you.
    </small>
  </div>
</div>

<!-- Mailchimp bot protection -->
<div aria-hidden="true" style="position: absolute; left: -5000px;">
  <input name="b_c7b4f78d87142e3b04cd3a365_634bd2db1e" tabindex="-1" type="text" value="">
</div>

<div class="form-group row justify-content-center">
  <button id="buttonSubscribe" name="subscribe" class="btn btn-primary col-2" type="submit" value="Subscribe">
    Subscribe
  </button>
  <label class="col-9 pt-1" for="buttonSubscribe">
    Personal data provided to us is protected by our <a href="' .
    get_page_link ( FOBV_PRIVACY_POLICY_PAGE_ID ) .
    '" target="_blank">privacy policy</a>' . '
  </label>
</div>

</form>
<!-- /fobv_subscribe_form -->
'
  ;
  return $output ;
}

// Add shortcode so that FoBV Subscribe form can be displayed on a page
add_shortcode ( 'fobv_subscribe_form' , 'fobv_subscribe_output_form' ) ;

function fobv_subscribe_handle_form ( ) {

  $email = $_POST [ 'mc_email' ] ;
  $first_name = $_POST [ 'mc_first_name' ] ;
  $surname = $_POST [ 'mc_surname' ] ;
  isset ( $_POST [ 'mc_interests' ] )
    ? $interests = $_POST [ 'mc_interests' ]
    : $interests = NULL ;

  if ($first_name === 'James' && $surname ==='Smith') {
    goto SKIP_SUBSCRIPTION;
  }

  // Handle the FoBV subscribe form submission

  $subscriber = fobv_mailchimp_subscriber (
    $email , $first_name , $surname , $interests
  ) ;

  if ( function_exists ( 'varilink_write_log' ) ) {
    varilink_write_log ( 'Returned from function fobv_mailchimp_subscriber:' ) ;
    ob_start ( ) ;
    var_dump ( $subscriber ) ;
    varilink_write_log ( ob_get_clean ( ) ) ;
  }

  $merge_fields = array_pop ( $subscriber ) ;

  $request = [
    'email_address' => $email ,
    'status_if_new' => 'pending' ,
    'status' => 'pending' ,
    'merge_fields' => $merge_fields
  ] ;

  if ( $subscriber ) { $request [ 'interests' ] = array_pop ( $subscriber ) ; }

  varilink_mailchimp_add_or_update_list_member (
    FOBV_MAILCHIMP_API_KEY ,
    FOBV_MAILCHIMP_API_ROOT,
    FOBV_MAILCHIMP_LIST_ID ,
    $request
  ) ;

  $to = (
    preg_match ( FOBV_OVERRIDE_EMAIL , $email )
      ? $email
      : FOBV_MAILCHIMP_EMAIL
  ) ;

  FOBV_ENV === 'prod'
    ? $subject = 'Subscription to email bulletin via website'
    : $subject = '[TEST] Subscription to email bulletin via website' ;

  isset ( $_POST [ 'mc_interests' ] )
    ? $interests_str = implode ( ' ' , $_POST [ 'mc_interests' ] )
    : $interests_str = 'No interests checked' ;

  $message = "Someone has subscribed to the email bulletin via the website. The details they provided were as follow.\r\nEmail Address: $email\r\nFirst Name: $first_name\r\nSurname: $surname" ;

  $headers = 'From: ' . FOBV_EMAIL_SENDER ;

  wp_mail ( $to , $subject , $message , $headers ) ;

SKIP_SUBSCRIPTION:

  wp_redirect ( get_page_link ( FOBV_SUBSCRIPTION_CONFIRMATION_PAGE_ID ) ) ;

}

add_action ( 'admin_post_nopriv_fobv_subscribe_form' , 'fobv_subscribe_handle_form' ) ;

add_action ( 'admin_post_fobv_subscribe_form' , 'fobv_subscribe_handle_form' ) ;

// -----------------------------------------------------------------------------
// 8. FoBV Gift Aid

function fobv_gift_aid_output_form (
  $action     ,
  $amount     ,
  $method     ,
  $reference  ,
  $email      ,
  $first_name ,
  $surname    ,
  $address1   ,
  $address2   ,
  $address3   ,
  $address4   ,
  $postcode   ,
  $gender     ,
  $age_group
) {

  // Function to output the Varilink Gift Aid form

  $output = '
<h1>Gift Aid</h1>
<!-- fobv_gift_aid_form -->
' .
fobv_start_form ( 'fobv_gift_aid_form' ) . '
<input type="hidden" name="action" value="' . $action . '" />
' . wp_nonce_field ( 'fobv_gift_aid_form' , 'fobv_gift_aid_nonce' , true , false ) . '
<input type="hidden" name="amount" value="' . $amount . '" />
<input type="hidden" name="method" value="' . $method . '" />
<input type="hidden" name="reference" value="' . $reference . '" />
<input type="hidden" name="email" value="' . $email . '" />' ;

  if ( $first_name && $surname ) {

    $output .= '
<input type="hidden" name="first_name" value="' . $first_name . '" />
<input type="hidden" name="surname" value="' . $surname . '" />' ;

  }

  if ( $address1 && $address2 && $postcode ) {

    $output .= '
<input type="hidden" name="address1" value="' . $address1 . '" />
<input type="hidden" name="address2" value="' . $address2 . '" />
<input type="hidden" name="address3" value="' . $address3 . '" />
<input type="hidden" name="address4" value="' . $address4 . '" />
<input type="hidden" name="postcode" value="' . $postcode . '" />' ;

  }

  if ( $gender && $age_group ) {

    $output .= '
<input type="hidden" name="gender" value="' . $gender . '" />
<input type="hidden" name="age_group" value="' . $age_group . '" />' ;

  }

  $output .= '
<p>
If you are a UK tax payer please consider enabling us to collect Gift Aid for your payment. Gift Aid is a handy tax relief scheme for charities. Your personal contribution will be instantly worth 25% more to us - at no extra cost to you. Your £' . $amount . ' becomes worth £' . ( $amount * 1.25 ) . ' to us.
</p>
<p>
If you want for us to be able to claim Gift Aid for your payment then please check the box below.
</p>
<div class="form-check">
  <input name="gift_aid" class="form-check-input" id="giftAid" type="checkbox" data-toggle="collapse" data-target="#giftAidDeclaration">
  <label class="ml-1 form-check-label" for="giftAid">
    I want to enable Gift Aid for my payment.
  </label>
</div>
<!-- Start of Declaration -->
<div class="row">
  <div class="collapse col-sm-10 offset-sm-1 shadow p-3 mt-5 mb-5 bg-white rounded" id="giftAidDeclaration">
    <p class="lead">Declaration</p>
    <p><strong>
      I am a UK tax payer and understand that if I pay less Income Tax and/or Capital Gains Tax in the current tax year than the amount of Gift Aid claimed it is my responsibility to pay any difference.
    </strong></p>
    <p>Please notify us if you:</p>
    <ul>
      <li>Want to cancel this declaration.</li>
      <li>Change your name or home address.</li>
      <li>No longer pay sufficient tax on your income and/or capital gains.</li>
    </ul>
    <p>
      If you pay Income Tax at the higher or additional rate and want to receive the additional tax relief due to you, you must include all your Gift Aid donations on your Self-Assessment tax return or ask HM Revenue and Customs to adjust your tax code.
    </p>' ;

  if ( $first_name && $surname && $address1 && $address2 && $postcode ) {

    $output .= '
    <p>
      If you are comfortable with the declaration above then please click on "Continue" below to proceed. We then be able to claim Gift Aid for your payment with the details that you have provided already. If you wish to change your mind and not enable Gift Aid for your payment then uncheck the box above and click on "Continue" below to proceed.
    </p>' ;

  } elseif (
    $first_name && $surname && ( !$address1 or !$address2 or !$postcode )
  ) {

    $output .= '
    <p>
      If you are comfortable with the declaration above then please provide below the additional information that we need to claim Gift Aid for your payment and then click on "Continue" to proceed. If you wish to change your mind and not enable Gift Aid for your payment then uncheck the box above and click on "Continue" below to proceed.
    </p>' ;

  } else {

    $output .= '
    <p>
      If you are comfortable with the declaration above then please provide below the information that we need to claim Gift Aid for your payment and then click on "Continue" to proceed. If you wish to change your mind and not enable Gift Aid for your payment then uncheck the box above and click on "Continue" below to proceed.
    </p>' ;

  }

  if ( !$first_name or !$surname ) {

    // We don't hvae the contact's name and so must capture is

    $output .= '
    <div class="form-row mt-3 mb-3">
      <label class="col-3 pt-1" for="inputFirstName">First Name</label>
      <input id="inputFirstName" name="first_name" type="text" class="form-control col-9" placeholder="Enter your first name">
    </div>
    <div class="form-row mb-3">
      <label class="col-3 pt-1" for="inputSurname">Surname</label>
      <input id="inputSurname" name="surname" type="text" class="form-control col-9" placeholder="Enter your surname">
    </div>' ;

    }

  if ( !$address1 or !$address2 or !$postcode ) {

    // We don't have address details so they must be captured

    $output .= '
    <div class="form-row mb-3">
      <label for="inputAddress1" class="col-3 pt-1">Address Line 1:</label>
      <input id="inputAddress1" name="address1" type="text" class="form-control col-9" placeholder="Enter the first line of your address" aria-label="Address">
      <div class="invalid-feedback">
        You must enter at least two lines of your address
      </div>
    </div>
    <div class="form-row mb-3">
      <label for="inputAddress2" class="col-3 pt-1">Address Line 2:</label>
      <input id="inputAddress2" name="address2" type="text" class="form-control col-9" placeholder="Enter the second line of your address" aria-label="Address">
      <div class="invalid-feedback">
        You must enter at least two lines of your address
      </div>
    </div>
    <div class="form-row mb-3">
      <label for="inputAddress3" class="col-3 pt-1">Address Line 3:</label>
      <input id="inputAddress3" name="address3" type="text" class="form-control col-9" placeholder="Enter the third line of your address" aria-label="Address">
    </div>
    <div class="form-row mb-3">
      <label for="inputAddress4" class="col-3 pt-1">Address Line 4:</label>
      <input id="inputAddress4" name="address4" type="text" class="form-control col-9" placeholder="Enter the fourth line of your address" aria-label="Address">
    </div>
    <div class="form-row">
      <label for="inputPostcode" class="col-3 pt-1">Postcode:</label>
      <input id="inputPostcode" name="postcode" type="text" class="form-control col-9" placeholder="Enter your postcode" aria-label="Postcode">
      <div class="invalid-feedback">
        You must enter your post code
      </div>
    </div>' ;

  }

  $output .= '
    </div>
  </div>
  <!-- End of Declaration -->
  <button name="continue" class="btn btn-primary mt-3 mb-3" type="submit" value="Continue">
    Continue
  </button>
</form>
<!-- /fobv_gift_aid_form -->
' ;

  return $output ;
}

function fobv_gift_aid_show_form ( ) {

  // Show the form for capture of Gift Aid declarations

  if ( function_exists ( 'varilink_write_log' ) ) {
    varilink_write_log ( 'function fobv_gift_aid_show_form called' ) ;
  }

  $action = $_POST [ 'next_action' ] ;
  $amount = $_POST [ 'amount' ] ;
  $email  = $_POST [ 'email' ] ;
  array_key_exists ( 'method' , $_POST )
    ? $method = $_POST [ 'method' ]
    : $method = '' ;
  array_key_exists ( 'reference' , $_POST )
    ? $reference = $_POST [ 'reference' ]
    : $reference = '' ;
  array_key_exists ( 'first_name' , $_POST )
    ? $first_name = $_POST [ 'first_name' ]
    : $first_name = '' ;
  array_key_exists ( 'surname' , $_POST )
    ? $surname = $_POST [ 'surname' ]
    : $surname = '' ;
  array_key_exists ( 'address1' , $_POST )
    ? $address1 = $_POST [ 'address1' ]
    : $address1 = '' ;
  array_key_exists ( 'address2' , $_POST )
    ? $address2 = $_POST [ 'address2' ]
    : $address2 = '' ;
  array_key_exists ( 'address3' , $_POST )
    ? $address3 = $_POST [ 'address3' ]
    : $address3 = '' ;
  array_key_exists ( 'address4' , $_POST )
    ? $address4 = $_POST [ 'address4' ]
    : $address4 = '' ;
  array_key_exists ( 'postcode' , $_POST )
    ? $postcode = $_POST [ 'postcode' ]
    : $postcode = '' ;
  array_key_exists ( 'gender' , $_POST )
    ? $gender = $_POST [ 'gender' ]
    : $gender = '' ;
  array_key_exists ( 'age_group' , $_POST )
    ? $age_group = $_POST [ 'age_group' ]
    : $age_group = '' ;

  get_header ( ) ;
  echo ( fobv_gift_aid_output_form (
    $action     ,
    $amount     ,
    $method     ,
    $reference  ,
    $email      ,
    $first_name ,
    $surname    ,
    $address1   ,
    $address2   ,
    $address3   ,
    $address4   ,
    $postcode   ,
    $gender     ,
    $age_group
  ) ) ;
  get_footer ( ) ;

}

add_action ( 'admin_post_nopriv_fobv_gift_aid_form' , 'fobv_gift_aid_show_form' ) ;

add_action ( 'admin_post_fobv_gift_aid_form' , 'fobv_gift_aid_show_form' ) ;

// -----------------------------------------------------------------------------
// 9. Custom Widgets
//

class My_Meta_Widget extends WP_Widget_Meta {

  // Define a custom meta widget

  public function widget ( $args , $instance ) {

    /**
     * Override widget function of WP_Widget_Meta to:
     * - Have a default title of "Site Admin" rather than "Meta";
     * - Not display 'Entries Feed', 'Comment Feed' and "Wordpress.org" links.
    */

    $title = ! empty ( $instance [ 'title' ] ) ? $instance [ 'title' ] : __( 'Maintenance' ) ;

    // Filter documented in wp-includes/widgets/class-wp-widget-pages.php
    $title = apply_filters ( 'widget_title' , $title , $instance , $this -> id_base ) ;

    echo $args [ 'before_widget' ] ;

    if ( $title ) {
      echo $args [ 'before_title' ] . $title . $args [ 'after_title' ] ;
    }

/** Closing tag here causes HTML to start being output! */
?>
     <ul>
       <?php wp_register ( ) ; ?>
       <li><?php wp_loginout ( ) ; ?></li>
       <?php
        wp_meta ( ) ;
      ?>
    </ul>
<?php
/** Opening tag here causes resumption of php! */
    echo $args [ 'after_widget' ] ;
  }
}

// Register the custom meta widget we have just defined
function my_meta_widget_register ( ) {
  unregister_widget ( 'WP_Widget_Meta' ) ;
  register_widget ( 'My_Meta_Widget' ) ;
}

add_action ( 'widgets_init' , 'my_meta_widget_register' ) ;

// -----------------------------------------------------------------------------
// 10. PayPal Webhook
//

function fobv_paypal_capture_payment ( ) {

  //
  // Function to capture PayPal payments via webhook callback.
  //

  if ( function_exists ( 'varilink_write_log' ) ) {
    varilink_write_log ( 'function fobv_paypal_capture_payment called' ) ;
  }

  $notification = json_decode ( file_get_contents ( 'php://input' ) ) ;

  if ( function_exists ( 'varilink_write_log' ) ) {
    varilink_write_log ( 'Received notification from webhook as follows:' ) ;
    ob_start ( ) ;
    var_dump ( $notification ) ;
    varilink_write_log ( ob_get_clean ( ) ) ;
  }

  // Get access token. Possibly change to reuse prior token if still cached.
  $access_token = varilink_paypal_get_access_token (
    FOBV_PAYPAL_API_DOMAIN , FOBV_PAYPAL_APP_CLIENT_ID , FOBV_PAYPAL_APP_SECRET
  ) ;

  // Verify the webhook signature
  $verified = varilink_verify_webhook_signature (
    FOBV_PAYPAL_API_DOMAIN ,
    $access_token ,
    getallheaders ( ) ,
    $notification ,
    FOBV_PAYPAL_WEBHOOK_ID
  ) ;

  $order_id = $notification -> resource -> id ;

  // Capture payment for order, if the webhook event was verified
  if ( $verified ) {

    if ( function_exists ( 'varilink_write_log' ) ) {
      varilink_write_log ( 'Webhook notification verified, capture payment' ) ;
    }

    varilink_paypal_capture_payment (
      FOBV_PAYPAL_API_DOMAIN , $access_token , $order_id
    ) ;

    // Give a 200 response back to PayPal
    http_response_code ( 200 ) ;

  } else {

    if ( function_exists ( 'varilink_write_log' ) ) {
      varilink_write_log ( 'Webhook notification failed verification' ) ;
    }

  }

}

function fobv_paypal_capture_payment_route ( ) {

  if ( function_exists ( 'varilink_write_log' ) ) {
    varilink_write_log ( 'function fobv_paypal_capture_payment_route called' ) ;
  }

  // Register the REST API endpoint that invokes "varilink_paypal_capture_payment"
  register_rest_route ( 'paypal/v1' , '/capture' , array (
    // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
    'methods'  => 'POST' ,
    // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
    'callback' => 'fobv_paypal_capture_payment' ,
  ) ) ;

}

add_action ( 'rest_api_init' , 'fobv_paypal_capture_payment_route' ) ;
