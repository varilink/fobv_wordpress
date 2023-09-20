<?php
// Process payments made via the FoBV website.

function fobv_pay() {

    /*
    This is the callback associated with the fobv_pay action, which is invoked
    invoked by the Gift Aid form. The Gift Aid form can be arrived at either
    from the Donate form or from the Join Us form, corresponding to two types of
    payment, being "donation" or "membership fee". This callback proceeds
    through three stages:

    1. Validation
    In which the form inputs are validated. If errors are found the user is
    redirected back to the Gift Aid form to correct them and this callback
    proceeds no further.

    2. Notification

    */

    // -------------------------------------------------------------------------
    // 1. Validation
    // -------------------------------------------------------------------------

    $errors = [];

    foreach ( [
        'nonce', 'type', 'amount', 'method', 'reference', 'email_address',
        'gift_aid', 'first_name', 'surname', 'address_line_1', 'address_line_2',
        'address_line_3', 'address_line_4', 'postcode'
    ] as $var ) {

        $post_var = 'fobv_payment_' . $var;

        if (
            array_key_exists( $post_var, $_POST )
            && ! empty( $_POST[ $post_var ] )
        ) {
            $$var = $_POST[ $post_var ];
        } else {
            $$var = NULL;
        }

    }

    if ( ! isset( $nonce ) or ! wp_verify_nonce( $nonce, FOBV_PAYMENT_CONTEXT )
    ) {
        die( __( 'Security check', 'textdomain' ) );
    }

    if ( $gift_aid === 'on' ) {

        if ( ! isset( $first_name ) ) {

            $errors[ 'fobv_payment_first_name' ] = $first_name;
            $errors[ 'fobv_payment_first_name_class' ] = 'error';
            $errors[ 'fobv_payment_first_name_error' ]
                = 'This field is required.';

        }

        if ( ! isset( $surname ) ) {

            $errors[ 'fobv_payment_surname' ] = $surname;
            $errors[ 'fobv_payment_surname_class' ] = 'error';
            $errors[ 'fobv_payment_surname_error' ]
                = 'This field is required.';

        }

        if ( ! isset( $address_line_1 ) ) {

            $errors[ 'fobv_payment_address_line_1' ] = $address_line_1;
            $errors[ 'fobv_payment_address_line_1_class' ] = 'error';
            $errors[ 'fobv_payment_address_line_1_error' ]
                = 'This field is required.';

        }

        if ( ! isset( $address_line_2 ) ) {

            $errors[ 'fobv_payment_address_line_2' ] = $address_line_2;
            $errors[ 'fobv_payment_address_line_2_class' ] = 'error';
            $errors[ 'fobv_payment_address_line_2_error' ]
                = 'This field is required.';

        }

        if ( ! isset( $postcode ) ) {

            $errors[ 'fobv_payment_postcode' ] = $postcode;
            $errors[ 'fobv_payment_postcode_class' ] = 'error';
            $errors[ 'fobv_payment_postcode_error' ]
                = 'This field is required.';

        }

    }

    if ( ! empty( $errors ) ) {

        foreach ( $errors as $key => $value ) {
            $_SESSION[ $key ] = $value;
        }

        wp_redirect( '/gift-aid#fobvGiftAidForm' );
        exit();

    }

    // -------------------------------------------------------------------------
    // 2. Notification
    // -------------------------------------------------------------------------

    // Send a notification email to the specified recipients. Both the message
    // in the email and the recipients of it differ according to the payment
    // type, "donation" or "membership fee".

    if ( $type = 'donation' ) {

        $subject = 'Donation Notification';

        $message = <<<"EOD"
A donation of $amount was initiated via the website. This does NOT necessarily
mean that the donor followed through with the payment. If they did then the
payment's reference will be recorded in PayPal as $reference.
EOD;

        if ( isset( $email_address ) ) {

            $message .= <<<"EOD"

The donor gave their email address as $email_address.
EOD;

        } else {

            $message .= <<<'EOD'

The donor chose not to provide their email address.
EOD;

        }

        if ( $gift_aid === 'on' ) {

            $message .= <<<"EOD"

The donor elected to make a Gift Aid declaration and provided details as
follows:
First name=$first_name
Surname=$surname
Address Line 1=$address_line_1
Address Line 2=$address_line_2
Address Line 3=$address_line_3
Address Line 4=$address_line_4
Postcode=$postcode
EOD;

        } else {

            $message .= <<<'EOD'

The donor did NOT elect to make a Gift Aid declaration.
EOD;

        }

        $to = fobv_get_notification_addresses( 'donate' );

    } elseif ( $type = 'membership fee' ) {

    }

    fobv_write_log( $to );
    fobv_write_log( $subject );
    fobv_write_log( $message );
    wp_mail( $to, $subject, $message );

    // -------------------------------------------------------------------------
    // 3. Execution
    // -------------------------------------------------------------------------

    if ( $method === 'Online' ) {

        if ( $type === 'donation' ) {
            $return_url = site_url() . '/donation-confirmed';
            $cancel_url = site_url() . '/donation-cancelled';
        } elseif ( $type === 'membership fee' ) {
            $return_url = site_url() . '/membership-confirmed';
            $cancel_url = site_url() . '/membership-cancelled';
        }

        $access_token = varilink_paypal_get_access_token(
            FOBV_PAYPAL_API_DOMAIN,
            FOBV_PAYPAL_APP_CLIENT_ID,
            FOBV_PAYPAL_APP_SECRET
        );

        $request = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'custom_id' => "$reference",
                    'description' =>
                        "The Friends of Bennerley Viaduct membership fee $type",
                    'amount' => [
                        'currency_code' => 'GBP',
                        'value' => "$amount"
                    ]
                ]
            ],
            'application_context' => [
                'brand_name' => FOBV_PAYPAL_BRAND_NAME,
                'locale' => 'en-GB',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                'return_url' => $return_url,
                'cancel_url' => $cancel_url
            ]
        ];

        $response = varilink_paypal_create_order(
            FOBV_PAYPAL_API_DOMAIN, $access_token, $request
        );
          
        // Change to get approve link by rel name and not array offset
        wp_redirect( $response->links[ 1 ]->href );

    } else {

        wp_redirect( $return_url );
        exit();

    }

}

add_action( 'admin_post_nopriv_fobv_pay', 'fobv_pay' );
add_action( 'admin_post_fobv_pay', 'fobv_pay' );

function fobv_capture_payment () {

    $notification = json_decode( file_get_contents( 'php://input' ) );
    $access_token = varilink_paypal_get_access_token(
        FOBV_PAYPAL_API_DOMAIN,
        FOBV_PAYPAL_APP_CLIENT_ID,
        FOBV_PAYPAL_APP_SECRET
    );
    $verified = varilink_paypal_verify_webhook_signature(
        FOBV_PAYPAL_API_DOMAIN,
        $access_token,
        getallheaders(),
        $notification,
        FOBV_PAYPAL_WEBHOOK_ID
    );
    if ( $verified ) {
        $order_id = $notification->resource->id;
        varilink_paypal_capture_payment(
            FOBV_PAYPAL_API_DOMAIN, $access_token, $order_id
        );
        http_response_code( 200 );
    }

}

function fobv_paypal_capture_payment_route () {

    register_rest_route(
        'paypal/v1',
        '/capture',
        [
            'methods'  => 'POST',
            'callback' => 'fobv_paypal_capture_payment',
            'permission_callback' => function () { return TRUE; }
        ],
    );
}

add_action( 'rest_api_init', 'fobv_paypal_capture_payment_route' );
