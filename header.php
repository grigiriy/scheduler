<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head() ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <header>
        <div class="container-fluid">
            <div class="row" id="nav">
                <?php
                wp_nav_menu([
                'container' => '',
                'theme_location' => 'header_menu',
                'items_wrap' => '<ul class="nav">%3$s</ul>'
                ]); 
            ?>
            </div>
        </div>
    </header>
    <div class="container">
        <nav class="row mt-3">
            <div class="col-md-7 col-sm-12 ">
                <?php
                $params = array(
                    'container'=> false, // Без div обертки
                    'echo'=> false, // Чтобы можно было его предварительно вернуть
                    'items_wrap'=> '%3$s', // Разделитель элементов
                    'depth'=> 0, // Глубина вложенности
                    'theme_location' => 'user_menu',
                );
                print strip_tags(wp_nav_menu( $params ), '<a>' );
                ?>
            </div>
            <div class="col-md-5 col-sm-12 text-right">
                <div class="badge badge-light">
                    <a href="/personal/" class="d-block p-3">
                        <img class="ava" src="<?= get_avatar_url(get_current_user_id()); ?>" alt="">
                        <span class="ml-3 h4 text-dark align-middle">Profile</span>
                    </a>
                </div>
            </div>
        </nav>

        <main class="row">