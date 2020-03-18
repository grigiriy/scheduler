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
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
    $yt_code = $matches[0];
    ?>

    <h1 data-id="<?= $yt_code ?>"><?php the_title(); ?></h1>

    <div id="player"></div>

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
            // videoId: 'M7lc1UVf-VE',
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
    // the_content();
    ?>
    <style>
    #lesson_changed p {
        background: yellow;
        border-bottom: solid 1px #ccc;
        transition: all 0.2s;
        color: blue;
        margin: 0;
        padding: 20px 10px;
        cursor: pointer;
    }

    #lesson_changed p:hover {
        background: orange;
    }

    #lesson_changed p:last-child {
        border-bottom: none;
    }

    #lesson_changed p.active {
        color: black;
        font-weight: bold;
    }
    </style>
    <div class="jumbotron" id="lesson_changed">
        <h3>Давайте выберем частотность</h3>
        <?php $VARIANTS = [['light','На лайте'],['norm','Норм'],['zombo','Зомборежим']];
            foreach($VARIANTS as $VARIANT){ ?>
        <p data-variant="<?=$VARIANT[0]?>"><?=$VARIANT[1]?></p>
        <?php } ?>
        <button class="btn btn-secondary mt-3" type="submit" disabled>
            <h4>Обновить таймеры</h4>
        </button>
    </div>
    <!-- <div class="jumbotron">
        <h3>Ручка</h3>
        <button id="lesson_passed" class="btn btn-success">
            <h4>Урок пройден!</h4>
        </button>

    </div> -->
</div>

<?php endwhile; ?>

<?php get_footer(); ?>