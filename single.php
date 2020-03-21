<?php
/**
 * Template Name: Single
 */
get_header();
while ( have_posts() ) :
    the_post();
    ?>
<div class="container">
    <?php
    $yt_code = get_post_custom()['yt_code'][0];
    $pdf = get_post_custom()['PDF'][0];
    $pdf = get_post_custom($pdf)['_wp_attached_file'][0];
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
    $yt_code = $matches[0];
    ?>

    <h1 data-id="<?= $yt_code ?>"><?= get_the_title(); ?></h1>

    <div id="player" class="mb-5"></div>
    <div class="pdf">
        <embed src="http://localhost:8888/wp-content/uploads/<?= $pdf; ?>" width="100%" height="470px" />
        <div class="d-flex justify-content-between">
            <a target="_blank" href="http://localhost:8888/wp-content/uploads/<?= $pdf; ?>">Открыть в новом
                окне</a>
            <a download="<?= get_the_title(); ?> PDF" target="_blank"
                href="http://localhost:8888/wp-content/uploads/<?= $pdf; ?>">Скачать</a>
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
    <?php } ?>
    <div class="jumbotron mt-5" id="lesson_changed">
        <h3>Давайте выберем частотность</h3>
        <?php $VARIANTS = [['light','На лайте'],['norm','Норм'],['zombo','Зомборежим']];
            foreach($VARIANTS as $VARIANT){ ?>
        <p data-variant="<?=$VARIANT[0]?>"><?=$VARIANT[1]?></p>
        <?php } ?>
        <button class="btn btn-secondary mt-3" type="submit" disabled>
            <h4>Обновить таймеры</h4>
        </button>
    </div>
    <?php
    $user_id = get_current_user_id();
    $list = carbon_get_user_meta( $user_id, 'schedule' );
    foreach ( $list as $key=>$el ) {
    if(intval($el['lesson_id']) === $post->ID){

      switch ($el['cource_frequency']) {
        case 'light':
          $last_lesson = $el['second_reminder'];
          break;
        case 'norm':
          $last_lesson = $el['third_reminder'];
          break;
        case 'zombo':
          $last_lesson = $el['third_reminder'];
          break;
      }

      if($last_lesson <= strtotime("now") ) {
    ?>
    <div class="jumbotron">
        <h3>Поздравляю, вы заканчиваете курс</h3>
        <h5>Это последнее повторение, но если вы захотите, вы сможете найти его <a href="javascript:void(0)"
                onclick="alert('пока не найти')">тут</a></h5>
        <button id="lesson_passed" class="btn btn-success">
            <h4>Завершить курс</h4>
        </button>
    </div>
    <?php }
        }
    } ?>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>