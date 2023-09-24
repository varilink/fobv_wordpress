<?php

function fobv_donate() {

    // -------------------------------------------------------------------------
    // 1. Validation
    // -------------------------------------------------------------------------

    $errors = [];

    foreach ( [
        'nonce', 'amount', 'method', 'reference', 'email_address',
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

    }

    if ( ! isset( $nonce ) or ! wp_verify_nonce( $nonce, FOBV_DONATE_CONTEXT )
    ) {
        die( __( 'Security check', 'textdomain' ) );
    }

    if ( ! isset( $amount ) ) {

        $errors[ 'fobv_donate_amount_error' ]
            = 'This field is required.';

    }

    if (
        isset( $email_address )
        && ! filter_var( $email_address, FILTER_VALIDATE_EMAIL )
    ) {

        $errors[ 'fobv_donate_email_address' ] = $email_address;
        $errors[ 'fobv_donate_email_address_class' ] = 'error';
        $errors[ 'fobv_donate_email_address_error' ]
            = 'Please enter a valid email address.';

    }

    if (
        isset( $email_address )
        && (
            ! isset( $confirm_email_address )
            || $confirm_email_address != $email_address
        )
    ) {

        $errors[ 'fobv_donate_confirm_email_address' ] = $confirm_email_address;
        $errors[ 'fobv_donate_confirm_email_address_class' ] = 'error';
        $errors[ 'fobv_donate_confirm_email_address_error' ]
            = 'Please enter the same value again.';

    }

    if ( ! empty( $errors ) ) {

        foreach ( $errors as $key => $value ) {
            $_SESSION[ $key ] = $value;
        }

        wp_redirect( '/support-the-fobv/#fobvDonateForm' );
        exit();

    }

    // -------------------------------------------------------------------------
    // 2. Notification
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // 3. Execution
    // -------------------------------------------------------------------------

    $_SESSION[ 'fobv_payment_type' ] = 'donation';
    $_SESSION[ 'fobv_payment_method' ] = $method;
    $_SESSION[ 'fobv_payment_amount' ] = $amount;
    $_SESSION[ 'fobv_payment_reference' ] = $reference;
    $_SESSION[ 'fobv_payment_email_address' ] = $email_address;
    wp_redirect( '/gift-aid/' );
    exit();

}

add_action( 'admin_post_nopriv_fobv_donate', 'fobv_donate' );
add_action( 'admin_post_fobv_donate', 'fobv_donate' );
