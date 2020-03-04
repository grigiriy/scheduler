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
    ?>
    <h1><?php the_title(); ?></h1>
    <iframe width="100%" height="505px" src="https://www.youtube.com/embed/<?= $yt_code ?>/" frameborder="0"
        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <?php the_content(); ?>

    <div class="jumbotron">
        <h3>Ручка</h3>
        <button id="submit_lesson" class="btn btn-success">
            <h4>Отправить в очередь</h4>
        </button>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>