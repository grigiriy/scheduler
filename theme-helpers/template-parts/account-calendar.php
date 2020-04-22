<div class="card-header bg-light p-3">
    <h3>Schedule for next three days</h3>
</div>

<?php
if(isset($timers) && $timers ){
?>
<div class="card-body p-0">
    <table class=" table m-0">
        <thead class="table-primary">
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
            ?>
            <tr class="bg-<?= ($key%2===0)?'light':'white' ?>">
                <td><a href="<?= get_the_permalink($timer[1]);?>" class="text-info"><?= get_the_title($timer[1]) ?></a>
                </td>
                <td><?= display_day(getdate($timer[0])); ?></td>
                <td><?= getdate($timer[0])['hours'].':'.getdate($timer[0])['minutes'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="card-footer text-center bg-white">
    <a href="/account/calendar/" class="btn btn-info">Go to calendar</a>
</div>
<?php } else { ?>
<div class="m-3">
    <p class="h3">No courses yet</p>
    <?php if ($is_time_to_add ) { ?>
    <p class="h4">Click <a href="/courses/">here</a> to start learning!</p>
    <?php } else { ?>
    <p class="h3">You can add new lesson on
        <?= display_day(getdate($next_lesson_adding_time)); ?>
    </p>
    <?php } ?>
</div>
<?php } ?>