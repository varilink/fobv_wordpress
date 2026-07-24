<?php

/* Enqueue Styles */

function thr_enqueue_styles() {

    /* My child theme styleshee */
    wp_enqueue_style(
        'twenty-twenty-three-child-style',
        get_stylesheet_directory_uri() .'/style.css'
    );

    /* Fontawesome icons */
    wp_enqueue_style(
        'fontawesome',
        get_stylesheet_directory_uri() . '/assets/css/fontawesome-free.css'
    );

}

add_action('wp_enqueue_scripts', 'thr_enqueue_styles');

function fobv_featured_image_header () {

    $featured_image_header = <<<'EOD'
<!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"isDark":false} -->
<div class="wp-block-cover is-light">

    <span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim">
    </span>

    <div class="wp-block-cover__inner-container">

        <!-- wp:post-title {"textAlign":"center","level":1,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"textColor":"custom-color-3"} /-->

    </div>

</div>
<!-- /wp:cover -->
EOD;

    return has_post_thumbnail() ? $featured_image_header : NULL;

}

add_action( 'init', function () {

    add_shortcode( 'fobv-featured-image-header', 'fobv_featured_image_header' );

} );

define('THEME_NOVALIDATE', TRUE);
