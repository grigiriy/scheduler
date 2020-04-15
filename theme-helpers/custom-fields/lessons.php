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



Container::make( 'post_meta', 'Lesson details' )
->add_fields( [
    Field::make( 'complex', 'detailed_sentences', 'Detailed sentences' )
    ->add_fields( [
        Field::make('text', 'sentence', 'Sentence')
        ->set_width( 100 ),
        Field::make('text', 'translation', 'Translation')
        ->set_width( 100 ),
        Field::make('text', 'note_1', 'Note')
        ->set_width( 100 ),
    ])
]);