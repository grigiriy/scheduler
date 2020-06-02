<?php
/**
 * Template Name: Settings Page
 */
get_header();

if( !is_user_logged_in() ) {
    ?>
<script>
document.location.href = '/';
</script>

<?php
    
    } else {
    $user_id = get_current_user_id();
    set_query_var( 'user_id', $user_id );


    $mode = carbon_get_user_meta($user_id, 'mode');
    $modes = carbon_get_post_meta(238, 'modes');
    foreach ($modes as $key=>$_mode){
        if($_mode['name'] === carbon_get_user_meta($user_id, 'mode')){
            $mode = $_mode;
            $icon = $key;
        }
    }
    set_query_var( 'mode', $mode );
?>

<section class="col-lg-8 col-12 pr-0 pl-0 pl-lg-3 pr-lg-3 pr-xl-5">

    <div class="card shadow-lg bottom_rounded top_rounded p-3">
        <div class="card-header border-bottom-0 bg-transparent d-flex">
            <div class="col-12 col-sm-9 col-xl-10">
                <h2>Your Current mode is <span
                        class="text-<?= $mode['color'] ;?>"><?= $mode['name'] ;?></span></h2>
                <p class="text-muted">Shedule for this mode:</p>
            </div>
            <div class="d-none d-sm-block col-3 col-xl-2 px-0">
                <img class="mw-100 rounded-image border-<?= $mode['color'] ;?>"
                    src="/wp-content/themes/scheduler_mvp/img/mode_<?= $icon; ?>.png" alt="">
            </div>
        </div>
        <?php get_template_part('theme-helpers/template-parts/settings','days'); ?>

        <?php get_template_part('theme-helpers/template-parts/settings','times'); ?>

        <?php get_template_part('theme-helpers/template-parts/settings','change'); ?>
    </div>

</section>

<section class="col-lg-4 col-12 px-0">
    <?php get_template_part('theme-helpers/template-parts/settings','sidebar'); ?>
</section>

<?php
    }
get_footer(); ?>