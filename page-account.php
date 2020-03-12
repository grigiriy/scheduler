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
    $args = array(
        'author'        =>  $current_user->ID,
        'orderby'       =>  'post_date',
        'order'         =>  'ASC',
        'posts_per_page' => 1
        );
    $lessons_query = new WP_Query($args);

?>


<div class="container">
    <main class="row">
        <section class="col-7">
            <h1>Что надо сделать сегодня?</h1>
            <div class="card">
                <div class="card-header d-flex">
                    <span><?= time(); ?></span>
                    <p class="card-title h2">Добавить материал</p>
                </div>
                <div class="card-body d-flex">
                    <figure>
                        <img src="" alt="">
                        <figcaption>
                            <p class="h1">
                                Yeeee!
                            </p>
                            <p>Что-то новенькое!</p>
                        </figcaption>
                    </figure>
                    <div class="ml-auto">
                        <a href="#" class="btn btn-warning d-block">Добавить свой материал</a>
                        <a href="#" class="btn btn-info d-block">Добавить из подборки</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex">
                    <span><?= time(); ?> </span>
                    <p class="card-title h2">Повторить материал</p>
                    <span>rating</span>
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
        <section class="col-5">
            <h2>Твои материалы</h2>
            <div class="d-flex">
                <div class="card">
                    <p class="h3">400</p>
                    <img src="" alt="">
                    <a href="#" class="btn btn-link">Изученные матеариалы</a>
                </div>
                <div class="card">
                    <p class="h3">400</p>
                    <img src="" alt="">
                    <a href="#" class="btn btn-link">Изученные матеариалы</a>
                </div>
            </div>
            <h2>Расписание на ближайшие 3 дня</h2>
            <div class="row">
                <?php
                if ($lessons_query) {
                while($lessons_query->have_posts()) : $lessons_query->the_post();
                ?>
                <div class="col-5">
                    <a href=""><?= the_title(); ?></a>
                </div>
                <div class="col-2">
                    rating
                </div>
                <div class="col-3">
                    сегодня
                </div>
                <div class="col-2">
                    9 PM
                </div>
                <?php
                endwhile;
                }
                ?>
            </div>
            <hr>
            <a href="#" class="btn btn-light ">Посмотреть в календаре</a>
        </section>
    </main>
</div>

<?php endwhile; 
}
print_r($rcl_user_URL);
get_footer(); ?>