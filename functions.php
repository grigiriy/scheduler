<?php

  define('STATIC_FILES_BUILD_VERSION', '1.1');

  //deregister unnessosary scripts
  function my_dequeue_scripts() {
      wp_dequeue_script( 'jquery-ui-core' );
      wp_dequeue_script( 'jquery-ui-sortable' );
  }


  //remove smthng
  add_filter('xmlrpc_enabled', '__return_false');
  remove_action('wp_head','adjacent_posts_rel_link_wp_head');
  remove_action('wp_head', 'wp_shortlink_wp_head');


  // remove hAtom micromarkup
  function remove_hentry( $classes ) {
      $classes = array_diff($classes, array('hentry'));
      return $classes;
  }
  add_filter( 'post_class', 'remove_hentry' );


  // remove Emojii
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_wp_emojis_in_tinymce' );
  function disable_wp_emojis_in_tinymce( $plugins ) {
      if ( is_array( $plugins ) ) {
          return array_diff( $plugins, array( 'wpemoji' ) );
      } else {
          return array();
      }
  }


  // start
  function theme_styles()
  {
      wp_enqueue_style('master-style', get_template_directory_uri() . '/css/main.css',[], STATIC_FILES_BUILD_VERSION);
  }
  function theme_scripts()
  {
      wp_enqueue_script('master-script', get_template_directory_uri() . '/js/main.js',['jquery'], STATIC_FILES_BUILD_VERSION, true);
  }
  add_action('wp_print_styles', 'theme_styles');
  add_action('wp_print_styles', 'theme_scripts');


  // menus
  add_action(
    'after_setup_theme',
    function () {
      register_nav_menus(
        [
          'header_menu' => 'Header Menu',
          'user_menu' => 'User Menu',
          'footer_menu' => 'Footer Menu',
        ]
      );
    }
  );

  add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

  function special_nav_class($classes, $item){
      $classes[] = 'nav-item';
      return $classes;
  }

  add_action( 'carbon_fields_register_fields', 'crb_register_custom_fields' );
  function crb_register_custom_fields() {
      include_once __DIR__ . '/theme-helpers/custom-fields/lessons.php';
  }

  add_action( 'after_setup_theme', 'crb_load' );
  function crb_load() {
      require_once( 'vendor/autoload.php' );
      \Carbon_Fields\Carbon_Fields::boot();
  }

  require_once __DIR__ . '/theme-helpers/cpt.php';
  require_once __DIR__ . '/theme-helpers/taxonomy.php';


  $timeZone_msc = 180*60;
  // $now_incTZ = strtotime("now")+$timeZone_msc;
  $now_incTZ = strtotime("now");
  $_day = 60 * 60 * 24;

?>

<?php
// FINCTIONS, TO USE IN LAYOUT
function display_day($next) {
  global $now_incTZ;
    if(getdate($now_incTZ)['mday'] === $next['mday']){
      $next = 'Today';
      goto fin;
    } else if($next['mday'] - getdate($now_incTZ)['mday'] == 1) {
      $next = 'Tomorrow';
      goto fin;
    } else if($next['mday'] - getdate($now_incTZ)['mday'] == 7){
      $next = 'In a week';
      goto fin;
    } else {
      $next = $next['weekday'];
      goto fin;
    }
    $next = $next['weekday'];
  fin:
  return $next;
};

function mins_trim($min) {
  return ($min === 0) ? '00' : $min;
}

function progress_icon($lesson_number,$frequency){
  $frequency = ($frequency === 'Light') ? 2 : 3;
  return (100 / ($frequency + 1) * $lesson_number); 
  // return($lesson_number.' '.$frequency);
}

function n_days_crop($days) {
  global $now_incTZ;
  global $_day;
  $days *= $_day;
  return ($now_incTZ + $days);
}
// FINCTIONS, TO USE IN LAYOUT

// CREATE ARGS FOR COURSE LOOP
function set_course_loop($post_id){

  if (get_the_title($post_id) === 'Current lessons') {
    $this_page = 'current';
  } else if (get_the_title($post_id) === 'Already passed') {
      $this_page = 'passed';
  } else if (get_the_title($post_id) === 'Favorite') {
      $this_page = 'favorite';
  } else {
      $this_page = 'courses';
  }

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
  return ($args);
}
// CREATE ARGS FOR COURSE LOOP

// RENDER COURSE LOOP
function render_courses($args) {
  $lessons_query = get_posts($args);
  if(count($lessons_query) ){
    foreach ($lessons_query as $_post) {
      set_query_var('_post',$_post);
      get_template_part('theme-helpers/template-parts/courses','card');
    } 
  } else { get_template_part('theme-helpers/template-parts/courses','empty'); }
}
// RENDER COURSE LOOP

// FILTERING ON FRONTEND
function myfilter() {
  $post_id = intval($_POST['post_id']);
  $args = set_course_loop($post_id);
  $data = json_decode(stripcslashes($_POST['data']));

  $args['tax_query'] = [ 'relation'=>'AND' ];

  foreach ($data as $param){
    if($param->value !== 'any'){
      $args['tax_query'][]=[
        'taxonomy' => $param->name,
        'field' => 'id',
        'terms' => $param->value
      ];
    }
  }

  render_courses($args);
  
//нужно будет делать проверку и писать в пост__нот_ин как на сет_курс_луп. пока на паузу
// прояснить с тегами - ор или энд
wp_die();
}

add_action('wp_ajax_myfilter', 'myfilter'); 
add_action('wp_ajax_nopriv_myfilter', 'myfilter');
// FILTERING ON FRONTEND


// "ADDING NEW COURSE" TIMER
function set_adding_timeout($user_id){

  $user_timeRange = strtotime(get_user_meta($user_id)['mrng_practice'][0]) ? strtotime(get_user_meta($user_id)['mrng_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['mrng_practice'][0])+$timeZone_msc;

  global $now_incTZ;
  global $_day;
  $next_add = $user_timeRange + $_day*2;
  carbon_set_user_meta( intval($user_id), 'next_lesson', $next_add );
  wp_schedule_single_event( $next_add, 'send_notify', ['starter',$user_id] );
}
// "ADDING NEW COURSE" TIMER


//AJAX FUNCTION ADD TO FAVOR
function add_to_favor(){
  $post_id = intval($_POST['post_id']);
  $user_id = intval($_POST['user_id']);

  $fav = carbon_get_user_meta( intval($user_id), 'favor_lessons' );
  $arr = implode(",",array_unique(explode(",", $fav.','.$post_id)));
  carbon_set_user_meta( intval($user_id), 'favor_lessons', trim($arr,',') );

  return true;
}
add_action('wp_ajax_add_to_favor', 'add_to_favor'); 
//AJAX FUNCTION ADD TO FAVOR

//AJAX FUNCTION REMOVE FAVOR
function remove_favor(){
  $post_id = intval($_POST['post_id']);
  $user_id = intval($_POST['user_id']);
  $fav = explode(",",carbon_get_user_meta( intval($user_id), 'favor_lessons' ));

  foreach ($fav as $key=>$ar) {
      if(intval($post_id) === intval($ar)) {
          unset($fav[$key]);
          break;
      }
  }
  
  $arr = implode(",",$fav);
  echo $arr;
  carbon_set_user_meta( intval($user_id), 'favor_lessons', trim($arr,',') );
}
add_action('wp_ajax_remove_favor', 'remove_favor'); 
//AJAX FUNCTION REMOVEADD TO FAVOR

//AJAX FUNCTION LEAVE COURSE
function leave_course() {
  $post_id = intval($_POST['post_id']);
  wp_trash_post( $post_id );
}
add_action('wp_ajax_leave_course', 'leave_course'); 
//AJAX FUNCTION LEAVE COURSE

// AJAX FUNCTION TO JOIN COURSE
function add_lesson() {
  $user_id = intval($_POST['user_id']);
  $post_id = $_POST['post_id'];

  $my_postarr = array(
    'post_name'    => get_the_author_meta('user_login', $user_id),
    'post_title'    => get_the_title($post_id),
    'post_content'  => '', // контент
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

  set_adding_timeout($user_id);

  if($type === 'with-teacher'){
    set_timers($my_post_id,$user_id);
    notify_manager($my_post_id); //not done yet!
  } else if( $type === 'self' ) {
    set_timers($my_post_id,$user_id);
  } else {
    return false; //2do create show_error function
  }
}
add_action('wp_ajax_add_lesson', 'add_lesson'); 
// AJAX FUNCTION TO JOIN COURSE


// AJAX FUNCTION TO MARK LESSON AS COMPLETED
function lesson_passed() {
  global $now_incTZ;

  $post_id = $_POST['post_id'];

if( !(carbon_get_post_meta( $post_id, '0_passed') ) ) {
  carbon_set_post_meta( $post_id, '0_passed', true);
  return true;
} else {
  if ( carbon_get_post_meta( $post_id, '3_timecode') && (carbon_get_post_meta( $post_id, '3_timecode') <= $now_incTZ) ) {
    
    carbon_set_post_meta( $post_id, '3_passed', true);
    finish_course($post_id);
    return true;
      
  } else if ( carbon_get_post_meta( $post_id, '2_timecode') <= $now_incTZ ) {
    carbon_set_post_meta( $post_id, '2_passed', true);
    return true;
  } else if ( carbon_get_post_meta( $post_id, '1_timecode') <= $now_incTZ ) {
    carbon_set_post_meta( $post_id, '1_passed', true);
    return true;
  }
}

}
add_action('wp_ajax_lesson_passed', 'lesson_passed'); 
// AJAX FUNCTION TO MARK LESSON AS COMPLETED

function notify_manager() { return false; }

function finish_course($post_id) {
  wp_set_post_terms( $post_id, 'finished', 'course_status', false );
}

function set_timers( $post_id, $user_id)  {
  $frequency = get_user_meta( $user_id )['frequency'][0];
  $timer = get_schedule( $frequency, $user_id );
  fill_lesson_cf( $timer, $post_id );
}

function fill_lesson_cf ( $timers, $post_id ) {
  foreach ($timers as $key=>$timer) {
    carbon_set_post_meta( $post_id, ($key+1).'_timecode', $timer );
  }
}

// GET USER SPECIFIED TIME BY ID
function get_schedule($frequency,$user_id) {
  
  global $now_incTZ;
  global $_day;
  global $timeZone_msc;

  $user_timeRange = [
    strtotime(get_user_meta($user_id)['mrng_practice'][0]) ? strtotime(get_user_meta($user_id)['mrng_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['mrng_practice'][0])+$timeZone_msc,
    // strtotime(get_user_meta($user_id)['daily_practice'][0]) ? strtotime(get_user_meta($user_id)['daily_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['daily_practice'][0])+$timeZone_msc,
    strtotime(get_user_meta($user_id)['evng_practice'][0]) ? strtotime(get_user_meta($user_id)['evng_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['evng_practice'][0])+$timeZone_msc
  ];

	$schedules['Light'] = [
    $now_incTZ + $_day * 1 - ($now_incTZ - $user_timeRange[1]),
    $now_incTZ + $_day * 4 - ($now_incTZ - $user_timeRange[1])
  ];
	$schedules['Normal'] = [
    $now_incTZ + $_day * 1 - ($now_incTZ - $user_timeRange[0]),
    $now_incTZ + $_day * 3 - ($now_incTZ - $user_timeRange[1]),
    $now_incTZ + $_day * 5 - ($now_incTZ - $user_timeRange[1])
  ];
	$schedules['Zombo'] = [
    $now_incTZ + 5*60*60,
    $now_incTZ + $_day * 1 - ($now_incTZ - $user_timeRange[1]),
    $now_incTZ + $_day * 7 - ($now_incTZ - $user_timeRange[1])
  ];

  $timer = $schedules[$frequency];

  return $timer;
}

// function add_to_missed($user_id,$current_lesson_key,$current_lesson_val){
//   $missed = carbon_get_user_meta( intval($user_id), 'schedule['.$current_lesson_key.']/missed_lessons');

//   $arr = implode(",",array_unique(explode(",", $missed.','.$current_lesson_val)));

//   carbon_set_user_meta( intval($user_id), 'schedule['.$current_lesson_key.']/missed_lessons', trim($arr,','));
// }


// function check_current_lesson($user_id,$post_id,$is_final,$less_vals,$current_lesson_key) {
//   $current_lesson_val = carbon_get_user_meta( intval($user_id), 'schedule['.$current_lesson_key.']/current_lesson');

//   $list = carbon_get_user_meta( $user_id, 'schedule' );
//   foreach ( $list as $key=>$el ) {
//     if( $el['lesson_id'] === $post_id ) {
//       $current_lesson_key = $key;
//       break;
//     }
//   }


//   if (!$is_final) {
//     global $now_incTZ;
//     $next_lesson_time = ( intval($current_lesson_val > 0) ) ? $less_vals[$current_lesson_val-1] : 1;

//     if($next_lesson_time <= $now_incTZ){
//       set_current_lesson_val($current_lesson_val,$current_lesson_key,$user_id);
//       add_to_missed( $user_id, $current_lesson_key, $current_lesson_val );
//     }
//   }
// }

// // FILL USERS CUSTOM FIELDS WITH TIMERS
// function set_cf($timer,$user_id,$post_id,$current_lesson_val){
//   $list = carbon_get_user_meta( $user_id, 'schedule' );
//   $var=0;
//   foreach ( $list as $key=>$el ) {
//     if(intval($el['lesson_id']) === $post_id){
//       carbon_set_user_meta( $user_id, 'schedule['.$key.']/first_reminder', $timer[0] );
//       carbon_set_user_meta( $user_id, 'schedule['.$key.']/second_reminder', $timer[1] );
//       carbon_set_user_meta( $user_id, 'schedule['.$key.']/third_reminder', $timer[2] );
//       carbon_set_user_meta( $user_id, 'schedule['.$key.']/current_lesson', $current_lesson_val );
//       $var=1;
//       return[$timer,$user_id,$post_id];
//     }
//   }
//   if($var===0){
//     carbon_set_user_meta( $user_id, 'schedule['.count($list).']/lesson_id', $post_id );
//     carbon_set_user_meta( $user_id, 'schedule['.count($list).']/first_reminder', $timer[0] );
//     carbon_set_user_meta( $user_id, 'schedule['.count($list).']/second_reminder', $timer[1] );
//     carbon_set_user_meta( $user_id, 'schedule['.count($list).']/third_reminder', $timer[2] );
//     carbon_set_user_meta( $user_id, 'schedule['.count($list).']/current_lesson', $current_lesson_val );
//   }
//   return[$timer,$user_id,$post_id];
//  };
// // FILL USERS CUSTOM FIELDS WITH TIMERS



// // DELETE OLD AND CREATE NEW TIMERS (ALSO DELETE CRON SCHEDULERS FOR MAIL)
// function update_scheduleMail($timer,$user_id,$post_id){
  
//   // foreach([0,1,2,3] as $key){
//     wp_clear_scheduled_hook( 'send_notify',[$post_id,$user_id] );
//     // Удаляет все крон-задачи прикрепленные к указанному хуку и имеющие указанные параметры.
//   // }
//   set_scheduleMail($timer,$user_id,$post_id);
// }
// // DELETE OLD AND CREATE NEW TIMERS (ALSO DELETE CRON SCHEDULERS FOR MAIL)






// // PARSE SCHEDULE RULES (LIGHT,normal ETC)
// // AND SET TIMERS
// // AND CALL A FUNCTION TO SEND LETTERS
// function set_scheduleMail($timer,$user_id,$post_id) {

//   if( !wp_next_scheduled('send_notify') )
//   foreach($timer as $key=>$_timer){
//     wp_schedule_single_event( $_timer, 'send_notify', [$post_id,$user_id] );
//   }
//   return true;
// }
// // PARSE SCHEDULE RULES (LIGHT,normal ETC)
// // AND SET TIMERS
// // AND CALL A FUNCTION TO SEND LETTERS




// //MOVING LESSON FROM CF TO CF ARCHIVE_LIST
// function move_cf_to_cf_archive($post_id,$user_id,$current_lesson_key){

//   // global $now_incTZ;
//   $list = carbon_get_user_meta( $user_id, 'schedule' );
//   $length = count($list)-1;
//   cource_deletion($user_id,$current_lesson_key,$length);

//   $cur = carbon_get_user_meta( intval($user_id), 'passed_lessons' );
//   $arr = implode(",",array_unique(explode(",", $cur.','.$post_id)));
//   carbon_set_user_meta( intval($user_id), 'passed_lessons', trim($arr,',') );
// }
// //MOVING LESSON FROM CF TO CF ARCHIVE_LIST



// //DELETION COURCE
// function cource_deletion($user_id,$key,$length) {
//   if($key < $length){
//     _update_item( $user_id, $key, $length );
//     _delete_item( $user_id, $length );
//   } else {
//     _delete_item( $user_id, $key );
//   }

// }
// //DELETION COURCE
// // UPDATE PREV
// function _update_item( $user_id, $key, $length ) {
//   update_user_meta(
//     $user_id,
//     '_schedule|lesson_id|'.$key.'|0|value',
//     implode(',',get_user_meta($user_id,'_schedule|lesson_id|'.$length.'|0|value'))
//   );
//   update_user_meta(
//     $user_id,
//     '_schedule|first_reminder|'.$key.'|0|value',
//     implode(',',get_user_meta($user_id,'_schedule|first_reminder|'.$length.'|0|value'))
//   );
//   update_user_meta(
//     $user_id,
//     '_schedule|second_reminder|'.$key.'|0|value',
//     implode(',',get_user_meta($user_id,'_schedule|second_reminder|'.$length.'|0|value'))
//   );
//   update_user_meta(
//     $user_id,
//     '_schedule|third_reminder|'.$key.'|0|value',
//     implode(',',get_user_meta($user_id,'_schedule|third_reminder|'.$length.'|0|value'))
//   );
//   update_user_meta(
//     $user_id,
//     '_schedule|missed_lessons|'.$key.'|0|value',
//     implode(',',get_user_meta($user_id,'_schedule|missed_lessons|'.$length.'|0|value'))
//   );
//   update_user_meta(
//     $user_id,
//     '_schedule|current_lesson|'.$key.'|0|value',
//     implode(',',get_user_meta($user_id,'_schedule|current_lesson|'.$length.'|0|value'))
//   );
//   update_user_meta(
//     $user_id,
//     '_schedule|||'.$key.'|value',
//     implode(',',get_user_meta($user_id,'_schedule|||'.$length.'|value'))
//   );
// }
// // UPDATE PREV
// // DELETE KEY
// function _delete_item( $user_id, $key ) {
// delete_user_meta( $user_id, '_schedule|lesson_id|'.$key.'|0|value');
// delete_user_meta( $user_id, '_schedule|first_reminder|'.$key.'|0|value');
// delete_user_meta( $user_id, '_schedule|second_reminder|'.$key.'|0|value');
// delete_user_meta( $user_id, '_schedule|third_reminder|'.$key.'|0|value');
// delete_user_meta( $user_id, '_schedule|current_lesson|'.$key.'|0|value');
// delete_user_meta( $user_id, '_schedule|missed_lessons|'.$key.'|0|value');
// delete_user_meta( $user_id, '_schedule|||'.$key.'|value');
// }
// // DELETE KEY

// // SENDING EMAIL FUNCTION
// add_action('send_notify', 'send_notify_fun',10,2);


// function send_notify_fun($post_id,$user_id) {

//   // move_cf_to_cf_archive($post_id,$user_id);
//   $headers = ['Content-type: text/html; charset=utf-8','From: Happy English <notify@cq77457.tmweb.ru>'];

//   $recepient = get_userdata($user_id)->user_email;
//   // $recepient = 'grigiriy.malyshev@gmail.com';
//   if($post_id === 'starter'){
//     $post_link = '<html><head></head><body><h3>Здравствуйте!</h3><p>Напоминаем, что сегодня вы можете добавить новый урок! "<a href="cq77457.tmweb.ru/cources/">Библиотека уроков</a>".</p></body></html>';
//     $post_header = 'Новый урок!';
//   } else {
//     $post_name = get_the_title($post_id);
//     $post_link = '<html><head></head><body><h3>Здравствуйте!</h3><p>Напоминаем, что у вас запланировано повторение урока "<a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>".</p></body></html>';
//     $post_header = 'Напоминание о повторении урока '.$post_name;
//   }
//   wp_mail($recepient, $post_header, $post_link, $headers);
// return true;
// }
// // SENDING EMAIL FUNCTION

// // UPDATE TIMERS ON PRACTICE_SCHEDULE CHANGE
// // add_action( 'personal_options_update', 'action_function_name_2334' );
// add_action( 'personal_options_update', 'action_function_name_2334' );
// $user_id = get_current_user_id();
// function action_function_name_2334($user_id){
//   // $user_timeRange = [
//   //   strtotime(get_user_meta($user_id)['mrng_practice'][0]) ? strtotime(get_user_meta($user_id)['mrng_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['mrng_practice'][0])+$timeZone_msc,
//   //   strtotime(get_user_meta($user_id)['daily_practice'][0]) ? strtotime(get_user_meta($user_id)['daily_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['daily_practice'][0])+$timeZone_msc,
//   //   strtotime(get_user_meta($user_id)['evng_practice'][0]) ? strtotime(get_user_meta($user_id)['evng_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['evng_practice'][0])+$timeZone_msc
//   // ];
// }
// // UPDATE TIMERS ON PRACTICE_SCHEDULE CHANGE


// // FILL PREV PRACT
// function fill_prev_pract() {
//   $user_id = intval($_POST['user_id']);
//   $user_timeRange = implode(',',[
//     strtotime(get_user_meta($user_id)['mrng_practice'][0]) ? strtotime(get_user_meta($user_id)['mrng_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['mrng_practice'][0])+$timeZone_msc,
//     strtotime(get_user_meta($user_id)['daily_practice'][0]) ? strtotime(get_user_meta($user_id)['daily_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['daily_practice'][0])+$timeZone_msc,
//     strtotime(get_user_meta($user_id)['evng_practice'][0]) ? strtotime(get_user_meta($user_id)['evng_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['evng_practice'][0])+$timeZone_msc
//   ]);
//   carbon_set_user_meta( intval($user_id), 'prev_pract_vals', $user_timeRange );
//   echo implode(',',getdate(explode(',',$user_timeRange)[0]));
// }
// add_action('wp_ajax_fill_prev_pract', 'fill_prev_pract'); 
// // FILL PREV PRACT