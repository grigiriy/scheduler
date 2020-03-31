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
    
global $now_incTZ;

while ( have_posts() ) :
    the_post();

    $user_id = get_current_user_id();
    $next_lesson_adding_time = carbon_get_user_meta( $user_id, 'next_lesson' );
    $is_time_to_add = $next_lesson_adding_time <= $now_incTZ;
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
                    <img class="ava" src="<?= get_avatar_url($user_id); ?>" alt="">
                    <span class="ml-3 h4 text-dark align-middle">Profile</span>
                </a>
            </div>
        </div>
    </nav>
    <main class="row">

        <section class="col-md-5 col-sm-12 order-3">
            <div class="row mx-md-1">
                <div class="shadow-lg d-flex flex-column">
                    <div class="card order-2">
                        <div class="card-header bg-light col-12 p-3">
                            <h3>Schedule for next three days</h3>
                        </div>
                        <?php
                        if(isset($timers) && $timers ){
                        ?>
                        <div class="card-body p-0">
                            <table class=" table m-0">
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
                                        <td><?= display_day(getdate($timer[0])); ?></td>
                                        <td><?= getdate($timer[0])['hours'].':'.getdate($timer[0])['minutes'] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-center bg-white">
                            <a href="/account/calendar/" class="btn btn-info">Go to calendar</a>
                        </div>
                        <?php } else { ?>
                        <div class="m-3">
                            <p class="h3">No courses yet</p>
                            <p class="h4">Click <a href="/courses/">here</a> to start learning!</p>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="card order-1">
                        <div class="card-header">
                            <?php
                    $role = wp_get_current_user()->roles[0];
                    if(
                        $role === 'administrator' ||
                        $role === 'author' ||
                        $role === 'editor' 
                    ){ ?>
                            <p class="bg-light h3">
                                <a href="/add_post/">Add new Lesson</a>
                            </p>
                            <?php } ?>
                        </div>
                        <div class="card-body row">
                            <div class="col-6 pt-3">
                                <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt=""
                                    style="max-width:100%">
                                <p class="h3 text-center text-warning"><?= $passed_lessons; ?></p>
                                <a href="/account/passed/" class="btn btn-link d-block">Already passed</a>
                            </div>
                            <div class="col-6 pt-3">
                                <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt=""
                                    style="max-width:100%; transform:scaleX(-1)">
                                <p class="h3 text-center text-warning"><?= $current_lessons; ?></p>
                                <a href="/account/current/" class="btn btn-link d-block">Current Lessons</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <section class="col-md-7 col-sm-12 order-1">
            <div class="row mx-md-1">
                <h1>What do you have to do today?</h1>
                <?php if (($next_lesson_adding_time && $is_time_to_add) || !isset($timers)){ ?>
                <div class="card my-3 w-100 shadow-lg">
                    <div class="card-header">
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
                <?php }
                
                if(isset($timers) && $timers ){ ?>
                <div class="card my-3 w-100 shadow-lg" id="next_lesson_card">
                    <div class="card-header">
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
                    </div>
                    <?php if ($next_lesson_adding_time){ ?>
                    <div class="card-footer">
                        <p class="h3">You can add new lesson on <?= display_day(getdate($next_lesson_adding_time)); ?>
                        </p>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </section>
    </main>

</div>
<script>
const preview = document.getElementById('next_lesson_card').querySelector('figure');
if (preview.querySelector('img').naturalHeight < 720) {
    let oldSrc = preview.querySelector('img').getAttribute('src');
    let newSrc = oldSrc.replace('maxresdefault', '0');
    preview.querySelector('img').setAttribute('src', newSrc);
}
</script>
<?php endwhile; 
}
get_footer(); ?>