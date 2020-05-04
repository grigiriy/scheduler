<div class="border-top border-success mb-5 ">
    <div class="card mb-3 w-100 shadow-lg bottom_rounded" id="next_lesson_card">

        <?php if(isset($timers) && $timers ) { ?>

        <div class="card-body">
            <p class="card-title h2 d-flex mb-0">
                <span>Repeat this material</span>
                <span class="badge badge-warning ml-auto"><?= display_day(getdate($next));?></span>
            </p>

            <figure class="figure row">
                <?php
                $yt_code = get_post_custom($current_lesson)['yt_code'][0];
                preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
                $yt_code = $matches[0];
            ?>
                <img class="figure-img col-6" style="max-width:100%"
                    src="https://i.ytimg.com/vi/<?=$yt_code; ?>/maxresdefault.jpg">
                <figcaption class="figure-caption col-6">
                    <p class="h4"><?= get_the_title($current_lesson); ?></p>
                    <a href="<?= get_the_permalink($current_lesson); ?>" class="btn btn-primary">Start</a>
                </figcaption>
            </figure>
        </div>

        <?php } else if (!$is_time_to_add) { ?>

        <div class="card-body">
            <p class="h2">It seems you have no tasks for today</p>
            <img src="/wp-content/themes/scheduler_mvp/img/new_day.png" alt="" style="max-width:100%">
        </div>

        <?php }


    if ($next_lesson_adding_time){ ?>
        <div class="card-footer">
            <p class="h3">You can add new lesson on <?= display_day(getdate($next_lesson_adding_time)); ?>
            </p>
        </div>
        <?php } ?>


    </div>
</div>