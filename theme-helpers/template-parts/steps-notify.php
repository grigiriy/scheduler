<div class="col-lg-6 col-12 mb-5">
    <div class="row mx-0 mb-5 step_header">
        <h1 class="h1 pr-4"></h1>
        <div class="pl-4">
            <p class="h5">Set reminders</p>
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
<div class="col-lg-6 col-12 mb-5 card top_rounded bottom_rounded">
    <div class="card-header border-0 pt-5 bg-transparent">
        <p class="h5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.</p>
    </div>
    <div class="card-body d-block steps_view">
        <?php
        set_query_var('is_step',true);
        get_template_part('theme-helpers/template-parts/settings','notifyConfig'); ?>
    </div>
    <div class="card-footer border-0 bg-transparent">
        <button type="button" class="d-block btn btn-primary btn-round py-3 px-5 mb-4" onclick="fourth_step()">Finish!
            <span class="arrow_symbol ml-3">⟶</span></button>
    </div>
</div>