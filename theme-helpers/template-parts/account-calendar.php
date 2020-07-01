<div id="calend"
    class="card-header <?= $calend_days === '0' ? 'bg-transparent py-4 px-5' : 'bg-light p-3' ?>  border-bottom-0 border-top-0">
    <h4 class="px-2"><?= $calend_header; ?></h4>
</div>

<?php if(isset($timers) && $timers ){ ?>

<div class="card-body <?= $calend_days === '0' ? 'pt-3 px-5 pb-4' : 'p-0 px-1 pb-2' ?> border-bottom-0 border-top-0">
    <table class="trans_borders table m-0">
        <thead>
            <tr>
                <th scope="col">Lesson</th>
                <th scope="col">Day</th>
                <th scope="col">Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($timers as $key=>$timer){
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
                <td><?= display_day($timer[0]); ?></td>
                <td><?= getdate($timer[0])['hours'].':'.mins_trim(getdate($timer[0])['minutes']) ?></td>
            </tr>
            <?php
                }
            }
        ?>
        </tbody>
    </table>
</div>
<?php if($calend_days !== '0'){ ?>

<div class="card-footer text-left bg-white pb-4 border-top-0">
    <a href="/calendar/" class="btn btn-outline-primary btn-round py-3 px-4">Go to calendar</a>
</div>
<?php } 

} else { ?>
<div class="my-3 mx-5 px-2">
    <p class="h4">No courses yet</p>
    <?php if ($is_time_to_add ) {
        if($is_paid){
        ?>
        <p class="h4">Click <a href="/catalog/">here</a> to start learning!</p>
        <?php
        }
    } else { ?>
    <p class="h3">You can add new lesson on
        <?=
        display_day($next_lesson_adding_time);
        ?>
    </p>
    <?php } ?>
</div>
<?php } ?>