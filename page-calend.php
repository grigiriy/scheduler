<?php
/**
 * Template Name: Calend Page
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

// $now_incTZ = $now_incTZ + (60*60*24);

$user_id = get_current_user_id();


$role = get_userdata($user_id)->roles[0];
if( $role === 'need-confirm' ) { ?>
    <script>document.location.href = '/reg-intro/'</script>
<?php }

$passed_lessons = get_passed_lessons_arr($user_id);

$active_mode = carbon_get_user_meta($user_id, 'mode');

$is_paid = is_paid($user_id);

set_query_var( 'is_paid', $is_paid );
set_query_var( 'active_mode', $active_mode );

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

        if( carbon_get_post_meta( $post->ID, 'timecode_1') >= $now_incTZ && carbon_get_post_meta( $post->ID, 'passed_1') !== 'true') {
            array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, 'timecode_1' ),$post->ID,'1']));
        }
        if( carbon_get_post_meta( $post->ID, 'timecode_2' ) >= $now_incTZ && carbon_get_post_meta( $post->ID, 'passed_2') !== 'true') {
            array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, 'timecode_2' ),$post->ID,'2']));
        }
        if( carbon_get_post_meta( $post->ID, 'timecode_3' ) ) {
            if( carbon_get_post_meta( $post->ID, 'timecode_3' ) >= $now_incTZ && carbon_get_post_meta( $post->ID, 'passed_3') !== 'true') {
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

while ( have_posts() ) :
    the_post();

if (isset($timers) ) {
    set_query_var( 'timers', $timers );
}
$next_lesson_adding_time = carbon_get_user_meta( $user_id, 'next_lesson' ) ? carbon_get_user_meta( $user_id, 'next_lesson' ) : strtotime(get_userdata( $user_id )->user_registered);
$is_time_to_add = is_time_to_add($next_lesson_adding_time);
set_query_var( 'next_lesson_adding_time', $next_lesson_adding_time );
set_query_var( 'is_time_to_add', $is_time_to_add );
set_query_var( 'now_incTZ', $now_incTZ );

$passed_lessons = get_passed_lessons_arr($user_id);
set_query_var( 'passed_lessons', $passed_lessons );
set_query_var( 'current_lessons', $current_lessons );
?>
<div class="col-12 mb-3">
    <h1>Calendar</h1>
</div>
<section class="col-12 col-lg-7">
    <div class="d-flex flex-column border-top border-success">
        <div class="card shadow-lg bottom_rounded">
            <?php
            set_query_var( 'calend_header', 'Your learning calendar' );
            set_query_var( 'calend_days', '0' );
            get_template_part('theme-helpers/template-parts/account','calendar');
            ?>
        </div>
    </div>
</section>
<section class="col-12 col-lg-5 mt-4 mt-lg-0">
    <div class="card shadow-lg bottom_rounded top_rounded">
    <?php get_template_part('theme-helpers/template-parts/account','dashboard'); ?>
    </div>
</section>
<?php endwhile; 
}
get_footer(); ?>