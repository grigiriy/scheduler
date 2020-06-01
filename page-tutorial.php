<?php
/**
* Template Name: Tutorial
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

    wp_reset_postdata();

    global $now_incTZ;
    $post_id = $post->ID;
    $user_id = get_current_user_id();

    $yt_code = carbon_get_post_meta($post_id,'yt_code');
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
    $yt_code = $matches[0];

?>

<div class="col-12">
    <h1 class="d-flex" data-id="<?= $yt_code ?>">
        <?= get_the_title(); ?>
    </h1>

    <?php
    set_query_var( 'post_id', $post_id );
    ?>


    <?php get_template_part('theme-helpers/template-parts/tutorial','buttons');  ?>


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
    // if (event.data == YT.PlayerState.PLAYING) {
    // }
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