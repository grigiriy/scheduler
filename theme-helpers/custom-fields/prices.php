<?php

use WpGraphQLCrb\Container as WpGraphQLCrbContainer;
use Carbon_Fields\Container;
use Carbon_Fields\Field;


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