<div class="d-flex mb-3">

    <?php if($is_passed){ ?>
    <span class="mr-auto h3">You've already done with this lesson, but you can always repeat it!</span>
    <?php } ?>

    <span class="ml-auto">
        <?php $launch_btn = $is_time_to_add ?
        ['data-toggle="modal" data-target="#add_lesson"','primary'] :
        ['tabindex="0" data-toggle="popover" data-trigger="focus" title="Wait a bit" data-content="You can add new lesson on '. display_day(getdate($next_lesson_adding_time)).'"','secondary'];
        ?>

        <a role="button" type="button" id="popup_start" class="btn text-light btn-<?= $launch_btn[1] ?>"
            <?= $is_learning ? 'style="display:none"' : ''?> <?= $launch_btn[0] ?>>Start learning</a>

        <button type="button" class="btn btn-danger" id="leave_course"
            <?= !$is_learning ? 'style="display:none"' : ''?>>Leave course</button>

        <button type="button" class="btn btn-warning"
            id="favorite"><?= ($is_favor) ? '⭐️ Favorite' : 'Add to favorite'; ?></button>
    </span>
</div>