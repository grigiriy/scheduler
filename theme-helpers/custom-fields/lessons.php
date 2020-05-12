<?php

use WpGraphQLCrb\Container as WpGraphQLCrbContainer;
use Carbon_Fields\Container;
use Carbon_Fields\Field;


WpGraphQLCrbContainer::register(
Container::make( 'user_meta', 'Календарь' )
->add_fields( [
    Field::make( 'text', 'favor_lessons', 'Избранные уроки' ),
    Field::make( 'text', 'next_lesson', 'Cледующий урок' ),
    Field::make( 'text', 'paid_till', 'Оплачено до' ),
])
);

WpGraphQLCrbContainer::register(
Container::make( 'post_meta', 'Course details' )
->where( 'post_type', '=', 'lessons' )
->add_tab( 'course text', [
    Field::make( 'complex', 'detailed_sentences', 'Detailed sentences' )
    ->add_fields( [
        Field::make('textarea', 'sentence', 'Sentence')
        ->set_width( 50 ),
        Field::make('textarea', 'note_1', 'Note')
        ->set_width( 50 ),
    ])
])
->add_tab( 'lesson schedule', [
    Field::make('text', 'course_author_id', 'Teacher')
    ->set_width( 40 ),

    Field::make( 'checkbox', 't_passed', 'Teacher taught the lesson' )
    ->set_width( 30 )
    ->set_option_value( 'true' ),

    Field::make( 'checkbox', 'passed_0', 'Initial lesson passed' )
    ->set_width( 30 )
    ->set_option_value( 'true' ),

    Field::make('text', 'timecode_1', '1st reminder timecode')
    ->set_width( 70 ),
    Field::make( 'checkbox', 'passed_1', '1st reminder passed' )
    ->set_width( 30 )
    ->set_option_value( 'true' ),

    Field::make('text', 'timecode_2', '2nd reminder timecode')
    ->set_width( 70 ),
    Field::make( 'checkbox', 'passed_2', '2nd reminder passed' )
    ->set_width( 30 )
    ->set_option_value( 'true' ),

    Field::make('text', 'timecode_3', '3rd reminder timecode')
    ->set_width( 70 ),
    Field::make( 'checkbox', 'passed_3', '3rd reminder passed' )
    ->set_width( 30 )
    ->set_option_value( 'true' ),
])
);