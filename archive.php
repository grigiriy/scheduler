<?php
/**
 * Template Name: Single
 */
get_header();
while ( have_posts() ) :
    the_post();
?>
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <p class="h5">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </p>
        </div>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>