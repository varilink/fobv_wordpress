<?php
/*
Plugin Name: Friends of Bennerley Viaduct Site Plugin
Description: Main site level plugin for the Friends of Bennerley Viaduct website
*/

// Category for any site specific blocks that we might define

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
