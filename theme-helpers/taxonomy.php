<?php

//*******************************************************************************//
// Taxonomies
//*******************************************************************************//

/**
 * Taxonomy clinics
 */

 register_taxonomy(
     'course_type',
     [
         'lessons',
     ],
     [
         'hierarchical' => false,
         'label' => 'Course Type',
         'show_ui' => true,
         'query_var' => true,
         'has_archive' => false,
         'singular_label' => 'Course Type'
     ]
 );

register_taxonomy(
    'course_status',
    [
        'lessons'
    ],
    [
        'hierarchical' => false,
        'label' => 'Course Status',
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => false,
        'singular_label' => 'Course Status'
    ]
);
flush_rewrite_rules(false);