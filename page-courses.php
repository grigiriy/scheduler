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
if (get_the_title() === 'Current lessons') {
    $this_page = 'current';
} else if (get_the_title() === 'Already passed') {
    $this_page = 'passed';
} else if (get_the_title() === 'Favorite') {
    $this_page = 'favorite';
} else {
    // $this_page = null;
    $this_page = 'courses';

}

while ( have_posts() ) :
    the_post();
    
    $args = array(
        'orderby' => 'post_date',
        'post_type' => 'lessons'

    );
    if($this_page){

        $user_id = get_current_user_id();
        set_query_var('user_id',$user_id);

        $selected_posts = explode(',',carbon_get_user_meta( $user_id, 'favor_lessons' ));
        set_query_var('selected_posts',$selected_posts);
    

        if($this_page==='passed'){

            $args['author']=$user_id;
            $args['course_status'] = 'finished';

        } else if ($this_page==='current') {
            
            $args['author']=$user_id;
            $args['course_status'] = 'started';
            
        } else if ($this_page==='courses') {
            
            $sub_args = $args;
            $args['post_parent']=0;
            $sub_args['author']=$user_id;
            
            $par_list=[];
            $cur_list = get_posts($sub_args);

            foreach ($cur_list as $post){
                array_push($par_list, wp_get_post_parent_id( $post ));
            }
            wp_reset_postdata();

            $args['post__not_in']=$par_list;
            
        } else if ($this_page==='favorite') {
            $args['post__in']=$selected_posts;
        }
    }
    $lessons_query = get_posts($args);
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
            <div class="col-10">

                <?php if(count($lessons_query) ){ ?>
                <div class="card-columns count_2">
                    <?php
                    foreach ($lessons_query as $post) {
                        get_template_part('theme-helpers/template-parts/courses','card');
                    } ?>
                </div>
                <?php
                    } else { ?>
                <div class="text-center mb-5">
                    <p class="h3 mb-0">No courses yet</p>
                    <img class="w-50" src="/wp-content/themes/scheduler_mvp/img/all_done.png" alt="">
                    <p class="h4 mt-3">Click <a href="/courses/">here</a> to start learning!</p>
                </div>
                <?php } ?>
            </div>
            <div class="col-2 bg-dark">
                FILTER
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

    console.log(previews);

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