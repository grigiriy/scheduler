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
        <div class="bg-success mb-5 p-3 w-100">
            <h3 class="text-">Your Schedule</h3>
        </div>
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
    foreach($timers as $timer){
        $timer = explode(',',$timer);
    ?>
        <div class="row pt-3 m-1 w-100">
            <div class="col-6">
                <a href="<?= get_the_permalink($timer[1]);?>"><?= get_the_title($timer[1]) ?></a>
            </div>
            <div class="col-3">
                <?php display_day(getdate($timer[0])); ?>
            </div>
            <div class="col-3">
                <?= getdate($timer[0])['hours'].':'.getdate($timer[0])['minutes'] ?>
            </div>
        </div>
        <?php
    }
    ?>
    </main>
</div>

<?php get_footer(); ?>