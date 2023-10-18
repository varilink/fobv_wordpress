<?php
/**
 * Implements the action invoked by submitting the subscribe form.
 */

function fobv_subscribe() {

    // -------------------------------------------------------------------------
    // 1. Nonce security check
    // -------------------------------------------------------------------------

    if (
        ! array_key_exists( 'fobv_subscribe_nonce', $_POST ) ||
        ! wp_verify_nonce(
            $_POST[ 'fobv_subscribe_nonce' ], FOBV_SUBSCRIBE_CONTEXT
        )
    ) {
        die( __( 'Security check', 'textdomain' ) );
    }

    // -------------------------------------------------------------------------
    // 2. Start or update the transaction
    // -------------------------------------------------------------------------

    $transaction = $_POST[ 'transaction' ];

    if ( ! $transaction ) {

        start_transaction:
        $transaction = 'fobv_subscribe-' . wp_rand( 100000001, 999999999 );
        if ( array_key_exists( $transaction, $_SESSION ) ) {
            // Our randomly generated transaction id is the same as the one for
            // an existing transaction. This is HIGHLY unlikely to happen.
            goto start_transaction;
        }

    }

    $query = http_build_query( [ 'transaction' => $transaction ] );

    foreach ( [ 'email_address', 'first_name', 'surname' ] as $var ) {

        $post_var = 'fobv_subscribe_' . $var;

        if (
            array_key_exists( $post_var, $_POST )
            && ! empty( $_POST[ $post_var ] )
        ) {
            $$var = $_POST[ $post_var ];
        } else {
            $$var = NULL;
        }

        $_SESSION[ $transaction ][ $post_var ] = $$var;

    }

    // -------------------------------------------------------------------------
    // 3. Validate the form inputs just received
    // -------------------------------------------------------------------------

    foreach ( [ 'email_address_class', 'email_address_error' ] as $var ) {

        unset( $_SESSION[ $transaction ][ "fobv_subscribe_$var" ] );

    }

    $errors = FALSE;

    if (
        ! isset( $email_address ) ||
        ! filter_var( $email_address, FILTER_VALIDATE_EMAIL )
    ) {

        // We haven't been given a valid email so the form has failed validation
        // without us having to check the email against our Mailchimp audience.

        $errors = TRUE;
        $_SESSION[ $transaction ][ 'fobv_subscribe_email_address_class' ]
            = 'error';

        if ( isset( $email_address ) ) {
            $_SESSION[ $transaction ][ 'fobv_subscribe_email_address_error' ]
                = 'Please enter a valid email address.';
        } else {
            $_SESSION[ $transaction ][ 'fobv_subscribe_email_address_error' ]
                = 'This field is required.';
        }

    } else {

        // We have been passed a valid email address so check that doesn't
        // correspond to an existing subscription or pending subscription.

        $response = varilink_mailchimp_get_member_info(
            FOBV_MAILCHIMP_API_KEY,
            FOBV_MAILCHIMP_API_ROOT,
            FOBV_MAILCHIMP_LIST_ID,
            $email_address,
            [ 'fields' => 'status' ]
        );

        if (
            $response[ 'rc' ] === 200 &&
            $response[ 'body' ][ 'status' ] === 'subscribed'
        ) {

            $errors = TRUE;
            $_SESSION[ $transaction ][ 'fobv_subscribe_email_address_class' ]
                = 'error';
            $_SESSION[ $transaction ][ 'fobv_subscribe_email_address_error' ]
                = 'You are already subscribed.';

        } elseif (
            $response[ 'rc' ] === 200 &&
            $response[ 'body' ][ 'status' ] === 'pending'
        ) {

            $errors = TRUE;
            $_SESSION[ $transaction ][ 'fobv_subscribe_email_address_class' ]
                = 'error';
            $message = <<<'EOD'
                You have already subscribed but we are yet to receive
                verification of your email address via a confirmation email that
                has been sent to you. If you can not find this confirmation
                email address then please contact us.
                EOD;
            $_SESSION[ $transaction ][ 'fobv_subscribe_email_address_error' ]
                = str_replace( PHP_EOL, ' ', $message );

        }

    }

    if ( $errors ) {

        wp_redirect( "/latest-news/?$query#fobvSubscribeForm" );
        exit();

    }

    // -------------------------------------------------------------------------
    // 4. Notification
    // -------------------------------------------------------------------------

    $subject = 'Subscription Notification';

    if ( FOBV_ENV != 'live' ) {
        $subject .= ' (' . FOBV_ENV . ')';
    }

    $message = <<<"EOD"
Somebody just subscribed to our MailChimp mailing list via the website using the
email address $email_address.

EOD;

    $notifications = fobv_notification_email_addresses( 'subscribe' );

    if ( fobv_test_email_address() ) {

        // We are in test mode for email notifications. In this mode all emails
        // go to the current logged in user rather than the usual recipients.
        // We also report who the true recipients would have been if we weren't
        // in test mode within the email.

        $true_to = implode( PHP_EOL, $notifications );
        $message .= <<<"EOD"

We are in test mode in respect of email notifications. The "true" recipients of
this email would have been (if we weren't in test mode):
$true_to
EOD;
        $to = fobv_test_email_address();
    } else {
        $to = $notifications;
    }

    wp_mail( $to, $subject, $message );

    // -------------------------------------------------------------------------
    // 5. Execution
    // -------------------------------------------------------------------------

    $request[ 'email_address' ] = $email_address;
    $request[ 'status' ] = 'pending';
    $request[ 'status_if_new' ] = 'pending';
    if ( isset( $first_name ) ) {
        $request[ 'first_name' ] = $first_name;
    }
    if ( isset( $surname ) ) {
        $request[ 'surname' ] = $surname;
    }

    $response = varilink_mailchimp_add_or_update_list_member(
        FOBV_MAILCHIMP_API_KEY,
        FOBV_MAILCHIMP_API_ROOT,
        FOBV_MAILCHIMP_LIST_ID,
        $request
    );

    wp_redirect( '/subscription-confirmed/' );
    exit();

}

add_action( 'admin_post_nopriv_fobv_subscribe', 'fobv_subscribe' );
add_action( 'admin_post_fobv_subscribe', 'fobv_subscribe' );
