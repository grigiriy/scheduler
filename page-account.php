<?php
/**
 * Template Name: Account Page
 */
get_header();

if( !is_user_logged_in() ) {
?>
<script>
document.location.href = '/';
</script>

<?php
} else {

while ( have_posts() ) :
    the_post();

    $user_id = get_current_user_id();

    if(
        !empty(
            carbon_get_user_meta( $user_id, 'schedule' )
        )
    ){
    $list = carbon_get_user_meta( $user_id, 'schedule' );
    $timers=[];
    $selected_posts = [];
    foreach ( $list as $key=>$el ) {
        array_push($selected_posts,$el['lesson_id']);
        array_push($timers,$el['first_reminder']);
        array_push($timers,$el['second_reminder']);
        if($el['third_reminder']){
            array_push($timers,$el['third_reminder']);
        }
    }
    $next = $timers[0];
    for($i=0;$i<count($timers);$i++){
        $next = $timers[$i];
        if(strtotime("now")<=$timers[$i]){
        break;
        }
    }

    $args = array(
        'orderby'       =>  'post_date',
        'order'         =>  'DESC',
        'post__in'       =>  $selected_posts,
        'posts_per_page' => 5
        );
    $lessons_query = new WP_Query($args);
    $passed_lessons = count(explode(',',carbon_get_user_meta( $user_id, 'passed_lessons' )));
    } else {
        $passed_lessons = 0;
        $lessons_query=null;
        $i = 0;
    }
    ?>


<div class="container">
    <main class="row">
        <section class="col-5 card py-3 order-2">
            <div class="row order-2">
                <div class="bg-success p-3 col-12">
                    <h3 class="text-">Schedule for next three days</h3>
                </div>
                <div class="p-3 col-12">
                    <?php
                    if ($lessons_query) {
                    $i = 0;
                    while($lessons_query->have_posts()) : $lessons_query->the_post();
                    
                    if($i === 0) $current_lesson = $post->ID;
                    $i++;
                    ?>
                    <div class="row pt-3 my-1">
                        <div class="col-6">
                            <a href="<?= get_the_permalink();?>"><?= get_the_title() ?></a>
                        </div>
                        <div class="col-3">
                            <?php display_day(getdate($next)); ?>
                        </div>
                        <div class="col-3">
                            <?= getdate($next)['hours'].':'.getdate($next)['minutes'] ?>
                        </div>
                    </div>
                    <?php endwhile;
                    ?>
                    <a href="/account/calendar/" class="btn btn-light mt-3">Go to calendar</a>
                    <?php
                    } else {
                    ?>

                    <p class="h3">No courses yet</p>
                    <p class="h4">Click <a href="/courses/">here</a> to start learning!</p>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class=" row order-1">
                <div class="col-6">
                    <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt="" style="max-width:100%">
                    <p class="h3 text-center text-warning"><?= $passed_lessons; ?></p>
                    <a href="/account/passed/" class="btn btn-link d-block">Already passed</a>
                </div>
                <div class="col-6">
                    <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt=""
                        style="max-width:100%; transform:scaleX(-1)">
                    <p class="h3 text-center text-warning"><?= $i; ?></p>
                    <a href="/account/current/" class="btn btn-link d-block">Current Lessons</a>
                </div>
            </div>
        </section>

        <section class="col-7 order-1">
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


            <h1>What do you have to do today?</h1>
            <?php
            if(empty(
                carbon_get_user_meta( $user_id, 'schedule' )
            )) {
            ?>
            <div class="card my-3">
                <div class="card-header d-flex">
                    <p class="card-title h2">Start learn a new material</p>
                </div>
                <div class="card-body">
                    <figure class="d-flex">
                        <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt="" style="max-width:100%">
                        <figcaption class="text-center w-50">
                            <p class="h1">Yeee!</p>
                            <p>Something new!</p>
                        </figcaption>
                    </figure>
                    <div class="d-flex justify-content-around">
                        <a href="/courses/" class="btn btn-warning d-block">Choose next material</a>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php
            if(!empty(
                carbon_get_user_meta( $user_id, 'schedule' )
            )) {
            ?>
            <div class="card my-3">
                <div class="card-header">
                    <p class="card-title h2 d-flex"><span>Repeat this material</span><span
                            class="badge badge-warning ml-auto"><?= display_day(getdate($next)); ?></span></p>
                </div>
                <div class="card-body">
                    <figure class="figure row">
                        <?php
                        $yt_code = get_post_custom($current_lesson)['yt_code'][0];
                        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
                        $yt_code = $matches[0];
                        ?>
                        <img class="figure-img col-6" style="max-width:100%"
                            src="https://i.ytimg.com/vi/<?=$yt_code; ?>/maxresdefault.jpg">
                        <figcaption class="figure-caption col-6">
                            <p class="h4"><?= get_the_title($current_lesson); ?></p>
                            <a href="<?= get_the_permalink($current_lesson); ?>" class="btn btn-primary">Start</a>
                        </figcaption>
                    </figure>
                </div>
            </div>
            <?php } ?>
        </section>
    </main>



    <pre>
    <?php
    // print_r(get_user_meta($user_id));
    ?>
    </pre>
</div>

<?php endwhile; 
}
get_footer(); ?>