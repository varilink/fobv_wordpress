<?php

function fobv_join_us() {

    $errors = [];

    foreach ( [
        'nonce', 'first_name', 'surname', 'email_address',
        'confirm_email_address', 'postcode', 'telephone', 'payment_amount',
        'payment_method'
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

}

add_action( 'admin_post_nopriv_fobv_donate', 'fobv_join_us' );
add_action( 'admin_post_fobv_donate', 'fobv_join_us' );
