<?php
/**
 * Template Name: Personal Page
 */
get_header(); ?>
<div class="container">
    <div class="row">
        <div class="card w-100 mt-5">
            <div class="card-header">
                <h1>Edit your personal information</h1>
            </div>
            <div class="card-body">
                <?= do_shortcode('[wp-recall]'); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>