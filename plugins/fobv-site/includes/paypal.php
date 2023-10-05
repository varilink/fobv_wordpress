<?php
/**
 * Defines functions in respect of the FoBV integration with PayPal.
 */

function fobv_paypal_create_order ( $transaction, $amount, $reference ) {

    $description = 'The Friends of Bennerley Viaduct';

    if ( preg_match( '/^fobv_donate/', $transaction ) ) {

        $description .= ' Donation';
        $return_url = site_url() . '/donation-received/';
        $cancel_url = site_url() . '/donation-cancelled/';

    } elseif ( preg_match( '/^fobv_join_us/', $transaction ) ) {

        $description .= ' Membership Fee';
        $return_url
            = site_url() . '/membership-confirmed-and-gift_aid-received/';
        $cancel_url
            = site_url() . '/membership-confirmed-and-gift_aid-cancelled/';

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

    // Get the approve link
    $approve_link = NULL;
    foreach ( $response->links as $link ) {
        if ( $link->rel === 'approve' ) {
            $approve_link = $link->href;
        }
    }

    return $approve_link;

}

function fobv_paypal_capture_payment () {

    $access_token = varilink_paypal_get_access_token(
        FOBV_PAYPAL_API_DOMAIN,
        FOBV_PAYPAL_APP_CLIENT_ID,
        FOBV_PAYPAL_APP_SECRET
    );
    $verified = varilink_paypal_verify_webhook_signature(
        FOBV_PAYPAL_API_DOMAIN,
        $access_token,
        FOBV_PAYPAL_WEBHOOK_ID
    );
    if ( $verified ) {
        $order_id = $notification->resource->id;
        varilink_paypal_capture_payment(
            FOBV_PAYPAL_API_DOMAIN, $access_token, $order_id
        );
        return new WP_HTTP_Response();
    } else {
        return new WP_Error( NULL, NULL, [ 'status' => 401 ] );
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
