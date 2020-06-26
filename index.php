<?php
/**
 * Template Name: Main
 */
 get_header(); 


if( is_user_logged_in() && get_userdata(get_current_user_id())->roles[0] !== 'administrator' ) { ?>
<script>
document.location.href = '/account/';
</script>
<?php } else {

$yt_code_2 = carbon_get_post_meta('299','yt_code_2'); //299 - reg_intro
preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code_2, $matches);
$yt_code_2 = $matches[0];
set_query_var( 'yt_code_2', $yt_code_2 );
?>
    
<div class="container pt-5">
    <h1>Let’s learn English easily!</h1>
    <div class="row">
        <div class="col-12 col-lg-7">
            <p class="much-larger my-3">1. Watch the video tutorial and sign up</p>
            <div id="player_2" data-id="<?= $yt_code_2 ?>" class="mb-5"></div>
        </div>
        <div class="col-12 col-lg-5">
            <p class="much-larger my-3">2. Log in</p>
            <div class="card shadow-lg bottom_rounded top_rounded py-3 mb-5">
                <div class="px-sm-5 px-1">
                    <?= do_shortcode('[ultimatemember form_id="311"]'); ?>
                    <p class="text-center">Already have an account?<span class="arrow_symbol mx-3">⟶</span>
                        <a href="javascript:void(0)" data-target="#login" data-toggle="modal" onclick="push_hash(this)">Log in.</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('nav').style.display = 'none';

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";

var player_place = document.getElementById('player_2');
player_place.parentNode.insertBefore(tag, player_place);

var player_2;
var yt_code_2 = player_place.getAttribute('data-id');


function onYouTubeIframeAPIReady() {
    player_2 = new YT.Player('player_2', {
        height: '500px',
        width: '100%',
        videoId: yt_code_2,
    });
    console.log('cc -> ', player_2.getOptions('cc'));
}

function stopVideo() {
    player_2.stopVideo();
}
</script>

<?php
}
get_footer(); ?>