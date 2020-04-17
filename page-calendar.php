<?php
/**
 * Template Name: Calendar Page
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

    $role = wp_get_current_user()->roles[0];
    if(
        // $role === 'administrator' ||
        $role === 'author' ||
        $role === 'editor' 
    ) {
        $is_teacher = true;
        $args = array(
            'post_type'  => 'lessons',
            'course_status'   => 'started',
            'meta_query'    =>  [
                'course_author_id'  =>  $user_id
            ]
        );

    } else {
        $is_teacher = false;
        $args = array(
            'post_type'  => 'lessons',
            'author'     => $user_id,
            'course_status'   => 'started',
        );
    }

        

        $wp_posts = get_posts($args);
        if( count($wp_posts) ) {
            
            $timers=[];
            
            foreach ( $wp_posts as $key=>$post ) {
                if( carbon_get_post_meta( $post->ID, '1_timecode') >= $now_incTZ && carbon_get_post_meta( $post->ID, '1_passed') !== 'true') {
                    array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, '1_timecode' ),$post->ID]));
                }
                if( carbon_get_post_meta( $post->ID, '2_timecode' ) >= $now_incTZ && carbon_get_post_meta( $post->ID, '2_passed') !== 'true') {
                    array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, '2_timecode' ),$post->ID]));
                }
                if( carbon_get_post_meta( $post->ID, '3_timecode' ) ) {
                    if( carbon_get_post_meta( $post->ID, '3_timecode' ) >= $now_incTZ && carbon_get_post_meta( $post->ID, '3_passed') !== 'true') {
                        array_push($timers,implode(',',[carbon_get_post_meta( $post->ID, '3_timecode' ),$post->ID]));
                    }
                }
            }
            sort($timers);
            $next = explode(',',$timers[0])[0];    
            wp_reset_postdata();

?>
<div class="container">
    <main class="row">
        <h3>Your Schedule</h3>
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Lesson</th>
                    <th scope="col">Day</th>
                    <?= $is_teacher ? '<th scope="col">Student</th>' : null; ?>
                    <th scope="col">Time</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach($timers as $key=>$timer){
                    $timer = explode(',',$timer);
                ?>
                <tr class="bg-<?= ($key%2===0)?'light':'white' ?>">
                    <td><a href="<?= get_the_permalink($timer[1]);?>"
                            class="text-info"><?= get_the_title($timer[1]) ?></a></td>
                    <td><?= display_day(getdate($timer[0])); ?></td>
                    <?= $is_teacher ? '<td>'.get_the_author_link($timer[1]).'</td>' : null; ?>
                    <td><?= getdate($timer[0])['hours'].':'.getdate($timer[0])['minutes'] ?></td>
                </tr>
                <?php
                }
            }
        }
        ?>
            </tbody>
        </table>
    </main>
</div>

<?php get_footer(); ?>