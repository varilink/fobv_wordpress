<?php

function fobv_join_us() {

    // -------------------------------------------------------------------------
    // 1. Validation
    // -------------------------------------------------------------------------

    $errors = [];

    foreach ( [
        'nonce', 'first_name', 'surname', 'email_address',
        'confirm_email_address', 'postcode', 'telephone', 'payment_amount',
        'payment_method', 'payment_reference'
    ] as $var ) {

        $post_var = 'fobv_join_us_' . $var;

        if (
            array_key_exists( $post_var, $_POST )
            && ! empty( $_POST[ $post_var ] )
        ) {
            $$var = $_POST[ $post_var ];
        } else {
            $$var = NULL;
        }

    }

    if ( ! isset( $nonce ) or ! wp_verify_nonce( $nonce, FOBV_JOIN_US_CONTEXT )
    ) {
        die( __( 'Security check', 'textdomain' ) );
    }

    if ( ! isset( $first_name ) ) {

            $errors[ 'fobv_join_us_first_name' ] = $first_name;
            $errors[ 'fobv_join_us_first_name_class' ] = 'error';
            $errors[ 'fobv_join_us_first_name_error' ]
                = 'This field is required.';

    }

    if ( ! isset( $surname ) ) {

        $errors[ 'fobv_join_us_surname' ] = $surname;
        $errors[ 'fobv_join_us_surname_class' ] = 'error';
        $errors[ 'fobv_join_us_surname_error' ]
            = 'This field is required.';

    }

    if ( ! isset( $email_address ) ) {

        $errors[ 'fobv_join_us_email_address' ] = $email_address;
        $errors[ 'fobv_join_us_email_address_class' ] = 'error';
        $errors[ 'fobv_join_us_email_address_error' ]
            = 'This field is required.';

    } elseif ( ! filter_var( $email_address, FILTER_VALIDATE_EMAIL ) ) {

        $errors[ 'fobv_join_us_email_address' ] = $email_address;
        $errors[ 'fobv_join_us_email_address_class' ] = 'error';
        $errors[ 'fobv_join_us_email_address_error' ]
            = 'Please enter a valid email address.';

    }

    if ( ! isset( $confirm_email_address ) ) {

        $errors[ 'fobv_join_us_confirm_email_address' ]
            = $confirm_email_address;
        $errors[ 'fobv_join_us_confirm_email_address_class' ] = 'error';
        $errors[ 'fobv_join_us_confirm_email_address_error' ]
            = 'This field is required.';

    } elseif ( $confirm_email_address != $email_address ) {

        $errors[ 'fobv_join_us_confirm_email_address' ]
            = $confirm_email_address;
        $errors[ 'fobv_join_us_confirm_email_address_class' ] = 'error';
        $errors[ 'fobv_join_us_confirm_email_address_error' ]
            = 'Please enter the same value again.';

    }

    if ( ! isset( $postcode ) ) {

        $errors[ 'fobv_join_us_postcode' ] = $postcode;
        $errors[ 'fobv_join_us_postcode_class' ] = 'error';
        $errors[ 'fobv_join_us_postcode_error' ]
            = 'This field is required.';

    }

    if ( ! empty( $errors ) ) {

        foreach ( $errors as $key => $value ) {
            $_SESSION[ $key ] = $value;
        }

        $_SESSION[ 'fobv_join_us_first_name' ] = $first_name;
        $_SESSION[ 'fobv_join_us_surname' ] = $surname;
        $_SESSION[ 'fobv_join_us_email_address' ] = $email_address;
        $_SESSION[ 'fobv_join_us_confirm_email_address' ]
            = $confirm_email_address;
        $_SESSION[ 'fobv_join_us_postcode' ] = $postcode;
        $_SESSION[ 'fobv_join_us_telephone' ] = $telephone;
        $_SESSION[ 'fobv_join_us_payment_amount' ] = $payment_amount;
        $_SESSION[ 'fobv_join_us_payment_method' ] = $payment_method;
        $_SESSION[ 'fobv_join_us_payment_reference' ] = $payment_reference;

        wp_redirect( '/support-the-fobv/#fobvJoinUsForm' );
        exit();

    }

    // -------------------------------------------------------------------------
    // 2. Notification
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // 3. Execution
    // -------------------------------------------------------------------------

    $_SESSION[ 'fobv_payment_type' ] = 'membership fee';
    $_SESSION[ 'fobv_payment_method' ] = $payment_method;
    $_SESSION[ 'fobv_payment_amount' ] = $payment_amount;
    $_SESSION[ 'fobv_payment_reference' ] = $payment_reference;
    $_SESSION[ 'fobv_payment_email_address' ] = $email_address;
    $_SESSION[ 'fobv_payment_first_name' ] = $first_name;
    $_SESSION[ 'fobv_payment_surname' ] = $surname;
    $_SESSION[ 'fobv_payment_postcode' ] = $postcode;
    $_SESSION[ 'fobv_payment_telephone' ] = $telephone;
    wp_redirect( '/gift-aid/' );
    exit();

}

add_action( 'admin_post_nopriv_fobv_join_us', 'fobv_join_us' );
add_action( 'admin_post_fobv_join_us', 'fobv_join_us' );
