<?php
/**
 * Template Name: Manager Page
 */
get_header();

$role = get_userdata(get_current_user_id())->roles[0];
if( $role !== 'administrator' ) {
echo '<script>window.location.href = "/account/"</script>';
}
$args = array(
    'post_type'  => 'lessons',
    'course_status'   => 'started',
);

$wp_posts = get_posts($args);

if( count($wp_posts) ) {

    $timers=[];
    $current_lessons = [];

    foreach ( $wp_posts as $key=>$post ) {
        array_push($current_lessons,$post->ID);
        array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, 'timecode_1' ),$post->ID,'1']));
        array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, 'timecode_2' ),$post->ID,'2']));
        if( carbon_get_post_meta( $post->ID, 'timecode_3' ) ) {
            array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, 'timecode_3' ),$post->ID,'3']));
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

    while ( have_posts() ) :
        the_post();

        set_query_var( 'now_incTZ', $now_incTZ );
        set_query_var( 'timers', $timers );
?>
    <div class="col-12 h1">Now: <?= $now_incTZ; ?></div>
    <div class="col-12 flex-column border-top border-success">
        <div class="card shadow-lg bottom_rounded">
<?php get_template_part('theme-helpers/template-parts/admin','calendar'); ?>
        </div>
    </div>
<?php



endwhile; 
get_footer(); ?>