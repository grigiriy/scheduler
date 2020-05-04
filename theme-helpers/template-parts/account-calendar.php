<div class="card-header bg-light p-3 border-bottom-0 border-top-0">
    <h4>Schedule for next three days</h4>
</div>

<?php
if(isset($timers) && $timers ){
?>
<div class="card-body p-0 border-bottom-0 border-top-0">
    <table class="trans_borders table m-0">
        <thead>
            <tr>
                <th scope="col">Lesson</th>
                <th scope="col">Status</th>
                <th scope="col">Day</th>
                <th scope="col">Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($timers as $key=>$timer){
                $timer = explode(',',$timer);
            ?>
            <tr>
                <td><a href="<?= get_the_permalink($timer[1]);?>"><?= get_the_title($timer[1]) ?></a>
                </td>
                <td>...</td>
                <td><?= display_day(getdate($timer[0])); ?></td>
                <td><?= getdate($timer[0])['hours'].':'.getdate($timer[0])['minutes'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="card-footer text-left bg-white py-4 border-top-0">
    <a href="/account/calendar/" class="btn btn-outline-primary btn-round">Go to calendar</a>
</div>
<?php } else { ?>
<div class="m-3">
    <p class="h4">No courses yet</p>
    <?php if ($is_time_to_add ) { ?>
    <p class="h4">Click <a href="/courses/">here</a> to start learning!</p>
    <?php } else { ?>
    <p class="h3">You can add new lesson on
        <?= display_day(getdate($next_lesson_adding_time)); ?>
    </p>
    <?php } ?>
</div>
<?php } ?>