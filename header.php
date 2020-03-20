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