<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <?php wp_head() ?>
</head>

<body>
    <div class="container">
        <div class="row d-flex">
            <div class="col-3 logo mr-auto mt-3 pr-5">
                <a href="/">
                    <img class="mw-100" src="/wp-content/themes/scheduler_mvp/img/logo.png" alt="">
                </a>
            </div>
            <div class="ml-auto">
                <a href="/personal/" class="d-block p-2">
                    <img class="ava" src="<?= get_avatar_url(get_current_user_id()); ?>" alt="">
                    <span class="ml-3 h5 text-dark align-middle">Profile</span>
                </a>
            </div>
        </div>

        <nav class="row my-5">
            <div class="col-12">
                <?php
                $params = array(
                    'container'=> false, // Без div обертки
                    'echo'=> false, // Чтобы можно было его предварительно вернуть
                    'items_wrap'=> '%3$s', // Разделитель элементов
                    'depth'=> 0, // Глубина вложенности
                    'theme_location' => 'user_menu',
                    'before' => '<strong>',
                    'after' => '</strong>',
                );
                print strip_tags(wp_nav_menu( $params ), '<a><strong>' );
                ?>
            </div>
        </nav>

        <main class="row">