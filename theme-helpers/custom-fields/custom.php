<?php

use WpGraphQLCrb\Container as WpGraphQLCrbContainer;
use Carbon_Fields\Container;
use Carbon_Fields\Field;


WpGraphQLCrbContainer::register(
Container::make( 'user_meta', 'Календарь' )
->add_fields( [
    Field::make( 'text', 'mode', 'Режим' ),
    Field::make( 'text', 'favor_lessons', 'Избранные уроки' ),
    Field::make( 'text', 'next_lesson', 'Cледующий урок' ),
    Field::make( 'text', 'new_lessons_left', 'Осталось новых уроков' ),
    Field::make( 'text', 'mrng_practice', 'Утренняя практика' ),
    Field::make( 'text', 'evng_practice', 'Вечерняя практика' ),
])
);

WpGraphQLCrbContainer::register(
    Container::make( 'user_meta', 'Контактная информация' )
    ->add_fields( [
        Field::make( 'text', 'avatar', 'Аватар' ),
        Field::make( 'text', 'phone', 'Телефон' ),
        Field::make( 'text', 'skype', 'Skype' ),
        Field::make( 'text', 'notify_email', 'Имейл для уведомлений' ),
        Field::make( 'checkbox', 'notify_browser', 'Уведомления в браузере (может быть не корректно)' )
        ->set_option_value( 'true' ),
    ])
);


WpGraphQLCrbContainer::register(
Container::make( 'post_meta', 'Video' )
->where( 'post_id', '=', '281' ) //NEED TO UPDATE LATER
->or_where( 'post_id', '=', '299' ) //NEED TO UPDATE LATER
->add_tab( 'course info', [
    Field::make('text', 'yt_code', 'YouTube code'),
    Field::make('text', 'yt_code_2', 'YouTube code 2 (steps only)')
    ])
);



WpGraphQLCrbContainer::register(
Container::make( 'post_meta', 'Course details' )
->where( 'post_type', '=', 'lessons' )
->add_tab( 'course info', [
    // Field::make( 'complex', 'detailed_sentences', 'Detailed sentences' )
    // ->add_fields( [
    //     Field::make('rich_text', 'sentence', 'Sentence')
    //     ->set_width( 50 ),
    //     Field::make('textarea', 'note_1', 'Note')
    //     ->set_width( 50 ),
    // ])
    Field::make('text', 'yt_code', 'YouTube code')
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



WpGraphQLCrbContainer::register(
Container::make( 'post_meta', 'Пакеты' )
->where( 'post_template', '=', 'page-payment.php' )
    ->add_tab( 'default_price', [
        Field::make( 'text', 'default_price', 'Стоимость урока по умолчанию' )
    ])
    ->add_tab( 'prices', [
    Field::make( 'complex', 'prices', 'Пакеты' )
        ->add_fields( [
            Field::make( 'text', 'price', 'Сумма' )
            ->set_width( 50 ),
            Field::make( 'text', 'count', 'Количество уроков' )
            ->set_width( 50 ),
        ])
    ])
);

WpGraphQLCrbContainer::register(
    Container::make( 'post_meta', 'Режимы' )
    ->where( 'post_template', '=', 'page-modes.php' )
    ->add_tab( 'modes', [
        Field::make( 'text', 'days_to_new', 'Дней между уроками (новыми)' ),
        Field::make( 'complex', 'modes', 'Режимы' )
        ->add_fields( [
            Field::make( 'text', 'name', 'Название режима' ),
            Field::make( 'text', 'color', 'Цвет режима' ),
            Field::make( 'rich_text', 'first_day', 'Первый день' ),
            Field::make( 'rich_text', 'second_day', 'Другие дни' ),
        ])
    ])
);



WpGraphQLCrbContainer::register(
Container::make( 'theme_options', 'Опции' )
    ->add_fields( [
        Field::make( 'text', 'free_courses', 'Бесплатных Новых уроков при реге' ),
        Field::make( 'checkbox', 'teacher', 'С учителем' )
        ->set_option_value( 'true' ),
    ] )
);