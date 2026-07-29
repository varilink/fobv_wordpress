<?php
/**
 * Defines functions in respect of the FoBV integration with PayPal.
 */

function fobv_paypal_create_order ( $transaction, $amount, $reference ) {

    fobv_write_log( 'Function fobv_paypal_create_order called', TRUE );

    $description = 'The Friends of Bennerley Viaduct';

    if ( preg_match( '/^fobv_donate/', $transaction ) ) {

        $description .= ' Donation';
        $return_url = site_url() . '/donation-received/';
        $cancel_url = site_url() . '/donation-cancelled/';

    } elseif ( preg_match( '/^fobv_join_us/', $transaction ) ) {

        $description .= ' Membership Fee';
        $return_url
            = site_url() . '/membership-confirmed-and-payment-received/';
        $cancel_url
            = site_url() . '/membership-confirmed-and-payment-cancelled/';

    }

    $response = varilink_paypal_get_access_token(
        FOBV_PAYPAL_API_DOMAIN,
        FOBV_PAYPAL_APP_CLIENT_ID,
        FOBV_PAYPAL_APP_SECRET
    );

    if ( $response->rc === 200 ) {
        $access_token = $response->data->access_token;
        fobv_write_log( 'Successfully obtained access token' );
        fobv_write_log( $response->data );
    } else {
        $message  = "Error response from API call:\r\n" ;
        $message .= "RC=$rc\r\n" ;
        fobv_write_log( $response->data );
        die( $message ) ;
    }

    $request = [
        'intent' => 'CAPTURE',
        'purchase_units' => [
            [
                'custom_id' => "$reference",
                'description' => "$description",
                'amount' => ['currency_code' => 'GBP', 'value' => "$amount"]
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

    if ( $response->rc === 201 ) {
        $links = $response->data->links;
        fobv_write_log( 'Successfully created order' );
        fobv_write_log( $response->data );
    } else {
        $message  = "Error response from API call:\r\n" ;
        $message .= "RC=$rc\r\n" ;
        $message .= "JSON=$json\r\n" ;
        exit ( $message ) ;
    }

    // Get the approve link
    $approve_link = NULL;
    foreach ( $links as $link ) {
        if ( $link->rel === 'approve' ) {
            $approve_link = $link->href;
        }
    }

    return $approve_link;

}

function fobv_paypal_capture_payment () {

    fobv_write_log( 'Function fobv_paypal_capture_payment called', TRUE );

    $response = varilink_paypal_get_access_token(
        FOBV_PAYPAL_API_DOMAIN,
        FOBV_PAYPAL_APP_CLIENT_ID,
        FOBV_PAYPAL_APP_SECRET
    );

    if ( $response->rc === 200 ) {
        $access_token = $response->data->access_token;
        fobv_write_log( 'Successfully obtained access token' );
        fobv_write_log( $response->data );
    } else {
        $message  = "Error response from API call:\r\n" ;
        $message .= "RC=$rc\r\n" ;
        fobv_write_log( $response->data );
        die( $message ) ;
    }

    $notification = json_decode( file_get_contents( 'php://input' ) );

    $response = varilink_paypal_verify_webhook_signature(
        FOBV_PAYPAL_API_DOMAIN,
        $access_token,
        FOBV_PAYPAL_WEBHOOK_ID,
        $notification
    );

    if (
        $response->rc === 200 &&
        $response->data->verification_status === 'SUCCESS'
    ) {
        fobv_write_log( 'Successfully verified webhook signature' );
        fobv_write_log( $response->data );
    } elseif (
        $response->rc === 200 &&
        $response->data->verification_status != 'SUCCESS'
    ) {
        fobv_write_log( 'Failed to verify webhook signature' );
        fobv_write_log( $response->data );
        return new WP_Error( NULL, NULL, [ 'status' => 401 ] );
    } else {
        fobv_write_log(
            'Unexpected HTTP response when verifying webhook signature'
        );
        fobv_write_log( 'Return code ' . $response->rc );
        fobv_write_log( $response->data );
        die();
    }

    $order_id = $notification->resource->id;

    $response = varilink_paypal_capture_payment(
        FOBV_PAYPAL_API_DOMAIN, $access_token, $order_id
    );

    if ( $response->rc === 201 ) {
        fobv_write_log( 'Successfully captured payment' );
        fobv_write_log( $response->data );
        return new WP_HTTP_Response();
    } else {
        fobv_write_log( 'Failure when capturing payment' );
        fobv_write_log( $response->data );
        die();
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
