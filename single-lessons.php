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

    $active_mode = carbon_get_user_meta($user_id, 'mode');

    $yt_code = carbon_get_post_meta($post_id,'yt_code');
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
    $yt_code = $matches[0];
    $yt_code_2 = carbon_get_post_meta($post_id,'yt_code_2');


    $passed_lessons = get_passed_lessons_arr($user_id);

    $next_lesson_adding_time = carbon_get_user_meta( $user_id, 'next_lesson' ) ?
        carbon_get_user_meta( $user_id, 'next_lesson' ) :
        strtotime(get_userdata( $user_id )->user_registered);


    $is_learning = has_term( 'course_status', 'started', $post->ID );

    $timers = [
        carbon_get_post_meta( $post->ID, 'timecode_1'),
        carbon_get_post_meta( $post->ID, 'timecode_2')
    ];
    carbon_get_post_meta( $post->ID, 'timecode_3' ) ? array_push($timers,carbon_get_post_meta( $post->ID, 'timecode_3' )) : null;

    $checkboxes = [
        carbon_get_post_meta( $post->ID, 'passed_0'),
        carbon_get_post_meta( $post->ID, 'passed_1'),
        carbon_get_post_meta( $post->ID, 'passed_2')
    ];
    carbon_get_post_meta( $post->ID, 'passed_3' ) ? array_push($checkboxes,carbon_get_post_meta( $post->ID, 'passed_3' )) : null;


    $current_lesson_number = 0;
    foreach ($timers as $key=>$timer){
        if ($timer <= $now_incTZ) {
            $current_lesson_number = $current_lesson_number + 1;
            if ($checkboxes[$key+1]) {
                $current_lesson_number += 1;
            }
            $current_lesson_number = $current_lesson_number;
        }
    }
?>

<div data-can_add="<?= is_time_to_add($next_lesson_adding_time) === true ? 'true' : '' ;?>"
    data-learning="<?= $is_learning === true ? 'true' : '' ;?>" class="col-12">
    <h1 class="d-flex" data-id="<?= $yt_code ?>" data-time="<?= $yt_code_2 ?>">
        <div class="single-chart mr-2 align-self-center">
            <svg viewBox="0 0 40 40" class="circular-chart green">
                <path class="circle-bg" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path class="circle" stroke-dasharray="<?= progress_icon($current_lesson_number,$active_mode); ?>, 100"
                    d="M18 2.0845
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

    get_template_part('theme-helpers/template-parts/lesson','buttons');  ?>


</div>
<div class="row col-12 mx-0">
    <div class="col-12 col-md-6 pl-0 mb-md-0 mb-5" style="display:none" id="text">
        <div class="bottom_rounded bg-white py-5 px-4">
            <?php the_content(); ?>
            
        </div>
    </div>
    <div class="player_wrap w-100">
        <div class="player_wrapper">
            <div id="player" class="mb-5"></div>
        </div>
    </div>
</div>
</div>

<script>
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";

var player_place = document.querySelector('#player');
player_place.parentNode.insertBefore(tag, player_place);
var player;
var yt_code = document.querySelector('h1').getAttribute('data-id');
var yt_code_2 = document.querySelector('h1').getAttribute('data-time');

let args = {
    width: '100%',
    height: '100%',
    videoId: yt_code,
    playerVars: {
        'start': 1,
        // 'controls': 0
    },
    events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
    }
};

function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', args);
    console.log('cc -> ', player.getOptions('cc'));
}

function new_video(_video){
    args.playerVars.start = parseInt(_video);
    console.log(_video);
    player.destroy();
    player = new YT.Player('player', args);
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
document.querySelector('#player').style.height = (0.56*document.querySelector('#player').clientWidth)+'px';
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