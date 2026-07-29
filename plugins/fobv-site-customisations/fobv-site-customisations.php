<?php
/**
 * Plugin Name: FoBV Site Customisations
 * Description: Site-specific customisations.
 * Version: 1.0
 * Author: David Williamson
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

//==============================================================================
// CALL TO ACTION FORMS
//==============================================================================

// Require functionality divided into other files for manageability

foreach ( scandir( dirname( __FILE__ ) . '/includes' ) as $filename ) {
    $path = dirname( __FILE__ ) . '/includes/' . $filename;
    if (
        is_file( $path ) &&
        pathinfo( $filename, PATHINFO_EXTENSION ) === 'php' &&
        $filename != 'index.php'
    ) {
        require_once $path;
    }
}

function fobv_process_page () {

    // This function returns a 404 (not found) response for "process pages" if
    // there is an attempt to access them outside of their process flow. A
    // process page is a page that is shown in the dialog flow that occurs to
    // complete an end-to-end transaction after the form that initiates the
    // transaction has been submitted.

    global $post;

    $process_pages = [

        // These are the process pages identified by their slug; for each, one
        // or both of two attributes are set:
        //
        // parameters = An array of query parameters that the page will receive
        //              if called within its process flow.
        // referrers  = The path of the URLs, one of which will be the HTTP
        //              referrer if the page is called within its process flow.

        'donation-pledged' => [
            'parameters' => [ 'transaction' ],
            'referrers' => [ '/gift-aid/' ]
        ],
        'donation-cancelled' => [
            'parameters' => [ 'token' ]
        ],
        'donation-received' => [
            'parameters' => [ 'token', 'PayerID' ],
        ],
        'gift-aid' => [
            'parameters' => [ 'transaction' ],
            // Note that the gift-aid page only refers to itself in the rare
            // circumstance that Javascript is disabled and so the back-end
            // duplication of the validation of the gift-aid form redirects back
            // to the form to correct an error.
            'referrers' => [ '/gift-aid/', '/donate/', '/join-us/' ]
        ],
        'membership-confirmed' => [
            'referrers' => [ '/gift-aid/' ]
        ],
        'membership-confirmed-and-payment-cancelled' => [
            'parameters' => [ 'token' ]
        ],
        'membership-confirmed-and-payment-received' => [
            'parameters' => [ 'token', 'PayerID' ],
        ],
        'subscription-confirmed' => [
            'referrers' => [ '/' ]
        ]

    ];

    if (
        ! is_user_logged_in() && ! is_null( $post ) &&
        array_key_exists( $post->post_name, $process_pages )
    ) {

        $valid_call = TRUE;
        $page = $post->post_name;

        if ( array_key_exists( 'referrers', $process_pages[ $page ] ) ) {

            // Validate that have a referrer URL whose path is what we expected
            // it to be. If that's not the case then this is an invalid call.

            if (
                ! ( $rp = parse_url( wp_get_raw_referer(), PHP_URL_PATH ) )
                ||
                ! in_array( $rp, $process_pages[ $page ][ 'referrers' ] )
            ) {
                $valid_call = FALSE;
            }

        }

        if (
            $valid_call &&
            array_key_exists( 'parameters', $process_pages[ $page ] )
        ) {

            // So far we think that the call is valid but it must include the
            // expected query parameters to confirm that's the case, so check
            // them too now.

            $expected_parms = $process_pages[ $page ][ 'parameters' ];
            sort( $expected_parms );
            $actual_parms = array_keys( $_GET );
            sort( $actual_parms );

            if ( $actual_parms != $expected_parms ) {
                $valid_call = FALSE;
            }

        }

        if ( ! $valid_call ) {
            global $wp_query;
            $wp_query->set_404();
            status_header( 404 );
        }

    }

};

add_action( 'wp', 'fobv_process_page' );

function fobv_start_session() {
    if ( ! session_id() ) {
        session_start();
    };
}

add_action( 'init', 'fobv_start_session' );

function fobv_payment_reference ( $atts ) {

    // Function for outputting a payment reference on pages via a shortcode

    $atts = shortcode_atts( [
        'name' => NULL,
        'clear' => 'no'
    ], $atts );

    if ( $_SERVER[ 'REQUEST_METHOD' ] === 'GET' ) {
        $vars = $_GET;
    } elseif ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
        $vars = $_POST;
    }

    if ( array_key_exists( 'transaction', $vars ) ) {

        // We have been called from a page that is a step in an in-progress
        // transaction. Get the payment reference from the transaction data.

        $transaction = $vars[ 'transaction' ];
        if ( preg_match( '/^fobv_donate/', $transaction ) ) {
            $reference = $_SESSION[ $transaction ][ 'fobv_donate_reference' ];
        } elseif ( preg_match( '/^fobv_join_us/', $transaction ) ) {
            $reference = $_SESSION[ $transaction ][ 'fobv_join_us_reference' ];
        }

    } else {

        // We have been called from a page that will create a transaction but
        // one doesn't yet exists, so the payment reference is stored in the
        // session for now, until a transaction is created.

        if ( ! array_key_exists( 'payment_reference', $_SESSION ) ) {
            $_SESSION[ 'payment_reference' ] = wp_rand( 10000000, 99999999 );
        }

        $reference = $_SESSION[ 'payment_reference' ];

        if ( $atts[ 'clear' ] === 'yes' ) {

            // We've been asked to "clear" the payment reference from the
            // session. This is used to allow more than one payment reference to
            // be output on the same page.

            unset( $_SESSION[ 'payment_reference' ] );

        }
    
    }

    if ( isset( $atts['name'] ) ) {

        // If a name is provided then the payment reference is output as the
        // value of a hidden input field of that name. This is of course used to
        // include the payment reference in form submission.

        $return  = '<input type="hidden" name="';
        $return .= $atts['name'];
        $return .= '" value="';
        $return .= $reference;
        $return .= '">';

    } else {

        $return = $reference;

    }

    return $return;

}

add_shortcode( 'fobv-payment-reference', 'fobv_payment_reference' );

function fobv_write_log( $message, $divider = FALSE ) {

    if ( function_exists( 'varilink_write_log' ) ) {
        varilink_write_log( $message, $divider );
    }

};

//==============================================================================
// KADENCE THEME CUSTOMISATIONS
//==============================================================================

// Stop the page title from overlaying the page header banner image
add_action(
	'wp',
    function() {
		remove_action(
            'kadence_entry_hero',
	        'Kadence\kadence_entry_header',
	        10
        );
	}
);

// Display the page title at the top of the page content instead
add_action(
    'kadence_single_before_entry_content',
    function() {
        if ( is_singular( 'page' ) ) {
            the_title( '<h1 class="entry-title">', '</h1>' );
        }
    }
);

//==============================================================================
// EVENTS CALENDAR PLUGIN CUSTOMISATIONS
//==============================================================================

// Order events by start date and stop showing them when they've ended
add_filter( 'kadence_blocks_posts_query_args', function( $args ) {

    // Only alter queries for Events.
    if ( empty( $args['post_type'] ) || $args['post_type'] !== 'tribe_events' ) {
        return $args;
    }

    $now = current_time( 'mysql' );

    $args['meta_key'] = '_EventStartDate';
    $args['orderby']  = 'meta_value';
    $args['order']    = 'ASC';

    $args['meta_query'] = array(
        array(
            'key'     => '_EventEndDate',
            'value'   => current_time( 'mysql' ),
            'compare' => '>=',
            'type'    => 'DATETIME',
        ),
    );

    return $args;

}, 10 );
