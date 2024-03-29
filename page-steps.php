<?php
/**
 * Template Name: Steps Page
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

        $post_id = $post->ID;
        $user_id = get_current_user_id();

        $yt_code = carbon_get_post_meta($post_id,'yt_code');
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
        $yt_code = $matches[0];
        
        $yt_code_2 = carbon_get_post_meta($post_id,'yt_code_2');
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code_2, $matches);
        $yt_code_2 = $matches[0];

        set_query_var( 'post_id', $post_id );
        set_query_var( 'user_id', $user_id );
        set_query_var( 'yt_code', $yt_code );
        set_query_var( 'yt_code_2', $yt_code_2 );
?>
<div class="container mt-5" id="steps" data-teacher="<?= carbon_get_theme_option( 'teacher' ) ? 'true' : 'false'; ?>">

    <?php
    $role = get_userdata($user_id)->roles[0];
        if( $role === 'administrator' ) {
            ?>
            <div class="row my-5">
                <button class="btn btn-light px-4 py-3" onclick="first_step()">1</button>
                <button class="btn btn-light px-4 py-3" onclick="second_step()">2</button>
                <button class="btn btn-light px-4 py-3" onclick="third_step()">3</button>
                <button class="btn btn-light px-4 py-3" onclick="fourth_step()">4</button>
            </div>
        <?php } ?>

    <div id="step_1" class="row" style="display:none">
        <?php get_template_part('theme-helpers/template-parts/steps','mode'); ?>
    </div>
    <div id="step_2" class="row" style="display:none">
        <?php get_template_part('theme-helpers/template-parts/steps','time'); ?>
    </div>
    <div id="step_3" class="row" style="display:none">
        <?php get_template_part('theme-helpers/template-parts/steps','notify'); ?>
    </div>
    <div id="step_4" class="row" style="display:none">
        <?php get_template_part('theme-helpers/template-parts/steps','intro'); ?>
    </div>

</div>

<script>
document.querySelector('nav').style.display = 'none';

const steps = document.querySelector('#steps');
const step_1 = steps.querySelector('#step_1');
const step_2 = steps.querySelector('#step_2');
const step_3 = steps.querySelector('#step_3');
const step_4 = steps.querySelector('#step_4');

const show_modes = steps.getAttribute('data-teacher') === 'true' ? true : false;

window.onload = function() {
    show_modes ? first_step() : second_step();
    set_labels();
};

function set_labels(){
    const steps_list = [step_1,step_2,step_3];
    const n = show_modes ? 1 : 0;
    for (let i = 0; i < steps_list.length; i++){
        steps_list[i].querySelector('h1').innerHTML = 'Step&nbsp;'+(i+n);
        console.log(steps_list[i].querySelector('h1'));
    }
}

function first_step() {
    step_1.style.display = 'flex';
    step_2.style.display = 'none';
    step_3.style.display = 'none';
    step_4.style.display = 'none';
}

function second_step() {
    step_1.style.display = 'none';
    step_2.style.display = 'flex';
    step_3.style.display = 'none';
    step_4.style.display = 'none';
}

function third_step() {
    step_1.style.display = 'none';
    step_2.style.display = 'none';
    step_3.style.display = 'flex';
    step_4.style.display = 'none';
}

function fourth_step() {
    step_1.style.display = 'none';
    step_2.style.display = 'none';
    step_3.style.display = 'none';
    step_4.style.display = 'flex';

    finish_reg($user_id);
}




var tag = document.createElement('script');
var tag_2 = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
tag.src_2 = "https://www.youtube.com/iframe_api";

var player_place = document.getElementById('player');
var player_place_2 = document.getElementById('player_2');

player_place.parentNode.insertBefore(tag, player_place);
player_place_2.parentNode.insertBefore(tag_2, player_place_2);

var player;
var player_2;
var yt_code = document.querySelector('#player').getAttribute('data-id');
var yt_code_2 = document.querySelector('#player_2').getAttribute('data-id');


function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        height: '500px',
        width: '100%',
        videoId: yt_code,
    });
    console.log('cc -> ', player.getOptions('cc'));

    player_2 = new YT.Player('player_2', {
        height: '500px',
        width: '100%',
        videoId: yt_code_2,
    });
    console.log('cc -> ', player_2.getOptions('cc'));
}

function stopVideo() {
    player.stopVideo();
}
</script>
<?php
endwhile;
}
get_footer(); ?>