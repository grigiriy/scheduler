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

register_taxonomy(
    'course_level',
    [
        'lessons'
    ],
    [
        'hierarchical' => false,
        'label' => 'Course Level',
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => false,
        'singular_label' => 'Course Level'
    ]
);

register_taxonomy(
    'course_duration',
    [
        'lessons'
    ],
    [
        'hierarchical' => false,
        'label' => 'Course Duration',
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => false,
        'singular_label' => 'Course Duration'
    ]
);

register_taxonomy(
    'course_tag',
    [
        'lessons'
    ],
    [
        'hierarchical' => false,
        'label' => 'Course Tag',
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => false,
        'singular_label' => 'Course Tag'
    ]
);
flush_rewrite_rules(false);