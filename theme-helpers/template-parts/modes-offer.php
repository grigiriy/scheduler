<?php

$selection = [];
if (isset($active_mode)){
    $selection = [$active_mode, true];
} else {
    $selection = ['Medium', false];
}

$classNames='mode_card';
if($mode['name'] === $selection[0]){
    $classNames .= ' selected border-'.$mode['color'];
    $classNames .= $selection[1] ? '' : ' recommended';
}

?>
<div class="card top_rounded bottom_rounded p-4 p-lg-2 p-xl-4 shadow-lg <?= $classNames; ?>">
    <div class="row">
        <div class="col-4 pl-0 offset-8 priceImg">
            <img src="/wp-content/themes/scheduler_mvp/img/mode_<?= $key; ?>.png?>"
                class="mw-100 rounded-image border-<?= $mode['color'] ?>" alt="">
        </div>
    </div>
    <div class="row">
        <div class="col-8 offset-2 px-2">
            <p class="mb-2 mx-auto h3 text-<?= $mode['color'] ?>"><?= $mode['name']; ?>&nbsp;mode</p>
            <p class="text-muted">Shedule for this mode:</p>
        </div>
    </div>
    <?php
    set_query_var('is_modes',$is_modes = true);
    get_template_part('theme-helpers/template-parts/settings','days'); ?>

    <div class="row">
        <div class="col-12 text-center">
            <button onclick="set_mode(this,$user_id)" data-mode="<?= $mode['name']?>"
                class="btn btn-primary btn-round py-2 px-4">
                Choose mode!
            </button>
        </div>
    </div>

</div>