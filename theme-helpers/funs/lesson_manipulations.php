<?php
add_action('wp_ajax_lesson_passed', 'lesson_passed'); 
add_action('wp_ajax_add_lesson', 'add_lesson'); 
add_action('wp_ajax_leave_course', 'leave_course'); 

function add_lesson() {
  $user_id = intval($_POST['user_id']);
  $post_id = intval($_POST['post_id']);

  remove_favor($post_id, $user_id);

  if (is_paid($user_id) && !is_post_exist($post_id,$user_id)){
    $my_postarr = array(
      'post_name'    => get_the_author_meta('user_login', $user_id),
      'post_title'    => get_the_title($post_id),
      'post_content'  => get_post($post_id)->post_content, // контент
      'post_parent'   => $post_id,
      'post_type'   => 'lessons',
      'post_author'   => $user_id,
      'post_status'   => 'publish', // опубликованный пост
    );
    $my_post_id = wp_insert_post( $my_postarr );

    $post = get_post( intval($post_id) );

    do_action( 'dp_duplicate_page', $my_post_id, $post, "");

    $type = get_the_terms( $post_id, 'course_type' )[0]->slug;

    wp_set_post_terms( $my_post_id, 'started', 'course_status', false );
    carbon_set_post_meta( $my_post_id, 'course_author_id', $post->post_author);

    // set_adding_timeout($user_id);
    init_schedule($user_id);

    set_timers($my_post_id,$user_id,false);

    if( carbon_get_theme_option( 'teacher' ) ) {
      $lessons_left = carbon_get_user_meta( $user_id, 'new_lessons_left' );

      carbon_set_user_meta( $user_id, 'new_lessons_left', $lessons_left - 1 );

      if($type === 'with-teacher'){ // it seems like rudiment.... need to check on eatans over
        notify_manager($my_post_id); //not done yet!
      } else {
        return false; //2do create show_error function
      }

    }
  } else {
    echo 'NO NEW LESSONS TO THIS USER!';
    return false;
  }  
}

function leave_course() {
    $post_id = intval($_POST['post_id']);
    wp_trash_post( $post_id );
}

function finish_course($post_id) {
    wp_set_post_terms( $post_id, 'finished', 'course_status', false );
}

function fill_lesson_cf ( $timers, $post_id ) {
    foreach ($timers as $key=>$timer) {
      carbon_set_post_meta( $post_id, 'timecode_'.($key+1), $timer );
      if(!$timers[2] && carbon_get_post_meta( $post_id, 'timecode_3') ){
        carbon_set_post_meta( $post_id, 'timecode_3', '' );
      }
    }
}

function lesson_passed() {
    global $now_incTZ;
    $post_id = $_POST['post_id'];
  
    if ( carbon_get_post_meta( $post_id, 'timecode_3') && (carbon_get_post_meta( $post_id, 'timecode_3') <= $now_incTZ) ) {
      carbon_set_post_meta( $post_id, 'passed_3', true);
      finish_course($post_id);
      return true;
    } else if ( carbon_get_post_meta( $post_id, 'timecode_2') <= $now_incTZ ) {
      carbon_set_post_meta( $post_id, 'passed_2', true);
      return true;
    } else if ( carbon_get_post_meta( $post_id, 'timecode_1') <= $now_incTZ ) {
      carbon_set_post_meta( $post_id, 'passed_1', true);
      return true;
    } else {
      carbon_set_post_meta( $post_id, 'passed_0', true);
      return true;
    }
  
}

?>