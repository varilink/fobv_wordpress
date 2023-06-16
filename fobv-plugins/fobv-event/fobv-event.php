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

// Register the start and end dates for the Event custom post type

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

// Queue the stylesheet and script for the panel we add to the document settings
// for the Event custom post type to allow entry of the start and end dates.

add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_style(
        'fobv-event',
        plugin_dir_url( __FILE__ ) . 'build/index.css',
	);
    wp_enqueue_script(
        'fobv-event',
        plugin_dir_url( __FILE__ ) . 'build/index.js',
		array(
			'wp-blocks', 'wp-components', 'wp-compose', 'wp-data',
			'wp-edit-post', 'wp-plugins'
		)
	);
} );

// Define the query to apply to posts of the Event post type.

function fobv_event_query ($query) {
	$query['meta_key'] = '_fobv_event_start_date';
	$query['orderby'] = 'meta_value';
	$query['meta_query'] = array(
		'relation' => 'OR',
		array(
			'relation' => 'AND',
			array(
				'key' => '_fobv_event_end_date',
				'value' => ''
			),
			array(
				'key' => '_fobv_event_start_date',
				'value' => date('Y-m-d'),
				'type' => 'DATE',
				'compare' => '>='
			)
		),
		array(
			'key' => '_fobv_event_end_date',
			'value' => date('Y-m-d'),
			'type' => 'DATE',
			'compare' => '>='
		)
	);
	return $query;
}
// Apply Event custom query in the front end.
add_filter(
	'query_loop_block_query_vars',
	function ( $query ) {
		if ( 'fobv-event' === $query['post_type'] ) {
			return fobv_event_query($query);
		} else {
			return $query;
		}
	}
);
// Apply Event custom query in the back end.
add_filter('rest_fobv-event_query', 'fobv_event_query');
