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
$paid = carbon_get_user_meta( $user_id, 'paid_till' );
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
set_query_var( 'paid', $paid );
set_query_var( 'now_incTZ', $now_incTZ );
?>

<div class="col-12 ">
    <h1>Your profile</h1>
</div>

<div class="col-12 mb-5">
    <div class="d-flex justify-content-between w-50">
        <a href="#data" class="text-dark"><u>Your data</u></a>
        <a href="#calend" class="text-dark"><u>Learning calendar</u></a>
        <a href="#tutor" class="text-dark"><u>Your tutor</u></a>
    </div>
</div>

<div class="col-md-8 col-sm-12 pr-5">
    <div class="mb-5">
        <?php get_template_part('theme-helpers/template-parts/account','payment'); ?>
        <?php get_template_part('theme-helpers/template-parts/personal','personal'); ?>
    </div>
    <div class="d-flex flex-column border-top border-success">
        <div class="card shadow-lg bottom_rounded">
            <?php
            get_template_part('theme-helpers/template-parts/account','calendar');
            ?>
        </div>
    </div>
</div>

<div class="col-md-4 col-sm-12 px-0">
    <div class="card shadow-lg bottom_rounded top_rounded py-3 mb-5">
        <?php
        get_template_part('theme-helpers/template-parts/personal','tutor'); 
        ?>
    </div>

    <div class="card shadow-lg bottom_rounded top_rounded py-3">
        <?php
        get_template_part('theme-helpers/template-parts/account','dashboard'); 
        ?>
    </div>
</div>


<?php
// echo do_shortcode('[wp-recall]');
?>

<?php
    }
get_footer(); ?>