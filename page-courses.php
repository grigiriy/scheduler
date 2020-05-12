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
    global $now_incTZ;
    $user_id = get_current_user_id();
    $next_lesson_adding_time = carbon_get_user_meta( $user_id, 'next_lesson' ) ?
    carbon_get_user_meta( $user_id, 'next_lesson' ) :
    strtotime(get_userdata( $user_id )->user_registered);
    
    set_query_var( 'now_incTZ', $now_incTZ );
    set_query_var( 'is_time_to_add', is_time_to_add($next_lesson_adding_time) );
    set_query_var( 'next_lesson_adding_time', $next_lesson_adding_time );

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
            <div class="col-10 pr-5">

                <div class="card-columns count_2 gap_3" id="courses_wrapper">
                    <?php
                    $args = set_course_loop($post->ID);
                    render_courses( $args );
                    ?>
                </div>
            </div>
            <div class="col-2 px-0">
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
    </script>
    <?php
get_footer(); ?>