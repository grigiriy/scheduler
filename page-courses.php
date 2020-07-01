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
    $user_id = get_current_user_id();

    while ( have_posts() ) :
        the_post();
        $is_paid = is_paid($user_id);
        set_query_var( 'is_paid', $is_paid );
        set_query_var( 'post_id', $post->ID );
?>
</div>
<div class="container-fluid border-bottom border-success">
    <div class="row">
        <?php get_template_part('theme-helpers/template-parts/courses','nav'); ?>
    </div>
</div>
<div class="container-fluid bg-white shadow-lg main">
    <div class="container pt-5">
        <div class="row ml-0">
            <div class="col-12 col-md-3 col-lg-2 px-0">
                <?php
                get_template_part( 'theme-helpers/template-parts/courses','filter' ); ?>
            </div>
            <div class="col-12 col-lg-10 col-md-9 px-0 pr-md-3 pl-md-5">
                <?php
                $args = set_course_loop($post->ID);
                $lessons_query = get_posts($args);
                if(count($lessons_query) ){?>
                <div class="mb-5">
                    <p class="h4 mb-4">Welcome to the Learning library</p>
                    <?= the_content(); ?>
                </div>
                <?php } ?>
                <div class="card-columns count_2 gap_3" id="courses_wrapper">
                    <?php render_courses( $args ); ?>
                </div>
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

    const rerenderImages = () => {
        let previews = main.querySelectorAll('.card');

        previews.forEach((e) => {
            if (e.querySelector('img').naturalHeight < 720) {
                let oldSrc = e.querySelector('img').getAttribute('src');
                let newSrc = oldSrc.replace('maxresdefault', 0);
                e.querySelector('img').setAttribute('src', newSrc);
            }
        });
    }
    rerenderImages();


let navList = document.querySelector('nav').querySelectorAll('a');

navList.forEach(function(item){
    if(item.getAttribute('href').indexOf('catalog') != -1 ){
        item.setAttribute('aria-current','page');
    }
}) 

    </script>
    <?php
get_footer(); ?>