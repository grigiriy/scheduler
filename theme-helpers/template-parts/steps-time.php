<div class="col-lg-6 col-12 mb-5">
    <div class="row mx-0 mb-5 step_header">
        <h1 class="h1 pr-4"></h1>
        <div class="pl-4">
            <p class="h5">When is it comfortable for you to study?</p>
            <p class="text-muted">
                You can change it any time in <span class="h6">Training Settings</span></p>
        </div>
    </div>
    <div class="row mx-0">
        <p>It is important not to miss the repetitions, this is what gives the main impact. The more repetitions you make the better you remember and the faster is the progress. Watch new videos, repeat them 3 times to make English your daily practice.</p>
        <p>Choose a convenient time twice a day for 20-30 minutes to plan your time for studies. We will send you reminders to help you in creating a new habit.</p>
    </div>
</div>
<div class="col-lg-6 col-12 mb-5 card top_rounded bottom_rounded">
    <div class="card-header border-0 pt-5 bg-transparent">
        <p class="h5">What is fitting you?</p>
    </div>
    <div class="card-body d-flex steps_view flex-wrap flex-sm-nowrap pr-0">
        <?php
        set_query_var('is_step',true);
        get_template_part('theme-helpers/template-parts/settings','timeInputs'); ?>
    </div>
    <div class="card-footer border-0 bg-transparent">
        <button type="button" data-toggle="popover" data-placement="left"
            data-content="Please set convenient time" class="d-block btn btn-primary btn-round py-3 px-5 mb-4"
            onclick="go_third(this)">Done!
            <span class="arrow_symbol ml-3">⟶</span></button>
    </div>
</div>