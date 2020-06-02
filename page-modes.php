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
    $active_mode = carbon_get_user_meta($user_id, 'mode');
    while ( have_posts() ) :
        the_post();
?>
<div class="col-8 offset-2 text-center mb-5">
    <p class="h1 mb-3">What mode is your?</p>
    <?= the_content(); ?>
</div>

<?php

foreach ($modes as $key=>$mode){
    set_query_var('active_mode',$active_mode);
    set_query_var('mode',$mode);
    set_query_var('key',$key);
    ?>
    <div class="col-lg-4 col-12 mb-lg-0 mb-5">
    <?php
    get_template_part('theme-helpers/template-parts/modes','offer');
    ?>
    </div>
    <?php
}


endwhile;
?>
<script>
let navList = document.querySelector('nav').querySelectorAll('a');

navList.forEach(function(item){
    if(item.getAttribute('href').indexOf('settings') != -1 ){
        item.setAttribute('aria-current','page');
    }
}) 
</script>
<?php
}
get_footer(); ?>