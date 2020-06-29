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
                <div class="card-columns count_2 gap_3" id="courses_wrapper">
                    <?php
                    $args = set_course_loop($post->ID);
                    render_courses( $args );
                    ?>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-lg-9 ml-auto my-5">
                <p>All the lessons include 2 videos and the script of the episode. The first video is the original videos 20 minutes long. The second one is a full explanation of the script. </p>
                <p>
                    <ul>
                        <li>Choose Themes you are most interested in</li>
                        <li>Check out the preview</li>
                        <li>Press hearts on the episodes you want to add to the Wishlist</li>
                        <li>Start learning English in a fun way straight ahead!</li>
                    </ul>
                </p>
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