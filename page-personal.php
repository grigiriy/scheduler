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

<div class="col-md-5 col-sm-12 pr-5">
    <div class="mb-5 border-top border-success">
        <?php
        if( carbon_get_theme_option( 'teacher' ) ) {
        get_template_part('theme-helpers/template-parts/account','payment');
        }
        get_template_part('theme-helpers/template-parts/personal','personal');
        ?>
    </div>
</div>

<div class="col-md-7 col-sm-12 px-0 border-top border-success">
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
        <div class="col-8 mx-auto">
            <?php get_template_part('theme-helpers/template-parts/account','dashboard'); ?>
        </div>
    <?php get_template_part('theme-helpers/template-parts/account','calendar'); ?>
    </div>
</div>




<?php
    }
get_footer(); ?>