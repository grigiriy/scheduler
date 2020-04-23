<?php
/**
* Template Name: Lesson
 * Template Post Type: lessons
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

    if( $childrens = get_children([
            'post_parent' => $post->ID,
            'author'=>get_current_user_id(),
            'post_type' => 'lessons',
        ])
    ) {
        ?>
<script>
document.location.href = '<?= array_shift($childrens)->guid; ?>';
</script>
<?php
    }
    wp_reset_postdata();

    $yt_code = get_post_custom()['yt_code'][0];
    $pdf = get_post_custom(get_post_custom()['PDF'][0])['_wp_attached_file'][0];
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
    $yt_code = $matches[0];
    
    global $now_incTZ;
    $post_id = $post->ID;
    $user_id = get_current_user_id();


    $next_lesson_adding_time = carbon_get_user_meta( $user_id, 'next_lesson' ) ?
    carbon_get_user_meta( $user_id, 'next_lesson' ) :
    strtotime(get_userdata( $user_id )->user_registered);


    $list = carbon_get_user_meta( $user_id,'schedule' );
    $lib_vals = [];
    $less_vals=[];

    foreach ($list as $key=>$el){
        array_push($lib_vals,intval($el['lesson_id']));
        if(intval($el['lesson_id'])===$post_id){
            $current_lesson_key = $key;
            $current_lesson_val = $el['current_lesson'];
            array_push($less_vals,$el['first_reminder']);
            array_push($less_vals,$el['second_reminder']);
            if($el['third_reminder']){
                array_push($less_vals,$el['third_reminder']);
            }
        }
    }
    $less_vals = ( empty($less_vals) ) ? [] : $less_vals;
    $is_time_to_add = $next_lesson_adding_time <= $now_incTZ;
    $is_learning = in_array($post_id, $lib_vals) ? true : false;

    if(intval($post->post_author) === intval($user_id) ) {
        $is_learning = true;
    }


    $favs = explode(',',carbon_get_user_meta( $user_id, 'favor_lessons' ));
    $is_favor = in_array($post_id, $favs) ? true : false;

    $passed_lessons = explode(',',carbon_get_user_meta( $user_id, 'passed_lessons' ));
    $is_passed = in_array($post_id, $passed_lessons) ? true : false;

    if( $is_learning && !empty($less_vals) ) {
        $is_lastLesson = ($now_incTZ>=$less_vals[count($less_vals)-1] && $current_lesson_val == count($less_vals));
        check_current_lesson($user_id,$post_id,$is_lastLesson,$less_vals,$current_lesson_key);
    }
?>

<div data-can_add="<?= $is_time_to_add === true ? 'true' : '' ;?>"
    data-learning="<?= $is_learning === true ? 'true' : '' ;?>" class="col-12">
    <h1 class="d-flex" data-id="<?= $yt_code ?>">
        <?= get_the_title(); ?>
    </h1>

    <?php
            set_query_var( 'is_favor', $is_favor );
            set_query_var( 'is_time_to_add', $is_time_to_add );
            set_query_var( 'is_passed', $is_passed );

            if (isset($is_learning) ) {
                set_query_var( 'is_learning', $is_learning );
            }
            
            if (isset($current_lesson_val) ) {
                set_query_var( 'current_lesson_val', $current_lesson_val );
            }
            if (isset($less_vals) ) {
                set_query_var( 'less_vals', $less_vals );
            }
            if (isset($next_lesson_adding_time) ) {
                set_query_var( 'next_lesson_adding_time', $next_lesson_adding_time );
            }
            ?>


    <?php get_template_part('theme-helpers/template-parts/lesson','buttons');  ?>


</div>
<div id="player" class="mb-5 col-12"></div>
<?php
        $type = get_the_terms( $post_id, 'course_type' )[0]->slug;
        if( $type === 'with-teacher' ) {
            $detailed_sentences = carbon_get_post_meta($post_id, 'detailed_sentences'); ?>
<div class="col-12">
    <table class="table table-dark">
        <tbody>
            <?php foreach($detailed_sentences as $detailed_sentence){ ?>
            <tr>
                <td onclick="show_hint(this)"><?= $detailed_sentence['sentence'] ?></td>
                <td style="display:none"><?= $detailed_sentence['note_1'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php

        } else if( $type === 'self'  ) {

        ?>
<div class="pdf col-12">
    <embed src="/wp-content/uploads/<?= $pdf; ?>" width="100%" height="470px" />
    <div class="d-flex justify-content-between">
        <a target="_blank" href="/wp-content/uploads/<?= $pdf; ?>">Open in new window</a>
        <a download="<?= get_the_title(); ?> PDF" target="_blank" href="/wp-content/uploads/<?= $pdf; ?>">Download</a>
    </div>
</div>
<!-- <a href="http://www.google.com/calendar/event?
            action=TEMPLATE
            &text=event-title
            &dates=[start-custom format='Ymd\\THi00\\Z']/[end-custom format='Ymd\\THi00\\Z']
            &details=[description]
            &location=[location]
            &trp=false
            &sprop=
            &sprop=name:" target="_blank" rel="nofollow">Add to my calendar</a> -->
<?php } ?>
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

<?php
if(
    get_the_author_meta('ID') === $user_id &&
    $post->post_parent === 0
){
?>
<div class="card mt-5">
    <div class="card-header">
        <h3>Edit lesson info</h3>
    </div>
    <div class="card-body lesson_edit">
        <button class="btn"><a href="/add_post/?rcl-post-edit=<?= $post->ID; ?>">Edit Post</a></button>
    </div>
</div>
<button id="lesson_passed" class="btn btn-success">
    <h4 class='mb-0'>Finish</h4>
</button>
<?php }
        if ($is_learning && !empty($less_vals)) {
            if ($current_lesson_val==='0' || ( intval($current_lesson_val)>0 && $now_incTZ>=$less_vals[intval($current_lesson_val)-1]) ) {
    ?>
<div class="card mt-5">
    <?php if($is_lastLesson){ ?>
    <div class="card-header">
        <h3>Congratulations! This is the last reiteration of this lesson</h3>
    </div>
    <?php } ?>
    <div class="card-body">
        <button id="lesson_passed" class="btn btn-success" data-last=<?= $is_lastLesson ? 'true' : 'false' ?>>
            <h4 class='mb-0'>Finish <?= $is_lastLesson ? 'course!' : 'practice' ?></h4>
        </button>
    </div>
</div>
<?php }
    }
    if($is_time_to_add || $is_learning  || empty($list)) { ?>
<div class=" modal fade" id="add_lesson" tabindex="-1" role="dialog" aria-labelledby="add_lesson__label"
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
                lorem ipsum
                <?= (isset(get_user_meta($user_id)['frequency'])) ? get_user_meta($user_id)['frequency'][0] : 'Norm'; ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mx-auto btn btn-success" id="add_course">Start
                    learning!</button>
            </div>
        </div>
    </div>
</div>
<?php
    } ?>

<?php endwhile; };?>

<?php get_footer(); ?>