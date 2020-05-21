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


        set_query_var( 'post_id', $post_id );
        set_query_var( 'user_id', $user_id );
        set_query_var( 'yt_code', $yt_code );
?>
<div class="container" id="steps">

    <div id="step_1" class="row">
        <?php get_template_part('theme-helpers/template-parts/steps','first'); ?>
    </div>
    <div id="step_2" class="row">
        <?php get_template_part('theme-helpers/template-parts/steps','second'); ?>
    </div>
    <div id="step_3" class="row">
        <?php get_template_part('theme-helpers/template-parts/steps','third'); ?>
    </div>
    <div id="step_4" class="row">
        <?php get_template_part('theme-helpers/template-parts/steps','fourth'); ?>
    </div>

</div>

<script>
const steps = document.querySelector('#steps');
const step_1 = steps.querySelector('#step_1');
const step_2 = steps.querySelector('#step_2');
const step_3 = steps.querySelector('#step_3');
const step_4 = steps.querySelector('#step_4');
window.onload = function() {
    step_2.style.display = 'none';
    step_3.style.display = 'none';
    step_4.style.display = 'none';
};

function second_step() {
    step_1.style.display = 'none';
    step_2.style.display = 'block';
}
</script>
<?php
endwhile;
}
get_footer(); ?>