<div class="col-lg-6 col-12 mb-5">
    <div class="row mx-0 mb-5 step_header">
        <h1 class="h1 pr-4">Step&nbsp;1</h1>
        <div class="pl-4">
            <p class="h5">Chose your mode of learning</p>
            <p class="text-muted">
                You can change it any time in <span class="h6">Training Settings</span></p>
        </div>
    </div>
    <div class="row mx-0">
        <p class="text-peach h2">
            What is it?
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida
            dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque
            penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra
            vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget. Lorem ipsum dolor sit amet, consectetur
            adipiscing elit. </p>
    </div>
</div>
<div class="col-lg-6 col-12 mb-5">
    <div id="player" data-id="<?= $yt_code ?>" class="mb-5"></div>
</div>


<?php
$modes_post = get_page_by_path('modes', '', 'page');

$modes = carbon_get_post_meta($modes_post->ID, 'modes');

$active_mode = 'medium';

foreach ($modes as $key=>$mode){
    set_query_var('mode',$mode);
    set_query_var('key',$key);
    ?>
    <div class="col-lg-4 col-12 mb-lg-0 my-lg-3 my-5">
    <?php
    get_template_part('theme-helpers/template-parts/modes','offer');
    ?>
    </div>
    <?php
}

?>