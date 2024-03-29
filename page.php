<?php
/**
 * Template Name: Page
 */
get_header();
while ( have_posts() ) :
    the_post();
?>

<div class="container">
    <div class="row">
        <div class="card w-100 mt-5">
            <div class="card-header">
                <h1><?= the_title(); ?></h1>
            </div>
            <div class="card-body">
                <p><?php the_content(); ?></p>
            </div>
        </div>
    </div>
</div>



<?php endwhile; ?>
<?php get_footer(); ?>