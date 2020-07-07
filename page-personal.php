<?php
/**
 * Template Name: Personal Page
 */
get_header();

if( !is_user_logged_in() ) {
    ?>
<script>
document.location.href = '/';
</script>

<?php

} else {
$user_id = get_current_user_id();
set_query_var( 'user_id', $user_id );
$passed_lessons = get_passed_lessons_arr($user_id);

$is_paid = is_paid($user_id);
set_query_var( 'is_paid', $is_paid );

$active_mode = carbon_get_user_meta($user_id, 'mode');
$args = array(
    'post_type'  => 'lessons',
    'author'     => $user_id,
    'course_status'   => 'started',
);
$wp_posts = get_posts($args);
if( count($wp_posts) ) {

    $timers=[];
    $current_lessons = [];

    foreach ( $wp_posts as $key=>$post ) {
        array_push($current_lessons,$post->ID);

        if( carbon_get_post_meta( $post->ID, 'timecode_1') >= $now_incTZ && carbon_get_post_meta( $post->ID, '1_passed') !== 'true') {
            array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, 'timecode_1' ),$post->ID,'1']));
        }
        if( carbon_get_post_meta( $post->ID, 'timecode_2' ) >= $now_incTZ && carbon_get_post_meta( $post->ID, '2_passed') !== 'true') {
            array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, 'timecode_2' ),$post->ID,'2']));
        }
        if( carbon_get_post_meta( $post->ID, 'timecode_3' ) ) {
            if( carbon_get_post_meta( $post->ID, 'timecode_3' ) >= $now_incTZ && carbon_get_post_meta( $post->ID, '3_passed') !== 'true') {
                array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, 'timecode_3' ),$post->ID,'3']));
            }
        }
    }
    if(empty($timers)){ goto NotSoon;}
    sort($timers);
    $current_lessons = count(array_unique($current_lessons));
    $next = explode(',',$timers[0])[0];
    $current_lesson = explode(',',$timers[0])[1];
    $current_lesson_number = explode(',',$timers[0])[2];

} else {
    NotSoon:
    $current_lessons = 0;
}
wp_reset_postdata();

$next_lesson_adding_time = carbon_get_user_meta( $user_id, 'next_lesson' ) ? carbon_get_user_meta( $user_id, 'next_lesson' ) : strtotime(get_userdata( $user_id )->user_registered);

if (isset($passed_lessons) ) {
    set_query_var( 'passed_lessons', $passed_lessons );
}
if (isset($current_lessons) ) {
    set_query_var( 'current_lessons', $current_lessons );
}
if (isset($timers) ) {
    set_query_var( 'timers', $timers );
}
set_query_var( 'is_time_to_add', is_time_to_add($next_lesson_adding_time) );
set_query_var( 'next_lesson_adding_time', $next_lesson_adding_time );
set_query_var( 'calend_header', 'Your learning calendar' );
set_query_var( 'calend_days', '0' );
set_query_var( 'now_incTZ', $now_incTZ );
set_query_var( 'active_mode', $active_mode );
?>

<div class="col-12 mb-3">
    <h1>Your profile</h1>
</div>
<?php if (carbon_get_theme_option( 'teacher' )) { ?>
<div class="col-lg-6 col-sm-12 pr-lg-5 px-0 pl-lg-3">
    <div class="mb-5 border-top border-success">
        <?php
        get_template_part('theme-helpers/template-parts/account','payment');
        get_template_part('theme-helpers/template-parts/personal','personal');
        ?>
    </div>
</div>

<div class="col-lg-6 col-sm-12 px-0 border-top border-success">
    <?php if( carbon_get_theme_option( 'teacher' ) ) { ?>
    <div class="card shadow-lg bottom_rounded top_rounded py-3 mb-5">
        <?php
        get_template_part('theme-helpers/template-parts/personal','tutor'); 
        ?>
    </div>
    <?php } ?>
    <div class="card shadow-lg bottom_rounded">
        <div class="card-header border-0 bg-transparent">
            <p class="h4 mb-0">Your lessons</p>
        </div>
        <div class="col-md-9 col-12 mx-auto">
            <?php get_template_part('theme-helpers/template-parts/account','dashboard'); ?>
        </div>
    <?php get_template_part('theme-helpers/template-parts/account','calendar'); ?>
    </div>
</div>


<?php } else { ?>

    <div class="col-12 mb-3">
        <div class="card shadow-lg bottom_rounded top_rounded py-5 mb-5" id="configs">
            <div class="card-header bg-transparent border-bottom-0 pl-5">
                <p class="h3 mb-0">Account</p>
                <div class="my-3 _not_set"
                    style="<?= carbon_get_user_meta( $user_id, 'notify_email') ? 'display:none' :'' ?>">
                    <div class="col-2">
                        <div class="add_icon border-primary border text-primary py-2 text-center"
                            data-type="notify_email" data-new="true">+
                        </div>
                    </div>
                    <div class="col-10 smaller pl-0">
                        <p class="mb-1">Add your email:</p>
                        <p class="text-muted mb-1">Notification email</p>
                    </div>
                </div>
                <p class="my-3 _set"
                    style="<?= !carbon_get_user_meta( $user_id, 'notify_email') ? 'display:none' :'' ?>">
                    E-mail:
                    <span><?= carbon_get_user_meta( $user_id, 'notify_email' ) ?></span>
                    <span class="ml-3 text-primary edit" data-type="notify_email">
                        <svg viewBox="0 0 492.49284 492" width="0.8em" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#007bff"
                                d="m304.140625 82.472656-270.976563 270.996094c-1.363281 1.367188-2.347656 3.09375-2.816406 4.949219l-30.035156 120.554687c-.898438 3.628906.167969 7.488282 2.816406 10.136719 2.003906 2.003906 4.734375 3.113281 7.527344 3.113281.855469 0 1.730469-.105468 2.582031-.320312l120.554688-30.039063c1.878906-.46875 3.585937-1.449219 4.949219-2.8125l271-270.976562zm0 0">
                            </path>
                            <path fill="#007bff"
                                d="m476.875 45.523438-30.164062-30.164063c-20.160157-20.160156-55.296876-20.140625-75.433594 0l-36.949219 36.949219 105.597656 105.597656 36.949219-36.949219c10.070312-10.066406 15.617188-23.464843 15.617188-37.714843s-5.546876-27.648438-15.617188-37.71875zm0 0">
                            </path>
                            <!-- Icons made by Pixel perfect (https://www.flaticon.com/authors/pixel-perfect) for Flaticon (https://www.flaticon.com/) -->
                        </svg>
                        Edit</span>
                    <div class="invalid-feedback mb-3">
                        Please write valid e-mail
                    </div>
                <button class="btn btn-primary btn-round  py-3 px-4" data-toggle="modal" data-target="#reset">Reset password</button>
                </p>
            </div>
            <div class="row card-body">
                <div class="col-12 col-lg-7 ml-n1">
                    <?php get_template_part('theme-helpers/template-parts/settings','times'); ?>
                </div>
                <div class="col-12 col-lg-5">
                    <?php get_template_part('theme-helpers/template-parts/settings','sidebar'); ?>
                </div>
            </div>
        </div>
    </div>

<?php } ?>



<?php
    }
get_footer(); ?>