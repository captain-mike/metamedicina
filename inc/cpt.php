<?php

function create_posttype() {
 
    register_post_type( 'calendar',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Calendars' ),
                'singular_name' => __( 'Calendar' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'calendars'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
        )
    );
    register_post_type( 'trainer',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'trainers' ),
                'singular_name' => __( 'trainer' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'trainers'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
        )
    );
}
add_action( 'init', 'create_posttype' );