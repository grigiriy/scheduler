<div id="calend"
    class="card-header bg-light p-3 border-bottom-0 border-top-0">
    <h4>Calendar</h4>
</div>

<?php if(isset($timers) && $timers ){ ?>

<div class="card-body p-0 px-1 pb-2 border-bottom-0 border-top-0">
    <table class="trans_borders table m-0">
        <thead>
            <tr>
                <th scope="col">User ID</th>
                <th scope="col">Lesson</th>
                <th><span scope="col" data-toggle="tooltip" data-placement="top" title="Today also means - any day before today">Day</span></th>
                <th scope="col">Time</th>
                <th scope="col">Timecode</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($timers as $key=>$timer){
                $timer = explode(',',$timer);
                ?>
            <tr>
                <td>
                    <p class="h5"><?= ( get_post($timer[1]) )->post_author ?></p>
                </td>
                <td>
                    <a href="<?= get_the_permalink($timer[1]);?>"><?= get_the_title($timer[1]) ?></a>
                </td>
                <td><?= display_day($timer[0]); ?></td>
                <td><?= getdate($timer[0])['hours'].':'.mins_trim(getdate($timer[0])['minutes']); ?></td>
                <td class="<?= $timer[0] >= $now_incTZ ? 'bg-warning' : 'bg-danger'; ?> "><?php
                echo $timer[0];
                ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
} else { ?>
<div class="m-3">
    <p class="h4">No courses yet</p>
</div>
<?php } ?>