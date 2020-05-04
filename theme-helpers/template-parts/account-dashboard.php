<div class="row bg-white mx-0 mb-3">
    <div class="col-6 pt-3 border-right mt-3">
        <img src="/wp-content/themes/scheduler_mvp/img/passed_icon.png" alt="" class="px-5 mw-100">
        <p class="h3 text-center text-warning"><?= $passed_lessons; ?></p>
    </div>
    <div class="col-6 pt-3 mt-3">
        <img src="/wp-content/themes/scheduler_mvp/img/current_icon.png" alt="" class="px-5 mw-100">
        <p class="h3 text-center text-warning"><?= $current_lessons; ?></p>
    </div>
    <div class="col-6">
        <a href="/account/passed/" class="btn btn-link d-block">Already passed</a>
    </div>
    <div class="col-6">
        <a href="/account/current/" class="btn btn-link d-block">Current Lessons</a>
    </div>
</div>