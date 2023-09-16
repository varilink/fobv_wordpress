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
