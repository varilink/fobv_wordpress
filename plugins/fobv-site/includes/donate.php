<?php
/**
 *  Implements the action invoked by submitting the donate form.
 */

function fobv_donate() {

    // -------------------------------------------------------------------------
    // 1. Nonce security check
    // -------------------------------------------------------------------------

    if (
        ! array_key_exists( 'fobv_donate_nonce', $_POST ) ||
        ! wp_verify_nonce( $_POST[ 'fobv_donate_nonce' ], FOBV_DONATE_CONTEXT )
    ) {
        die( __( 'Security check', 'textdomain' ) );
    }

    // -------------------------------------------------------------------------
    // 2. Validate reCAPTHCA response
    // -------------------------------------------------------------------------

    if ( function_exists( 'vl_recaptcha_verify_user_response') ) {
        $recaptcha_verification_result =
            vl_recaptcha_verify_user_response( VL_RECAPTCHA_SECRET_KEY );
        wp_mail(
            get_bloginfo( 'admin_email' ),                  # to
            'reCAPTCHA verification result',                # subject
            print_r( $recaptcha_verification_result, TRUE )
        );
    }

    // -------------------------------------------------------------------------
    // 3. Start or update the transaction
    // -------------------------------------------------------------------------

    $transaction = $_POST[ 'transaction' ];

    if ( ! $transaction ) {

        start_transaction:
        $transaction = 'fobv_donate-' . wp_rand( 100000001, 999999999 );
        if ( array_key_exists( $transaction, $_SESSION ) ) {
            // Our randomly generated transaction id is the same as the one for
            // an existing transaction. This is HIGHLY unlikely to happen.
            goto start_transaction;
        }

    }

    $query = http_build_query( [ 'transaction' => $transaction ] );

    foreach ( [
        'amount', 'amount_other_value', 'method', 'reference', 'email_address',
        'confirm_email_address'
    ] as $var ) {

        $post_var = 'fobv_donate_' . $var;

        if (
            array_key_exists( $post_var, $_POST )
            && ! empty( $_POST[ $post_var ] )
        ) {
            $$var = $_POST[ $post_var ];
        } else {
            $$var = NULL;
        }

        $_SESSION[$transaction][$post_var] = $$var;

    }

    // -------------------------------------------------------------------------
    // 4. Validate the form inputs just received
    // -------------------------------------------------------------------------

    foreach ( [
        'amount_error', 'amount_other_value_error', 'amount_other_value_class',
        'email_address_class', 'email_address_error',
        'confirm_email_address_class', 'confirm_email_address_error'
    ] as $var ) {

        unset( $_SESSION[ $transaction ][ "fobv_donate_$var" ] );

    }

    $errors = FALSE;

    if ( ! isset( $amount ) ) {

        $_SESSION[ $transaction ][ 'fobv_donate_amount_error' ]
            = 'This field is required.';
        $errors = TRUE;

    } elseif ( $amount === 'Other' ) {

        if ( ! isset( $amount_other_value ) ) {

            $_SESSION[ $transaction ][ 'fobv_donate_amount_other_value_class' ]
                = 'error';
            $_SESSION[ $transaction ][ 'fobv_donate_amount_other_value_error' ]
                = 'This field is required.';
            $errors = TRUE;

        } elseif ( ! preg_match( '/^[0-9]+$/', $amount_other_value ) ) {

            $_SESSION[ $transaction ][ 'fobv_donate_amount_other_value_class' ]
                = 'error';
            $_SESSION[ $transaction ][ 'fobv_donate_amount_other_value_error' ]
                = 'Please enter only digits.';
            $errors = TRUE;

        }

    }

    if (
        isset( $email_address )
        && ! filter_var( $email_address, FILTER_VALIDATE_EMAIL )
    ) {

        $_SESSION[ $transaction ][ 'fobv_donate_email_address_class' ]
            = 'error';
        $_SESSION[ $transaction ][ 'fobv_donate_email_address_error' ]
            = 'Please enter a valid email address.';
        $errors = TRUE;

    }

    if (
        isset( $email_address )
        && (
            ! isset( $confirm_email_address )
            || $confirm_email_address != $email_address
        )
    ) {

        $_SESSION[ $transaction ][ 'fobv_donate_confirm_email_address_class' ]
            = 'error';
        $_SESSION[ $transaction ][ 'fobv_donate_confirm_email_address_error' ]
            = 'Please enter the same value again.';
        $errors = TRUE;

    }

    if ( $errors ) {

        wp_redirect( "/support-our-charity/?$query#fobvDonateForm" );
        exit();

    }

    // -------------------------------------------------------------------------
    // 5. Execution
    // -------------------------------------------------------------------------

    wp_redirect( "/gift-aid/?$query" );
    exit();

}

add_action( 'admin_post_nopriv_fobv_donate', 'fobv_donate' );
add_action( 'admin_post_fobv_donate', 'fobv_donate' );
