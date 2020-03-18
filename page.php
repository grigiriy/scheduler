<?php
/**
 * Template Name: Page
 */
get_header();
while ( have_posts() ) :
    the_post();
?>


<p><?php the_content(); ?></p>


<?php endwhile; ?>
<?php get_footer(); ?>