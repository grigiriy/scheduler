<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'user_meta', 'Календарь' )
->add_fields( [
    Field::make( 'complex', 'schedule', '' )
    ->add_fields( [
        Field::make('text', 'lesson_id', 'ID')
        ->set_width( 50 ),
        Field::make('text', 'cource_frequency', 'Type')
        ->set_width( 50 ),
        Field::make('text', 'first_reminder', 'First Reminder')
        ->set_width( 25 ),
        Field::make('text', 'second_reminder', 'Second Reminder')
        ->set_width( 25 ),
        Field::make('text', 'third_reminder', 'Third Reminder')
        ->set_width( 25 ),
        Field::make('text', 'fourth_reminder', 'Fourth Reminder')
        ->set_width( 25 ),
    ])
]);