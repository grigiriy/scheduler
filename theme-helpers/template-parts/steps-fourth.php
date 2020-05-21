<div class="col-7 mb-5">
    <h1>Intro-how to learn</h1>
</div>
<div class="col-5 mb-5">
    <span class="h5 align-middle mr-3">If everithing's clear, just </span>
    <a class="btn btn-primary btn-round py-3 px-4 ml-auto align-self-center text-white" href="/courses/">Choose video
        <span class="arrow_symbol ml-3">⟶</span></a>
</div>
<div class="col-12 mx-0">
    <div id="player" data-id="<?= $yt_code ?>" class="mb-5"></div>
</div>
<script>
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";

var player_place = document.getElementById('player');
player_place.parentNode.insertBefore(tag, player_place);
var player;
var yt_code = document.querySelector('#player').getAttribute('data-id');

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
    if (event.data == YT.PlayerState.PLAYING) {
        lesson_passed();
    }
    console.log('cc -> ', player.getOptions('cc'));
}

function stopVideo() {
    player.stopVideo();
}
</script>