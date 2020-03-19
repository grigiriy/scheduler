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

function display_day($next){
    if($next['month'] === getdate(strtotime("now"))['month']){
        if(getdate(strtotime("now"))['mday'] === $next['mday']){
            $next = 'Today';
            goto fin;
        } else if($next['mday'] - getdate(strtotime("now"))['mday'] == 1) {
            $next = 'Tomorrow';
            goto fin;
        } else if($next['mday'] - getdate(strtotime("now"))['mday'] == 7){
            $next = 'In a week';
            goto fin;
        } else {
            $next = $next['weekday'];
            goto fin;
        }
        $next = $next['weekday'];
    }
    fin:
    echo $next;
};

while ( have_posts() ) :
    the_post();

    $user_id = get_current_user_id();

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
    $passed_lessons = carbon_get_user_meta( $user_id, 'passed_lessons' );
?>


<div class="container">
    <main class="row">
        <section class="col-5 card py-3 order-2">
            <div class="row order-2">
                <div class="bg-success p-3 w-100">
                    <h3 class="text-">Schedule for next three days</h3>
                </div>
                <div class="p-3">
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
                    } ?>
                    <a href="/account/calendar" class="btn btn-light mt-3">Go to calendar</a>
                </div>
            </div>

            <div class=" row order-1">
                <div class="col-6">
                    <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt="" style="max-width:100%">
                    <p class="h3 text-center text-warning"><?= count(explode(',',$passed_lessons)); ?></p>
                    <a href="#" class="btn btn-link d-block">Already passed</a>
                </div>
                <div class="col-6">
                    <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt=""
                        style="max-width:100%; transform:scaleX(-1)">
                    <p class="h3 text-center text-warning"><?= $i; ?></p>
                    <a href="#" class="btn btn-link d-block">Current Lessons</a>
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
                        <a href="/cources/" class="btn btn-warning d-block">Choose next material</a>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-header d-flex">
                    <p class="card-title h2">Repeat this material <?= display_day(getdate($next)); ?></p>
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