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
} else {
    $this_page = null;
    // $this_page = 'courses';

}

while ( have_posts() ) :
    the_post();
    
    $args = array(
        'orderby' => 'post_date',
    );
    if($this_page){
        $user_id = get_current_user_id();
        if($this_page==='passed'){
            $selected_posts = explode(',',carbon_get_user_meta( $user_id, 'passed_lessons' ));
        } else if ($this_page==='current') {
            $list = carbon_get_user_meta( $user_id, 'schedule' );
            $selected_posts=[];
            foreach ( $list as $key=>$el ) {
                array_push($selected_posts,$el['lesson_id']);
            }
        } else if ($this_page==='courses') {

        }
        $args['post__in']=$selected_posts;
    }
    
    $lessons_query = new WP_Query($args);
    ?>
<div class="container">
    <main class="row">
        <h1 class="w-100"><?= get_the_title();?></h1>
        <?php
        while($lessons_query->have_posts()) : $lessons_query->the_post();
        ?>
        <div class="card my-3 w-100">
            <div class="card-body">
                <figure class="figure row">
                    <?php
                    $yt_code = get_post_custom($post->ID)['yt_code'][0];
                    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
                    $yt_code = $matches[0];
                    ?>
                    <img class="figure-img col-6" style="width:100%"
                        src="https://i.ytimg.com/vi/<?=$yt_code; ?>/maxresdefault.jpg">
                    <figcaption class="figure-caption col-6">
                        <p class="h4"><?= get_the_title($post->ID); ?></p>
                        <a href="<?= get_the_permalink($post->ID); ?>" class="btn btn-primary">Start</a>
                    </figcaption>
                </figure>
            </div>
        </div>
        <?php endwhile; ?>
    </main>
</div>
<?php 
endwhile; 
}
?>
<script>
const previews = document.querySelector('main').querySelectorAll('.card');
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