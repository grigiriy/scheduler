<?php
/**
 * Template Name: Calendar Page
 */
get_header();

if( !is_user_logged_in() ) {
?>
<script>
document.location.href = '/';
</script>

<?php
} else {
    $user_id = get_current_user_id();
    $list = carbon_get_user_meta( $user_id, 'schedule' );
    $timers=[];
    $selected_posts = [];
    ?>
<div class="container">
    <main class="row">
        <h3>Your Schedule</h3>
        <?php
        foreach ( $list as $key=>$el ) {
            array_push($timers,implode(',',[$el['first_reminder'],$el['lesson_id']]));
            array_push($timers,implode(',',[$el['second_reminder'],$el['lesson_id']]));
            if($el['third_reminder']) {
                array_push($timers,implode(',',[$el['third_reminder'],$el['lesson_id']]));
            }
        ?>
        <?php }
        sort($timers);
    }
    ?>
        <table class="table">
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
                    <td><a href="<?= get_the_permalink($timer[1]);?>"
                            class="text-info"><?= get_the_title($timer[1]) ?></a></td>
                    <td><?php display_day(getdate($timer[0])); ?></td>
                    <td><?= getdate($timer[0])['hours'].':'.getdate($timer[0])['minutes'] ?></td>
                </tr>
                <?php
    }
    ?>
            </tbody>
        </table>
    </main>
</div>

<?php get_footer(); ?>