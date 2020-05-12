<?php
switch ($key) {
    case 0:
        $color = 'mainSche';
        break;
    case 1:
        $color = 'peach';
        break;
    case 2:
        $color = 'danger';
        break;
}

?>

<div class="col-4">
    <div class="card top_rounded bottom_rounded p-4 shadow-lg">
        <div class="row">

            <div class="col-4 pl-0 offset-8 priceImg">
                <img src="/wp-content/themes/scheduler_mvp/img/mode_<?= $key; ?>.png?>"
                    class="mw-100 rounded-image border-<?= $color?>" alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-8 offset-2 px-2">
                <p class="mb-2 mx-auto h3 text-<?= $color?>"><?= $mode['name']; ?>&nbsp;mode</p>
                <p class="text-muted">Shedule for this mode:</p>
            </div>
        </div>
        <?php
        set_query_var('is_modes',$is_modes = true);
        get_template_part('theme-helpers/template-parts/settings','days'); ?>

        <div class="row">
            <div class="col-12 text-center">
                <a href="javascript:void(0)" class="btn btn-primary btn-round py-2 px-4">
                    Choose mode!
                </a>
            </div>
        </div>

    </div>
</div>