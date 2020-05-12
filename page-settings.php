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
?>

<section class="col-md-8 col-sm-12 pr-5">

    <div class="card shadow-lg bottom_rounded top_rounded p-3">
        <div class="card-header border-bottom-0 bg-transparent d-flex">
            <div class="col-9 col-xl-10">
                <h2>Your Current mode is <span class="text-mainSche">Light</span></h2>
                <p class="text-muted">Shedule for this mode:</p>
            </div>
            <div class="col-3 col-xl-2 px-0">
                <img class="mw-100 rounded-image border-mainSche"
                    src="/wp-content/themes/scheduler_mvp/img/current_icon.png" alt="">
            </div>
        </div>
        <?php get_template_part('theme-helpers/template-parts/settings','days'); ?>

        <?php get_template_part('theme-helpers/template-parts/settings','times'); ?>

        <?php get_template_part('theme-helpers/template-parts/settings','change'); ?>
    </div>

</section>

<section class="col-md-4 col-sm-12 px-0">
    <?php get_template_part('theme-helpers/template-parts/settings','sidebar'); ?>
</section>

<?php
    }
get_footer(); ?>