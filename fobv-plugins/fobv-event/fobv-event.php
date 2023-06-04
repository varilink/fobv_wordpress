<?php
/**
 * Plugin Name: FoBV Event Plugin
 * Description: Implements the FoBV Event custom post type.
 */

// Register the Event custom post type

add_action( 'init', function () {
    register_post_type(
        'fobv-event',
        array(
            'labels'    => array(
                'name'          => __( 'Events', 'textdomain '),
                'singular_name' => __( 'Event', 'textdomain' ),
                'all_items'     => __( 'All Events' ),
            ),
            'public'        => true,
            'has_archive'   => true,
            'menu_icon'     => 'dashicons-calendar',
            'rewrite'       => array( 'slug' => 'events'),
            'show_in_rest'  => true,
            'supports'      => array(
                'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'
            )
        )
    );    
} );

add_action( 'init', function () {
	$metafields = [ '_fobv_event_start_date', '_fobv_event_end_date' ];
	foreach ( $metafields as $metafield ) {
		register_post_meta (
			'fobv-event',
			$metafield,
			array (
				'show_in_rest' => true,
				'type' => 'string',
				'single' => true,
				'auth_callback' => function() { 
					return current_user_can( 'edit_posts' );
				}
			)
		);
	}
} );

add_action( 'enqueue_block_editor_assets', function () {
    wp_enqueue_script(
        'fobv-event',
        plugin_dir_url( __FILE__ ) . 'build/index.js',
		array(
			'wp-blocks', 'wp-components', 'wp-compose', 'wp-data',
			'wp-edit-post', 'wp-plugins'
		)
	);
} );

add_filter(
	'rest_fobv-event_query',
	function ( $args, $request ) {

#		varilink_write_log($args);

		$args['meta_key'] = '_fobv_event_start_date';
		$args['orderby'] = 'meta_value';
		return $args;

	},
	10,
	2
);

