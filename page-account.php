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

$user_id = get_current_user_id();

$passed_lessons = get_passed_lessons_arr($user_id);

$frequency = get_user_meta($user_id)['frequency'][0];
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
$is_time_to_add = $next_lesson_adding_time <= $now_incTZ;

while ( have_posts() ) :
    the_post();


if (isset($timers) ) {
    set_query_var( 'timers', $timers );
}
if (isset($next) ) {
    set_query_var( 'next', $next );
}
if (isset($current_lesson) ) {
    set_query_var( 'current_lesson', $current_lesson );
}
if (isset($current_lesson_number) ) {
    set_query_var( 'current_lesson_number', $current_lesson_number );
}
if (isset($passed_lessons) ) {
    set_query_var( 'passed_lessons', $passed_lessons );
}
if (isset($current_lessons) ) {
    set_query_var( 'current_lessons', $current_lessons );
}
if (isset($frequency) ) {
    set_query_var( 'frequency', $frequency );
}
set_query_var( 'is_time_to_add', $is_time_to_add );
set_query_var( 'next_lesson_adding_time', $next_lesson_adding_time );
set_query_var( 'paid', $paid );
set_query_var( 'now_incTZ', $now_incTZ );
?>

<div class="col-12 mb-3">
    <h1>What do you have to do today?</h1>
</div>

<section class="col-md-8 col-sm-12 pr-5">
    <?php
        get_template_part('theme-helpers/template-parts/account','new_day'); 
        get_template_part('theme-helpers/template-parts/account','new_lesson'); 
    ?>
</section>

<section class="col-md-4 col-sm-12 px-0">
    <div class="border-bottom border-success mb-2">
        <?php
        get_template_part('theme-helpers/template-parts/account','payment');
        get_template_part('theme-helpers/template-parts/account','new_course'); //not ready yet - teachers shield
        ?>
    </div>
    <div class="d-flex flex-column border-top border-success">
        <div class="card shadow-lg bottom_rounded">
            <?php
            set_query_var( 'calend_header', 'Schedule for next three days' );
            set_query_var( 'calend_days', 3 );

            get_template_part('theme-helpers/template-parts/account','dashboard'); 
            get_template_part('theme-helpers/template-parts/account','calendar');
            ?>
        </div>
    </div>
</section>

<script>
const preview = document.getElementById('next_lesson_card').querySelector('.lesson_thumbnail');
if (preview.querySelector('img').naturalHeight < 720) {
    let oldSrc = preview.querySelector('img').getAttribute('src');
    let newSrc = oldSrc.replace('maxresdefault', '0');
    preview.querySelector('img').setAttribute('src', newSrc);
}
</script>
<?php endwhile; 
}
get_footer(); ?>