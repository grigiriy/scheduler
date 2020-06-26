<div class="d-flex flex-column border-success">
    <div class="pr-lg-3 pl-lg-0 px-sm-5 px-3 text-center">
        <?php $image = carbon_get_theme_option( 'teacher' ) ? 'free.png' : 'fast.png';  ?>
        <img class="px-5 side_image <?= carbon_get_theme_option( 'teacher' ) ? 'w-100' : 'small_side_image';  ?>" src="/wp-content/themes/scheduler_mvp/img/<?= $image; ?>" alt="">
    </div>
    <div class="card shadow-lg bottom_rounded top_rounded border-top p-3">
        <?php if (carbon_get_theme_option( 'teacher' )) { ?>
        <div class="card-header bg-transparent border-0 pt-4">
            <p class="text-warning h5">Get free lessons by passing repetitions in time!</p>
        </div>
        <?php } ?>
        <div class="card-footer bg-transparent border-0">
            <?php get_template_part('theme-helpers/template-parts/settings','notifyConfig'); ?>
        </div>
    </div>
</div>