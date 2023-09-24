<?php
/**
 * Handle the submission of the form for the subscribe call to action.
 */

function fobv_subscribe() {

    // Gather the form inputs into variables

    foreach ( [ 'nonce', 'email_address', 'first_name', 'surname' ] as $var ) {

        $post_var = 'fobv_subscribe_' . $var;

        if (
            array_key_exists( $post_var, $_POST )
            && ! empty( $_POST[ $post_var ] )
        ) {
            $$var = $_POST[ $post_var ];
        } else {
            $$var = NULL;
        }

    }

    // Nonce based security check

    if (
        ! isset( $nonce ) || ! wp_verify_nonce( $nonce, FOBV_SUBSCRIBE_CONTEXT )
    ) {
        die( __( 'Security check', 'textdomain' ) );
    }

    // Validate submitted data

    $errors = [];

    if (
        ! isset( $email_address ) ||
        ! filter_var( $email_address, FILTER_VALIDATE_EMAIL )
    ) {

        $errors[ 'fobv_subscribe_email_address_class' ] = 'error';

        if ( isset( $email_address ) ) {
            $errors[ 'fobv_subscribe_email_address_error' ]
                = 'The email address that you have entered is invalid';
        } else {
            $errors[ 'fobv_subscribe_email_address_error' ]
                = 'You MUST enter an email address';
        }

    }

    if ( empty ( $errors ) ) {

        // No errors in the form data so query the subscriber

        $request[ 'email_address' ] = $email_address;
        $request[ 'fields' ] = 'status';

        $response = varilink_mailchimp_get_member_info(
            FOBV_MAILCHIMP_API_KEY,
            FOBV_MAILCHIMP_API_ROOT,
            FOBV_MAILCHIMP_LIST_ID,
            $request
        );

        if (
            $response[ 'rc' ] === 200 &&
            $response[ 'body' ][ 'status' ] === 'subscribed'
        ) {
            $errors[ 'fobv_subscribe_email_address_class' ] = 'error';
            $errors[ 'fobv_subscribe_email_address_error' ]
                = 'You are already subscribed.';
        } elseif (
            $response[ 'rc' ] === 200 &&
            $response[ 'body' ][ 'status' ] === 'pending'
        ) {
            $errors[ 'fobv_subscribe_email_address_class' ] = 'error';
            $message = <<<'EOD'
                You have already subscribed but we are yet to receive
                verification of your email address via a confirmation email that
                has been sent to you. If you can not find this confirmation
                email address then please contact us.
                EOD;
            $errors[ 'fobv_subscribe_email_address_error' ]
                = str_replace( PHP_EOL, ' ', $message );
        } else {

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

            if (
                $response[ 'rc' ] === 200 &&
                $response[ 'body' ][ 'status' ] = 'pending'
            ) {
                wp_redirect( '/subscription-confirmed/' );
                exit();
            }

        }

    }

    // The submitted data failed validation

    # Provide validation errors for display in the form
    foreach ( $errors as $key => $value ) {
        $_SESSION[ $key ] = $value;
    }

    # Pass back the form inputs for display in the form
    foreach ( [ 'email_address', 'first_name', 'surname' ] as $var ) {
        $post_var = 'fobv_subscribe_' . $var;
        $_SESSION[ $post_var ] = $$var;
    }

    wp_redirect( '/latest-news/#fobvSubscribeForm' );
    exit();

}

add_action( 'admin_post_nopriv_fobv_subscribe', 'fobv_subscribe' );
add_action( 'admin_post_fobv_subscribe', 'fobv_subscribe' );
