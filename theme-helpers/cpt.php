<?php

// Our custom post type function
function create_posttype() {
 
    register_post_type( 'lessons',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Lessons' ),
                'singular_name' => __( 'Lesson' )
            ),
            'public' => true,
            'hierarchical' => true,
            'has_archive' => true,
            // 'rewrite' => array('slug' => 'lessons'),
            'show_in_rest' => true,
            'show_in_graphql' => true,
            'graphql_single_name' => 'Lesson',
            'graphql_plural_name' => 'Lessons',
            'supports' => array(
                'page-attributes',
                'author',
                'editor',
                'title',
                'thumbnail',
                'excerpt',
                'custom-fields'
                )
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );