<div id="calend"
    class="card-header <?= $calend_days === '0' ? 'bg-transparent py-4 px-5' : 'bg-light p-4' ?>  border-bottom-0 border-top-0">
    <h4><?= $calend_header; ?></h4>
</div>

<?php if(isset($timers) && $timers ){
    if ($calend_days === '0'){ ?>
        <p class="px-5">
        Calendar shows how many videos you are currently reviewing and when you can add new
        lessons.
        If you want to have a lighter schedule you can skip adding new videos.
        </p>
    <?php } ?>
<div class="card-body <?= $calend_days === '0' ? 'pt-3 px-5 pb-4' : 'p-0 px-4 pb-2' ?> border-bottom-0 border-top-0">
    <table class="trans_borders table mx-n2">
        <thead>
            <tr>
                <th scope="col">Lesson</th>
                <th scope="col">Day</th>
                <th scope="col">Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($timers as $key=>$timer) {
                $timer = explode(',',$timer);
                    if( $calend_days === '0' || ($now_incTZ + (24*60*60*$calend_days) >= $timer[0]) ){
                ?>
            <tr>
                <td>
                    <div class="d-flex">
                        <svg viewBox="0 0 40 40" class="ml-0 mr-2 circular-chart green">
                            <path class="circle-bg" d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="circle" stroke-dasharray="<?= progress_icon($timer[2],$active_mode); ?>, 100"
                                d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <a href="<?= get_the_permalink($timer[1]);?>"><?= get_the_title($timer[1]) ?></a>
                    </div>
                </td>
                <td class="text-capitalize"><?= display_day($timer[0]); ?></td>
                <td><?= getdate($timer[0])['hours'].':'.mins_trim(getdate($timer[0])['minutes']) ?></td>
            </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<?php if($calend_days !== '0'){ ?>

<div class="card-footer text-left bg-white pb-4 px-4 border-top-0">
    <a href="/calendar/" class="btn btn-outline-primary btn-round py-2 px-4">Go to calendar</a>
</div>
<?php } 

} else { ?>
<div class="my-3 <?= $calend_days === '0' ? 'mx-5' : 'mx-2' ?> px-3">
    <p class="h4">No courses yet</p>
    <?php if($calend_days === '0'){ ?>
        <p class="px-1">
        You have no plans for English now. Let’s learn English fun.
        Pick the most engaging video from the <a href="/catalog/">Catalog</a> and press “Choose this lesson” button to start
        learning English with native speakers now!
        </p>
    <?php }
    if (!$is_time_to_add ) { ?>
    <p class="h3">You can add new lesson on
        <?= display_day($next_lesson_adding_time); ?>
    </p>
    <?php } ?>
</div>
<?php } ?>