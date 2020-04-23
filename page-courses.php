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
            $selected_posts = explode(',',carbon_get_user_meta( $user_id, 'favor_lessons' ));
            $args['post__in']=$selected_posts;
        }
    }
    $lessons_query = get_posts($args);
    ?>
<div class="row">
    <h1 class="mr-auto"><?= get_the_title();?></h1>
    <?php 
    set_query_var( 'this_page', $this_page );
    get_template_part('theme-helpers/template-parts/courses','nav');
    ?>
    <?php
        if(count($lessons_query) ){
            foreach ($lessons_query as $post) {
                get_template_part('theme-helpers/template-parts/courses','card');
            }
        } else { ?>
    <div class="card my-3 mx-auto text-center">
        <div class="card-header bg-info text-light">
            <p class="h3 mb-0">No courses yet</p>
        </div>
        <div class="card-body bg-warning px-5">
            <img src="/wp-content/themes/scheduler_mvp/img/default.png" alt="" style="max-width:100%">
            <p class="h4 mt-3">Click <a href="/courses/">here</a> to start learning!</p>
        </div>
    </div>
    <?php } ?>
</div>
<?php 
    endwhile; 
}
?>
<script>
const main = document.querySelector('main');
const previews = main.querySelectorAll('.card');
const nav = main.querySelector('.btn-group');
const navLinks = nav.querySelectorAll('a');
const thisPage = nav.getAttribute('data-page');
// const url = (thisPage === 'courses') ? '/courses/' : (thisPage === 'passed') ? '/passed/' : '/current/';

previews.forEach((e) => {
    if (e.querySelector('img').naturalHeight < 720) {
        let oldSrc = e.querySelector('img').getAttribute('src');
        let newSrc = oldSrc.replace('maxresdefault', 0);
        e.querySelector('img').setAttribute('src', newSrc);
    }
});

navLinks.forEach((e) => {
    if ((e.href.split('/'))[e.href.split('/').length - 2] === thisPage) {
        e.setAttribute('href', 'javascript:void(0)');
        e.classList.add('text-primary', 'bg-white');
    }
});
</script>
<?php
get_footer(); ?>