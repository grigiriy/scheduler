<div class="card my-3 w-100">
    <div class="card-body">
        <figure class="figure row">
            <?php
            $yt_code = get_post_custom($post->ID)['yt_code'][0];
            preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
            $yt_code = $matches[0];
            ?>
            <img class="figure-img col-6" style="width:100%"
                src="https://i.ytimg.com/vi/<?=$yt_code; ?>/maxresdefault.jpg">
            <figcaption class="figure-caption col-6">
                <p class="h4"><?= get_the_title($post->ID); ?></p>
                <a href="<?= get_the_permalink($post->ID); ?>" class="btn btn-primary">Start</a>
            </figcaption>
        </figure>
    </div>
</div>