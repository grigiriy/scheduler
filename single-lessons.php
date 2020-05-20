<?php
/**
* Template Name: Lesson
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

    if( $childrens = get_children([
            'post_parent' => $post->ID,
            'author'=>get_current_user_id(),
            'post_type' => 'lessons',
        ])
    ) {
        ?>
<script>
document.location.href = '<?= array_shift($childrens)->guid; ?>';
</script>
<?php
    }
    wp_reset_postdata();

    global $now_incTZ;
    $post_id = $post->ID;
    $user_id = get_current_user_id();

    $yt_code = carbon_get_post_meta($post_id,'yt_code');
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
    $yt_code = $matches[0];


    $frequency = get_user_meta($user_id)['frequency'][0];

    $passed_lessons = get_passed_lessons_arr($user_id);

    $next_lesson_adding_time = carbon_get_user_meta( $user_id, 'next_lesson' ) ?
        carbon_get_user_meta( $user_id, 'next_lesson' ) :
        strtotime(get_userdata( $user_id )->user_registered);


    $is_learning = has_term( 'course_status', 'started', $post->ID );

    $timers = [
        carbon_get_post_meta( $post->ID, '1_timecode'),
        carbon_get_post_meta( $post->ID, '2_timecode')
    ];
    carbon_get_post_meta( $post->ID, '3_timecode' ) ? array_push($timers,carbon_get_post_meta( $post->ID, '3_timecode' )) : null;
    $current_lesson_number = 1;
    foreach ($timers as $key=>$timer){
        $current_lesson_number = $timer >= $now_incTZ ? $current_lesson_number + 1 : $current_lesson_number;
    }

?>

<div data-can_add="<?= is_time_to_add($next_lesson_adding_time) === true ? 'true' : '' ;?>"
    data-learning="<?= $is_learning === true ? 'true' : '' ;?>" class="col-12">
    <h1 class="d-flex" data-id="<?= $yt_code ?>">
        <div class="single-chart mr-2 align-self-center">
            <svg viewBox="0 0 40 40" class="circular-chart green">
                <path class="circle-bg" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path class="circle" stroke-dasharray="<?= progress_icon($current_lesson_number,$frequency); ?>, 100" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" />
            </svg>
        </div>
        <?= get_the_title(); ?>
    </h1>

    <?php
    set_query_var( 'is_time_to_add', is_time_to_add($next_lesson_adding_time) );
    set_query_var( 'is_learning', $is_learning );
    set_query_var( 'post_id', $post_id );

    
    if (isset($current_lesson_val) ) {
        set_query_var( 'current_lesson_val', $current_lesson_val );
    }
    if (isset($less_vals) ) {
        set_query_var( 'less_vals', $less_vals );
    }
    if (isset($next_lesson_adding_time) ) {
        set_query_var( 'next_lesson_adding_time', $next_lesson_adding_time );
    }
    ?>


    <?php get_template_part('theme-helpers/template-parts/lesson','buttons');  ?>


</div>
<div class="row col-12 mx-0">
    <div class="col-6 pl-0" style="display:none" id="text">
        <div class="bottom_rounded bg-white py-5 px-4">
            <?php the_content(); ?>
        </div>

    </div>
    <div id="player" class="mb-5"></div>
</div>
</div>
<script>
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";

var player_place = document.getElementById('player');
player_place.parentNode.insertBefore(tag, player_place);
var player;
var yt_code = document.querySelector('h1').getAttribute('data-id');

function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        height: '500px',
        width: '100%',
        videoId: yt_code,
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
    console.log('cc -> ', player.getOptions('cc'));
}

function onApiChange(event) {
    console.log('something changed...');
}

function onPlayerReady(event) {
    // event.target.playVideo();
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING) {
        lesson_passed();
    }
    console.log('cc -> ', player.getOptions('cc'));
}

function stopVideo() {
    player.stopVideo();
}
</script>

<?php
if(
    get_the_author_meta('ID') === $user_id &&
    $post->post_parent === 0
){
?>
<div class="card mt-5">
    <div class="card-header">
        <h3>Edit lesson info</h3>
    </div>
    <div class="card-body lesson_edit">
        <button class="btn"><a href="/add_post/?rcl-post-edit=<?= $post->ID; ?>">Edit Post</a></button>
    </div>
</div>

<?php } ?>

<?php endwhile; };?>

<?php get_footer(); ?>