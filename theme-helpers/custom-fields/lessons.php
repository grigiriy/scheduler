<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'user_meta', 'Календарь' )
->add_fields( [
    Field::make( 'complex', 'schedule', 'Текущие уроки' )
    ->add_fields( [
        Field::make('text', 'first_reminder', '1 Reminder')
        ->set_width( 30 ),
        Field::make('text', 'second_reminder', '2 Reminder')
        ->set_width( 30 ),
        Field::make('text', 'third_reminder', '3 Reminder')
        ->set_width( 30 ),
        Field::make('text', 'lesson_id', 'ID')
        ->set_width( 30 ),
        Field::make('text', 'current_lesson', 'Current')
        ->set_width( 30 ),
        Field::make('text', 'missed_lessons', 'Missed')
        ->set_width( 30 ),
    ]),
    Field::make( 'text', 'passed_lessons', 'Пройденные уроки' ),
    Field::make( 'text', 'favor_lessons', 'Избранные уроки' ),
    Field::make( 'text', 'next_lesson', 'Cледующий урок' ),
    Field::make( 'text', 'prev_pract_vals', 'Prev_pract_vals' )

]);



Container::make( 'post_meta', 'Course details' )
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
    Field::make('text', 'course_author_id', 'Course Author ID')
    ->set_width( 40 ),

    Field::make( 'checkbox', 't_passed', 'Teacher taught the lesson' )
    ->set_width( 30 )
    ->set_option_value( 'true' ),

    Field::make( 'checkbox', '0_passed', 'Initial lesson passed' )
    ->set_width( 30 )
    ->set_option_value( 'true' ),

    Field::make('text', '1_timecode', '1st reminder timecode')
    ->set_width( 70 ),
    Field::make( 'checkbox', '1_passed', '1st reminder passed' )
    ->set_width( 30 )
    ->set_option_value( 'true' ),

    Field::make('text', '2_timecode', '2nd reminder timecode')
    ->set_width( 70 ),
    Field::make( 'checkbox', '2_passed', '2nd reminder passed' )
    ->set_width( 30 )
    ->set_option_value( 'true' ),

    Field::make('text', '3_timecode', '3rd reminder timecode')
    ->set_width( 70 ),
    Field::make( 'checkbox', '3_passed', '3rd reminder passed' )
    ->set_width( 30 )
    ->set_option_value( 'true' ),
]);