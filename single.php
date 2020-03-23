<?php
/**
 * Template Name: Single
 */
get_header();

if( !is_user_logged_in() ) {
    ?>
<script>
document.location.href = '/';
</script>

<?php
    } else {

while ( have_posts() ) :
    the_post();

    $yt_code = get_post_custom()['yt_code'][0];
    $pdf = get_post_custom(get_post_custom()['PDF'][0])['_wp_attached_file'][0];
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
    $yt_code = $matches[0];
    
    $post_id = $post->ID;
    $user_id = get_current_user_id();
    $next_lesson_adding_time = carbon_get_user_meta( $user_id, 'next_lesson' );
    $list = carbon_get_user_meta( $user_id,'schedule' );
    $vals = [];
    
    global $now_incTZ;

    foreach ($list as $key=>$el){
        array_push($vals,intval($el['lesson_id']));
        if(intval($el['lesson_id'])===$post_id){
            if($el['third_reminder']){
                $last_lesson = $el['third_reminder'];
            } else {
                $last_lesson = $el['second_reminder'];
            }
        }
    }
    $is_time_to_add = $next_lesson_adding_time <= $now_incTZ;
    $is_learning = (in_array($post_id, $vals)) ? true : false;
?>
<main class="container" data-learning="<?= $is_learning === true ? 'true' : '' ;?>">
    <div class="row">
        <div class="col-12">
            <h1 class="d-flex" data-id="<?= $yt_code ?>">
                <?= get_the_title(); ?>
                <span class="ml-auto">
                    <?php if($is_time_to_add || $is_learning || empty($list)) { ?>
                    <button type="button" id="popup_frequency" class="btn btn-primary" data-toggle="modal"
                        data-target="#lesson_changed">Change frequency</button>
                    <?php }
                    if ($is_learning){?>
                    <button type="button" class="btn btn-danger" id="leave_course">Leave
                        course</button>
                    <?php } ?>
                </span>
            </h1>
        </div>
        <div id="player" class="mb-5 col-12"></div>
        <div class="pdf  col-12">
            <embed src="http://localhost:8888/wp-content/uploads/<?= $pdf; ?>" width="100%" height="470px" />
            <div class="d-flex justify-content-between">
                <a target="_blank" href="http://localhost:8888/wp-content/uploads/<?= $pdf; ?>">Open in new window</a>
                <a download="<?= get_the_title(); ?> PDF" target="_blank"
                    href="http://localhost:8888/wp-content/uploads/<?= $pdf; ?>">Download</a>
            </div>
        </div>
    </div>
    <script>
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";

    var player_place = document.getElementById('player');
    player_place.parentNode.insertBefore(tag, player_place);
    var player;
    var yt_code = document.querySelector('h1').getAttribute('data-id');

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            height: '500px',
            width: '100%',
            videoId: yt_code,
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
        console.log('cc -> ', player.getOptions('cc'));
    }

    function onApiChange(event) {
        console.log('something changed...');
    }

    function onPlayerReady(event) {
        // event.target.playVideo();
    }

    function onPlayerStateChange(event) {
        console.log('cc -> ', player.getOptions('cc'));
    }

    function stopVideo() {
        player.stopVideo();
    }
    </script>

    <?php if(get_the_author_meta('ID') === get_current_user_id()){?>
    <div class="card mt-5">
        <div class="card-header">
            <h3>Edit lesson info</h3>
        </div>
        <div class="card-body lesson_edit">
            <?= do_shortcode('[public-form]');
            // the_content();
            ?>
        </div>
    </div>
    <?php }     
      if(isset($last_lesson) && $last_lesson <= $now_incTZ ) {
    ?>
    <div class="card mt-5">
        <div class="card-header">
            <h3>Congratulations!</h3>
        </div>
        <div class="card-body">
            <h5>It's the last repeat. You can always find this lesson <a href="/account/passed/">here</a></h5>
            <button id="lesson_passed" class="btn btn-success">
                <h4 class='mb-0'>Finish</h4>
            </button>
        </div>
    </div>
    <?php } ?>



    <?php if($is_time_to_add || $is_learning  || empty($list)) { ?>
    <div class="modal fade" id="lesson_changed" tabindex="-1" role="dialog" aria-labelledby="lesson_changed__label"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson_changed__label">
                        <?= $is_learning === true ? 'Select ' : 'Change '?>frequency</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $VARIANTS = [
                    ['light','Light (2 times: tomorrow and in 4 days)'],
                    ['norm','Normal (3 times: tomorrow, in 3 nd in 5 days)'],
                    ['zombo','"Zombo" mode (3 times: today, tomorrow, and in a week)']
                ];
                foreach($VARIANTS as $VARIANT){ ?>
                    <p class="p-3 m-0" data-variant="<?=$VARIANT[0]?>"><?=$VARIANT[1]?></p>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-secondary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

</main>

<?php endwhile; };?>

<?php get_footer(); ?>