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
        $current_lessons = [];
        foreach ( $list as $key=>$el ) {
            array_push($current_lessons,$el['lesson_id']);
            if($el['first_reminder'] <= n_days_crop(3)){
                array_push($timers,implode(',',[$el['first_reminder'],$el['lesson_id']]));
            }
            if($el['second_reminder'] <= n_days_crop(3)){
                array_push($timers,implode(',',[$el['second_reminder'],$el['lesson_id']]));
            }
            if($el['third_reminder']) {
                if($el['third_reminder'] <= n_days_crop(3)){
                    array_push($timers,implode(',',[$el['third_reminder'],$el['lesson_id']]));
                }
            }
        }
        if(empty($timers)){ goto NotSoon;}
        sort($timers);
        $current_lessons = count(array_unique($current_lessons));
        $next = explode(',',$timers[0])[0];
        $current_lesson = explode(',',$timers[0])[1];

        
        if(carbon_get_user_meta( $user_id, 'passed_lessons' )){
            $passed_lessons = count(explode(',',carbon_get_user_meta( $user_id, 'passed_lessons' )));
        } else {
            $passed_lessons = 0;
        }

    } else {
        NotSoon:
        $current_lessons = 0;
        $passed_lessons = 0;
    }
    ?>

<div class="container">
    <main class="row">

        <section class="col-md-5 col-sm-12 card order-2 shadow-lg">
            <div class="row order-2">
                <div class="bg-light p-3 col-12">
                    <h3>Schedule for next three days</h3>
                </div>
                <?php
                if(isset($timers) && $timers ){
                ?>
                <table class="table">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">Lesson</th>
                            <th scope="col">Day</th>
                            <th scope="col">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($timers as $key=>$timer){
                                $timer = explode(',',$timer);
                            ?>
                        <tr class="bg-<?= ($key%2===0)?'light':'white' ?>">
                            <td><a href="<?= get_the_permalink($timer[1]);?>"
                                    class="text-info"><?= get_the_title($timer[1]) ?></a></td>
                            <td><?php display_day(getdate($timer[0])); ?></td>
                            <td><?= getdate($timer[0])['hours'].':'.getdate($timer[0])['minutes'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a href="/account/calendar/" class="btn btn-light mb-3 mx-auto">Go to calendar</a>
                <?php } else { ?>
                <div class="m-3">
                    <p class="h3">No courses yet</p>
                    <p class="h4">Click <a href="/courses/">here</a> to start learning!</p>
                </div>
                <?php } ?>
            </div>
            <div class="row order-1 pt-3">
                <div class="col-6">
                    <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt="" style="max-width:100%">
                    <p class="h3 text-center text-warning"><?= $passed_lessons; ?></p>
                    <a href="/account/passed/" class="btn btn-link d-block">Already passed</a>
                </div>
                <div class="col-6">
                    <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt=""
                        style="max-width:100%; transform:scaleX(-1)">
                    <p class="h3 text-center text-warning"><?= $current_lessons; ?></p>
                    <a href="/account/current/" class="btn btn-link d-block">Current Lessons</a>
                </div>
            </div>
        </section>

        <section class="col-md-7 col-sm-12 order-1">
            <div class="row mx-md-1">
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
                <div class="card my-3 w-100 shadow-lg">
                    <div class="card-header">
                        <?php if(!isset($timers) || !$timers ){ ?>
                        <p class="card-title h2 mb-0">Start learn a new material</p>
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
                <?php } else { ?>
                <p class="card-title h2 d-flex mb-0"><span>Repeat this material</span><span
                        class="badge badge-warning ml-auto"><?= display_day(getdate($next));?></span></p>
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
                <?php } ?>
            </div>
</div>
</div>
</section>
</main>

</div>

<?php endwhile; 
}
get_footer(); ?>