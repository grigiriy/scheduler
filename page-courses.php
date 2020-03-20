<?php
/**
 * Template Name: CourseList Page
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
    $args = array(
        'orderby'       =>  'post_date',
        'order'         =>  'DESC'
        );
    $lessons_query = new WP_Query($args);
    ?>
<div class="container">
    <main class="row">
        <h1>Cources</h1>
        <?php
    while($lessons_query->have_posts()) : $lessons_query->the_post();
    ?>

        <div class="card my-3">
            <div class="card-body">
                <figure class="figure row">
                    <?php
                    $yt_code = get_post_custom($post->ID)['yt_code'][0];
                    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
                    $yt_code = $matches[0];
                    ?>
                    <img class="figure-img col-6" style="max-width:100%"
                        src="https://i.ytimg.com/vi/<?=$yt_code; ?>/maxresdefault.jpg">
                    <figcaption class="figure-caption col-6">
                        <p class="h4"><?= get_the_title($post->ID); ?></p>
                        <a href="<?= get_the_permalink($post->ID); ?>" class="btn btn-primary">Start</a>
                    </figcaption>
                </figure>
            </div>
        </div>


        <?php endwhile;
?>
    </main>
</div>
<?php 
endwhile; 
}
get_footer(); ?>