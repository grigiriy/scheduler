<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head() ?>
</head>

<body>
    <div class="container">
        <div class="row d-flex">
            <div class="col-sm-6 col-xs-12 col-md-4 col-lg-3 logo mr-auto mt-3 pr-5">
                <a href="/">
                    <img class="mw-100" src="/wp-content/themes/scheduler_mvp/img/logo.png" alt="">
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-9 d-flex mt-3 mt-md-1">
                <div class="ml-md-auto mr-3">
                    <a href="/personal/" class="d-block p-2">
                        <?php if ( carbon_get_user_meta(get_current_user_id(),'avatar') ) { ?>
                        <img class="ava" id="ava_header" src="<?= carbon_get_user_meta(get_current_user_id(),'avatar'); ?>" alt="">
                        <?php } else { ?>
                        <img class="ava" id="ava_header" src="/wp-content/themes/scheduler_mvp/img/ava-default.svg" alt="">
                        <?php } ?>
                        <span class="ml-2 h5 text-dark align-middle">Profile</span>
                    </a>
                </div>
            <?php if( carbon_get_theme_option( 'teacher' ) ) { ?>
                <div class="mr-2">
                    <a href="/payment/" class="d-block p-2">
                        <svg version="1.1" class="ava w-100 text-dark" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512" xmlns:xlink="http://www.w3.org/1999/xlink"
                            enable-background="new 0 0 512 512" fill="currentColor">
                            <!-- Icons made by Vectors Market( https://www.flaticon.com/authors/vectors-market) from Flaticon (https://www.flaticon.com/) -->
                            <g>
                                <g>
                                    <path
                                        d="m490.6,222.6h-12.5v-84.4c0-19.8-15.6-35.4-34.4-35.4h-9.4v-56.4c0-19.8-14.6-35.4-32.3-35.4 0,0-1,0-2.1,0l-356.6,91.7c-0.1,0-0.3,0.1-0.4,0.1-17.6,1.4-31.9,16.5-31.9,35.4v327.4c0,19.8 15.6,35.4 34.4,35.4h398.3c19.8,0 35.4-15.6 35.4-35.4v-86.6h11.5c6.3,0 10.4-4.2 10.4-10.4v-135.5c5.68434e-14-6.3-5.2-10.5-10.4-10.5zm-86.6-191.8c5.2,1 10.4,7.3 10.4,15.6v56.3h-287.7l277.3-71.9zm54.3,434.8c0,8.3-6.3,15.6-14.6,15.6h-398.3c-8.3,0-14.6-7.3-14.6-15.6v-327.4c0-8.3 6.3-15.6 14.6-15.6h397.2c8.3,0 14.6,7.3 14.6,15.6v84.4h-103.2c-43.8,0-78.2,34.4-78.2,78.2 0,43.8 35.4,78.2 78.2,78.2h104.3v86.6zm21.8-106.4h-126.1c-31.3,0-57.3-26.1-57.3-57.3s26.1-57.3 57.3-57.3h126.1v114.6z" />
                                    <path
                                        d="m342.5,302.9c0,6.3 5.2,10.4 10.4,10.4h9.4c5.2,0 10.4-4.2 10.4-10.4 0-6.3-5.2-10.4-10.4-10.4h-9.3c-6.3,0-10.5,4.2-10.5,10.4z" />
                                </g>
                            </g>
                        </svg>

                        <span class="ml-2 h5 text-dark align-middle">Payment</span>
                    </a>
                </div>
            <?php } ?>
                <div>
                    <a href="/help/" class="d-block p-2">
                        <svg version="1.1" class="ava w-100 text-dark" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                            style="enable-background:new 0 0 512 512;" xml:space="preserve" fill="currentColor">
                            <!-- Icons made by Those Icons (https://www.flaticon.com/authors/those-icons) from Flaticon (https://www.flaticon.com/) -->
                            <g>
                                <g>
                                    <path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M245.333,426.667
                                        c-17.646,0-32-14.354-32-32s14.354-32,32-32c17.646,0,32,14.354,32,32S262.979,426.667,245.333,426.667z M277.333,296.542v34.125
                                        c0,5.896-4.771,10.667-10.667,10.667H224c-5.896,0-10.667-4.771-10.667-10.667v-53.333c0-23.521,19.146-42.667,42.667-42.667
                                        s42.667-19.146,42.667-42.667S279.521,149.333,256,149.333S213.333,168.479,213.333,192v10.667
                                        c0,5.896-4.771,10.667-10.667,10.667H160c-5.896,0-10.667-4.771-10.667-10.667V192c0-58.813,47.854-106.667,106.667-106.667
                                        S362.667,133.188,362.667,192C362.667,243.188,326.604,286.563,277.333,296.542z" />
                                </g>
                            </g>
                        </svg>

                        <span class="ml-2 h5 text-dark align-middle">Help</span>
                    </a>
                </div>
            </div>
        </div>

        <nav class="row my-5">
            <div class="col-12 d-flex">
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