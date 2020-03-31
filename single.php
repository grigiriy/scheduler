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
                    <?php $launch_btn = ($is_time_to_add || empty($list)) ? ['data-toggle="modal" data-target="#lesson_changed"','primary'] : ['tabindex="0" data-toggle="popover" data-trigger="focus" title="Wait a bit" data-content="You can add new lesson on '. display_day(getdate($next_lesson_adding_time)).'"','secondary'];
                    ?>
                    <a role="button" type="button" id="popup_start" class="btn text-light btn-<?= $launch_btn[1] ?>"
                        <?= $is_learning ? 'style="display:none"' : ''?> <?= $launch_btn[0] ?>>Start learning</a>

                    <button type="button" class="btn btn-danger" id="leave_course"
                        <?= !$is_learning ? 'style="display:none"' : ''?>>Leave course</button>

                    <button type="button" class="btn btn-warning" id="favorite">⭐️ Favorite</button>
                </span>
            </h1>
        </div>
        <div id="player" class="mb-5 col-12"></div>
        <div class="pdf col-12">
            <embed src="http://localhost:8888/wp-content/uploads/<?= $pdf; ?>" width="100%" height="470px" />
            <div class="d-flex justify-content-between">
                <a target="_blank" href="http://localhost:8888/wp-content/uploads/<?= $pdf; ?>">Open in new window</a>
                <a download="<?= get_the_title(); ?> PDF" target="_blank"
                    href="http://localhost:8888/wp-content/uploads/<?= $pdf; ?>">Download</a>
            </div>
        </div>
        <a href="http://www.google.com/calendar/event?
            action=TEMPLATE
            &text=event-title
            &dates=[start-custom format='Ymd\\THi00\\Z']/[end-custom format='Ymd\\THi00\\Z']
            &details=[description]
            &location=[location]
            &trp=false
            &sprop=
            &sprop=name:" target="_blank" rel="nofollow">Add to my calendar</a>
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
            <button class="btn"><a href="/add_post/?rcl-post-edit=<?= $post->ID; ?>">Edit Post</a></button>
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
                    <h5 class="modal-title"><?= get_the_title(); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    lorem ipsum <?= get_user_meta($user_id)['frequency'][0]; ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="mx-auto btn btn-success" id="add_course">Start learning!</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

</main>

<?php endwhile; };?>

<?php get_footer(); ?>