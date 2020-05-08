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
    
?>
</div>
<div class="container-fluid border-bottom border-success">
    <div class="row">
        <?php get_template_part('theme-helpers/template-parts/courses','nav'); ?>
    </div>
</div>
<div class="container-fluid bg-white shadow-lg main">
    <div class="container pt-5">
        <div class="row">
            <div class="col-9">

                <div class="card-columns count_2" id="courses_wrapper">
                    <?php
                    $args = set_course_loop($post->ID);
                    render_courses( $args );
                    ?>
                </div>
            </div>
            <div class="col-3">
                <?php
                get_template_part( 'theme-helpers/template-parts/courses','filter' ); ?>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <?php 
    endwhile; 
    }
?>
    <script>
    const main = document.querySelector('.main');
    const previews = main.querySelectorAll('.card');

    previews.forEach((e) => {
        if (e.querySelector('img').naturalHeight < 720) {
            let oldSrc = e.querySelector('img').getAttribute('src');
            let newSrc = oldSrc.replace('maxresdefault', 0);
            e.querySelector('img').setAttribute('src', newSrc);
        }
    });
    </script>
    <?php
get_footer(); ?>