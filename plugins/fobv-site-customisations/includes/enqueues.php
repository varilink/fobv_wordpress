<?php

// JQuery and JQuery Validate

add_action(
	'wp_enqueue_scripts',
	function() {
		wp_enqueue_script( 'jquery' );
        wp_enqueue_script(
            'jquery-validate',
            plugin_dir_url( __DIR__ ) . 'js/jquery-validation/dist/jquery.validate.min.js',
            array( 'jquery' )
        );
	}
);
