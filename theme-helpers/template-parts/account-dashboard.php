<div class="card-body row">
    <div class="col-6 pt-3">
        <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt="" style="max-width:100%">
        <p class="h3 text-center text-warning"><?= $current_lessons; ?></p>
        <a href="/account/current/" class="btn btn-link d-block">Current Lessons</a>
    </div>
    <div class="col-6 pt-3">
        <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt="" style="max-width:100%; transform:scaleX(-1)">
        <p class="h3 text-center text-warning"><?= $passed_lessons; ?></p>
        <a href="/account/passed/" class="btn btn-link d-block">Already passed</a>
    </div>
</div>