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
<div class="container">
    <div class="row">

        <?php get_template_part('theme-helpers/template-parts/steps','fisrs'); ?>

        <?php get_template_part('theme-helpers/template-parts/steps','second'); ?>

        <?php get_template_part('theme-helpers/template-parts/steps','third'); ?>

        <?php get_template_part('theme-helpers/template-parts/steps','fourth'); ?>

    </div>
</div>
<?php
endwhile;
}
get_footer(); ?>