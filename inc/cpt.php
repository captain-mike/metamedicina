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
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields' ),
        )
    );
    register_post_type( 'trainer',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Trainers' ),
                'singular_name' => __( 'Trainer' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'trainers'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields' ),
        )
    );
    
    register_post_type( 'book',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Books' ),
                'singular_name' => __( 'Book' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'books'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields' ),
        )
    );

    register_post_type( 'city',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Cities' ),
                'singular_name' => __( 'city' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'cities'),
            'show_in_rest' => true,
            'supports' => array( 'title','revisions', 'custom-fields' ),
        )
    );
}
add_action( 'init', 'create_posttype' );