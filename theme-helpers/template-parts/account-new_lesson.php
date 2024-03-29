<div class="border-top border-success mb-5 ">
    <div class="card mb-3 w-100 shadow-lg bottom_rounded flag_card" id="next_lesson_card">

        <?php if(isset($timers) && $timers && (display_day($next) === 'Today')) {
            $yt_code = carbon_get_post_meta($current_lesson,'yt_code');
            preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
            $yt_code = $matches[0];
        ?>

        <div class="card-body">
            <div class="card-title mb-0 ml-3 pl-5">
                <p class="h3">Repeat this lesson</p>
                <div class="d-flex mb-3">
                    <p class="text-primary h5">
                        <?= getdate($next)['hours'] .':'.mins_trim(getdate($next)['minutes']) ?>
                    </p>
                    <div class="single-chart ml-3">
                        <svg viewBox="0 0 40 40" class="circular-chart green">
                            <path class="circle-bg" d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="circle"
                                stroke-dasharray="<?= progress_icon($current_lesson_number,$active_mode); ?>, 100" d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="lesson_thumbnail row mb-5">
                <div class="col-6">
                    <img class="w-100" src="https://i.ytimg.com/vi/<?=$yt_code; ?>/maxresdefault.jpg">
                </div>
                <div class="col-6">
                    <p class="h4 mb-5"><?= get_the_title($current_lesson); ?></p>
                    <a href="<?= get_the_permalink($current_lesson); ?>"
                        class="btn btn-primary btn-round py-3 px-4">Start learning</a>
                </div>
            </div>
        </div>

        <?php } else { ?>

        <div class="card-body d-flex flex-column">
            <p class="h3 ml-3 pl-5">It seems you have no more scheduled lessons for today</p>
            <img class="w-50 mx-auto" src="/wp-content/themes/scheduler_mvp/img/all_done.png" alt="">
        </div>

        <?php } ?>

    </div>
</div>