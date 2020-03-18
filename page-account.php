<?php
/**
 * Template Name: Account Page
 */
get_header();

if( !is_user_logged_in() ) {
?>
<script>
document.location.href = 'https://ya.ru';
</script>

<?php
} else {
while ( have_posts() ) :
    the_post();

    $user_id = get_current_user_id();

    $list = carbon_get_user_meta( $user_id, 'schedule' );
    $selected_posts = [];
    foreach ( $list as $el ) {
        array_push($selected_posts,$el['lesson_id']);
    }

    $args = array(
        'orderby'       =>  'post_date',
        'order'         =>  'DESC',
        // 'post__in'       =>  $selected_posts,
        'posts_per_page' => 5
        );
    $lessons_query = new WP_Query($args);
?>


<div class="container">
    <main class="row">
        <section class="col-7">
            <nav class="d-flex">
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
            </nav>


            <h1>Что надо сделать сегодня?</h1>
            <div class="card">
                <div class="card-header d-flex">
                    <p class="card-title h2">Добавить материал</p>
                </div>
                <div class="card-body">
                    <figure class="d-flex">
                        <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt="" style="max-width:100%">
                        <figcaption class="text-center w-50">
                            <p class="h1">
                                Yeeee!
                            </p>
                            <p>Что-то новенькое!</p>
                        </figcaption>
                    </figure>
                    <div class="d-flex justify-content-around">

                        <a href="/add_post/" class="btn btn-warning d-block">Добавить свой материал</a>
                        <a href="/cources/" class="btn btn-info d-block">Добавить из подборки</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex">
                    <p class="card-title h2">Повторить материал</p>
                </div>
                <div class="card-body">
                    <figure>
                        <figcaption>
                            <p class="h4">11 Different ways to say "Thank You"</p>
                            <a href="#" class="btn btn-primary">Начать</a>
                        </figcaption>
                    </figure>
                </div>
            </div>

        </section>
        <section class="col-5 card py-3">
            <h2>Твои материалы</h2>
            <div class=" row">
                <div class="col-6">
                    <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt="" style="max-width:100%">
                    <p class="h3 text-center text-warning">400</p>
                    <a href="#" class="btn btn-link d-block">Изученные матеариалы</a>
                </div>
                <div class="col-6">
                    <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt=""
                        style="max-width:100%; transform:scaleX(-1)">
                    <p class="h3 text-center text-warning">400</p>
                    <a href="#" class="btn btn-link d-block">Еще учится</a>
                </div>
            </div>
            <div class="row bg-success p-3">
                <h3 class="text-">Расписание на ближайшие 3 дня</h3>
            </div>
            <?php
            if ($lessons_query) {
            while($lessons_query->have_posts()) : $lessons_query->the_post();
            ?>
            <div class="row pt-3 my-1">
                <div class="col-6">
                    <a href="<?= get_permalink();?>"><?= the_title() ?></a>
                </div>
                <div class="col-3">
                    сегодня
                </div>
                <div class="col-3">
                    9 PM
                </div>
            </div>
            <?php
            endwhile;
            }
            ?>
            <a href="#" class="btn btn-light mt-3">Посмотреть в календаре</a>
        </section>
    </main>
</div>

<?php endwhile; 
}
get_footer(); ?>