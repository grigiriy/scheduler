<div class="container d-flex courses_nav">
    <?php
    $params = array(
        'container'=> false, // Без div обертки
        'echo'=> false, // Чтобы можно было его предварительно вернуть
        'items_wrap'=> '%3$s', // Разделитель элементов
        'depth'=> 0, // Глубина вложенности
        'menu' => 'courses_nav',
    );
    print strip_tags(wp_nav_menu( $params ), '<a>' );
    ?>
</div>