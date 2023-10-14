<?php

// JQuery validate

add_action('wp_enqueue_scripts', function( $hook ) {

    wp_enqueue_script(
        'jquery-validate',
        'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js',
        ['jquery-core'],
        NULL
    );

} );
