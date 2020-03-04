<?php
/**
 * Template Name: Single
 */
get_header();
?>
<div class="container-fluid">
    <?php
    while ( have_posts() ) :
        the_post();
    ?>
    <div class="card mb-3">
        <div class="card-body">
            <p class="h5">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </p>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>