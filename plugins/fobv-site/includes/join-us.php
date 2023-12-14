<?php

function fobv_join_us() {

    // -------------------------------------------------------------------------
    // 1. Nonce security check
    // -------------------------------------------------------------------------

    if (
        ! array_key_exists( 'fobv_join_us_nonce', $_POST ) ||
        ! wp_verify_nonce(
            $_POST['fobv_join_us_nonce'], FOBV_JOIN_US_CONTEXT
        )
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

    $transaction = $_POST['transaction'];

    if ( ! $transaction ) {

        start_transaction:
        $transaction = 'fobv_join_us-' . wp_rand( 100000001, 999999999 );
        if ( array_key_exists( $transaction, $_SESSION ) ) {
            // Our randomly generated transaction id is the same as the one for
            // an existing transaction. This is HIGHLY unlikely to happen.
            goto start_transaction;
        }

    }

    $query = http_build_query( ['transaction' => $transaction] );

    foreach ( [
        'first_name', 'surname', 'email_address', 'confirm_email_address',
        'address_lines_toggle', 'address_line_1', 'address_line_2',
        'address_line_3', 'address_line_4', 'postcode', 'telephone', 'amount',
        'method', 'reference'
    ] as $var ) {

        $post_var = 'fobv_join_us_' . $var;

        if (
            array_key_exists( $post_var, $_POST )
            && ! empty( $_POST[$post_var] )
        ) {
            $$var = $_POST[$post_var];
        } else {
            $$var = NULL;
        }

        $_SESSION[$transaction][$post_var] = $$var;

    }

    // -------------------------------------------------------------------------
    // 4. Validate the form inputs just received
    // -------------------------------------------------------------------------

    foreach ( [
        'first_name_class', 'first_name_error', 'surname_class',
        'surname_error', 'email_address_class', 'email_address_error',
        'confirm_email_address_class', 'confirm_email_address_error',
        'address_line_1_class', 'address_line_1_error', 'address_line_2_class',
        'address_line_2_error', 'post_code_class', 'post_code_error'
    ] as $var ) {

        unset( $_SESSION[ $transaction ][ "fobv_join_us_$var" ] );

    }

    $errors = FALSE;

    if ( ! isset( $first_name ) ) {

        $_SESSION[$transaction]['fobv_join_us_first_name_class'] = 'error';
        $_SESSION[$transaction]['fobv_join_us_first_name_error']
            = 'This field is required.';
        $errors = TRUE;

    }

    if ( ! isset( $surname ) ) {

        $_SESSION[$transaction]['fobv_join_us_surname_class'] = 'error';
        $_SESSION[$transaction]['fobv_join_us_surname_error']
            = 'This field is required.';
        $errors = TRUE;

    }

    if ( ! isset( $email_address ) ) {

        $_SESSION[$transaction]['fobv_join_us_email_address_class']
            = 'error';
        $_SESSION[$transaction]['fobv_join_us_email_address_error']
            = 'This field is required.';
        $errors = TRUE;

    } elseif ( ! filter_var( $email_address, FILTER_VALIDATE_EMAIL ) ) {

        $_SESSION[$transaction]['fobv_join_us_email_address_class']
            = 'error';
        $_SESSION[$transaction]['fobv_join_us_email_address_error']
            = 'Please enter a valid email address.';
        $errors = TRUE;

    }

    if ( ! isset( $confirm_email_address ) ) {

        $_SESSION[$transaction]['fobv_join_us_confirm_email_address_class']
            = 'error';
        $_SESSION[$transaction]['fobv_join_us_confirm_email_address_error']
            = 'This field is required.';
        $errors = TRUE;

    } elseif ( $confirm_email_address != $email_address ) {

        $_SESSION[$transaction]['fobv_join_us_confirm_email_address_class']
            = 'error';
        $_SESSION[$transaction]['fobv_join_us_confirm_email_address_error']
            = 'Please enter the same value again.';
        $errors = TRUE;

    }

    if ( $address_lines_toggle === 'on' ) {

        if ( ! isset( $address_line_1 ) ) {

            $_SESSION[ $transaction ][ 'fobv_join_us_address_line_1_class' ]
                = 'error';
            $_SESSION[ $transaction ][ 'fobv_join_us_address_line_1_error' ]
                = 'This field is required.';
            $errors = TRUE;

        }

        if ( ! isset( $address_line_2 ) ) {

            $_SESSION[ $transaction ][ 'fobv_join_us_address_line_2_class' ]
                = 'error';
            $_SESSION[ $transaction ][ 'fobv_join_us_address_line_2_error' ]
                = 'This field is required.';
            $errors = TRUE;

        }

    }

    if ( ! isset( $postcode ) ) {

        $_SESSION[$transaction]['fobv_join_us_postcode_class'] = 'error';
        $_SESSION[$transaction]['fobv_join_us_postcode_error']
            = 'This field is required.';
        $errors = TRUE;

    }

    if ( $errors ) {

        wp_redirect( "/support-our-charity/?$query#fobvJoinUsForm" );
        exit();

    }

    // -------------------------------------------------------------------------
    // 5. Execution
    // -------------------------------------------------------------------------

    wp_redirect( "/gift-aid/?$query" );
    exit();

}

add_action( 'admin_post_nopriv_fobv_join_us', 'fobv_join_us' );
add_action( 'admin_post_fobv_join_us', 'fobv_join_us' );
