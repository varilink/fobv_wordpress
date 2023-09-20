<?php
/*
 * Plugin Name: FoBV Site Plugin
 * Description: Site plugin for the FoBV website.
 */

// Require functionality divided into other files for manageability

foreach ( scandir( dirname( __FILE__ ) . '/includes' ) as $filename ) {
    $path = dirname( __FILE__ ) . '/includes/' . $filename;
    if ( is_file( $path ) && $filename != 'index.php' ) {
        require $path;
    }
}

// Block explorer category for any site specific blocks that we might define.

add_filter(
    'block_categories_all',
    function ( $categories ) {
        array_unshift(
            $categories,
            array(
                'slug' => 'fobv',
                'title' => 'FoBV'
            )
        );
        return $categories;
    }
);

add_action( 'wp', function () {

    global $post;

    $process_pages = [
        'gift-aid' => '/support-the-fobv/',
        'subscribe-successful' => '/latest-news/'
    ];

    if (
        ! is_user_logged_in() && ! is_null( $post ) &&
        array_key_exists( $post->post_name, $process_pages ) &&
        site_url() . $process_pages[ $post->post_name ] != wp_get_referer()
    ) {

        global $wp_query;
        $wp_query->set_404();
        status_header(404);
    }

} );

function fobv_start_session() {
    if ( ! session_id() ) {
        session_start();
    };
}

add_action( 'init', 'fobv_start_session' );

function fobv_payment_reference ( $atts ) {

    $atts = shortcode_atts( [
        'name' => NULL
    ], $atts );

    if ( ! array_key_exists( 'payment_reference', $_SESSION ) ) {
        $_SESSION[ 'payment_reference' ] = wp_rand( 10000000, 99999999 );
    }

    if ( isset( $atts['name'] ) ) {
        $return  = '<input type="hidden" name="';
        $return .= $atts['name'];
        $return .= '" value="';
        $return .= $_SESSION[ 'payment_reference' ];
        $return .= '">';
    } else {
        $return = $_SESSION[ 'payment_reference' ];
    }

    return $return;

}

add_shortcode( 'fobv-payment-reference', 'fobv_payment_reference' );

function fobv_write_log( $message ) {

    if ( function_exists( 'varilink_write_log' ) ) {
        varilink_write_log( $message, 'FOBV' );
    }

};