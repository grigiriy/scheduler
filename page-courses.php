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
        <div class="row">
            <div class="col-12 col-lg-10 col-md-9 order-md-1 order-2 px-0 pr-md-5 pl-md-3">

                <div class="card-columns count_2 gap_3" id="courses_wrapper">
                    <?php
                    $args = set_course_loop($post->ID);
                    render_courses( $args );
                    ?>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-2 order-md-2 order-1 px-0">
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
    if(item.getAttribute('href').indexOf('courses') != -1 ){
        item.setAttribute('aria-current','page');
    }
}) 

    </script>
    <?php
get_footer(); ?>