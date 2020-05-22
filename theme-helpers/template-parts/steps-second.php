<div class="col-6 mb-5">
    <div class="row mx-0 mb-5 step_header">
        <h1 class="h1 pr-4">Step&nbsp;2</h1>
        <div class="pl-4">
            <p class="h5">Set convenient time for learning</p>
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
<div class="col-6 mb-5 card top_rounded bottom_rounded">
    <div class="card-header border-0 pt-5 bg-transparent">
        <p class="h5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.</p>
    </div>
    <div class="card-body d-flex steps_view">
        <?php
        set_query_var('is_step',true);
        get_template_part('theme-helpers/template-parts/settings','timeInputs'); ?>
    </div>
    <div class="card-footer border-0 bg-transparent">
        <button type="button" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="left"
            data-content="Please set convenient time" class="d-block btn btn-primary btn-round py-3 px-5 mb-4"
            onclick="go_third(this)">Done!
            <span class="arrow_symbol ml-3">⟶</span></button>
    </div>
</div>