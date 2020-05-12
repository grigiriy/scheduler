<?php
/**
 * Template Name: Modes Page
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
    $modes = carbon_get_post_meta($post->ID, 'modes');
    while ( have_posts() ) :
        the_post();
?>
<div class="col-8 offset-2 text-center mb-5">
    <p class="h1 mb-3">What mode is your?</p>
    <?= the_content(); ?>
</div>

<?php

foreach ($modes as $key=>$mode){
    set_query_var('mode',$mode);
    set_query_var('key',$key);
    get_template_part('theme-helpers/template-parts/modes','offer');
}


endwhile;
}
get_footer(); ?>