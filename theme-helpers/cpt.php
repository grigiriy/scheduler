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
            'supports' => array(
                'page-attributes',
                'author',
                'editor',
                'title',
                'thumbnail',
                'excerpt'
                )
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );