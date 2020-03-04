<?php
/**
 * Template Name: Page
 */
get_header();
while ( have_posts() ) :
    the_post();
?>
<h1><?php the_title(); ?></h1>
<p><?php the_content(); ?></p>
<?php endwhile; ?>
<?php get_footer(); ?>