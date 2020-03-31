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





// AJAX FUNCTION TO MARK LESSON AS COMPLETED (NOT READY YET)
function lesson_passed() {
  // wp_logout();
// IDK VAT 4 IZ IT
  $post_id = $_POST['post_id'];
  $user_id = $_POST['user_id'];
  // // set_scheduleMail(get_schedule($post_id));
  // set_cf(get_schedule($post_id),$user_id);
  // wp_die();
  // return true;
  move_cf_to_cf_archive($post_id,$user_id);
}
add_action('wp_ajax_lesson_passed', 'lesson_passed'); 
// AJAX FUNCTION TO MARK LESSON AS COMPLETED (NOT READY YET)




// AJAX FUNCTION TO UPDATE USERS LESSON TIMERS (NOT READY YET)
function lesson_changed() {
  $post_id = intval($_POST['post_id']);
  $user_id = intval($_POST['user_id']);
  $frequency = get_user_meta($user_id)['frequency'][0];

  set_adding_timeout($user_id);
  $timer = get_schedule($frequency,$user_id);
  set_cf($timer,$user_id,$post_id);
  update_scheduleMail($timer,$user_id,$post_id);
  wp_die();
  return $frequency;
}
add_action('wp_ajax_lesson_changed', 'lesson_changed'); 
// AJAX FUNCTION TO UPDATE USERS LESSON TIMERS (NOT READY YET)



//AJAX FUNCTION LEAVE COURSE
function leave_course(){
  $post_id = intval($_POST['post_id']);
  $user_id = intval($_POST['user_id']);
  $list = carbon_get_user_meta( $user_id, 'schedule' );
  $length = count($list)-1;

  foreach ( $list as $key=>$el ) {
    if(intval($el['lesson_id']) === $post_id) {
      cource_deletion($user_id,$key,$length);
      // wp_clear_scheduled_hook( 'send_notify',[$post_id,$user_id] );
      $a = $key;
      break;
    }
  }

  return true;
}
add_action('wp_ajax_leave_course', 'leave_course'); 
//AJAX FUNCTION LEAVE COURSE


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



$timeZone_msc = 180*60;
// $now_incTZ = strtotime("now")+$timeZone_msc;
$now_incTZ = strtotime("now");
$_day = 60 * 60 * 24;

// GET USER SPECIFIED TIME BY ID
function get_schedule($frequency,$user_id) {
  
  $user_timeRange = [
    strtotime(get_user_meta($user_id)['mrng_practice'][0]) ? strtotime(get_user_meta($user_id)['mrng_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['mrng_practice'][0])+$timeZone_msc,
    strtotime(get_user_meta($user_id)['daily_practice'][0]) ? strtotime(get_user_meta($user_id)['daily_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['daily_practice'][0])+$timeZone_msc,
    strtotime(get_user_meta($user_id)['evng_practice'][0]) ? strtotime(get_user_meta($user_id)['evng_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['evng_practice'][0])+$timeZone_msc
  ];

  global $now_incTZ;
  global $_day;

	$schedules['Light'] = [
    $now_incTZ + $_day * 1 - ($now_incTZ - $user_timeRange[1]),
    $now_incTZ + $_day * 4 - ($now_incTZ - $user_timeRange[2])
  ];
	$schedules['Normal'] = [
    $now_incTZ + $_day * 1 - ($now_incTZ - $user_timeRange[0]),
    $now_incTZ + $_day * 3 - ($now_incTZ - $user_timeRange[1]),
    $now_incTZ + $_day * 5 - ($now_incTZ - $user_timeRange[1])
  ];
	$schedules['Zombo'] = [
    $now_incTZ + 5*60*60,
    $now_incTZ + $_day * 1 - ($now_incTZ - $user_timeRange[2]),
    $now_incTZ + $_day * 7 - ($now_incTZ - $user_timeRange[2])
  ];

  $timer = $schedules[$frequency];

  // return [$frequency, $timer];
  return $timer;
}
// GET USER SPECIFIED TIME BY ID






// FILL USERS CUSTOM FIELDS WITH TIMERS
function set_cf($timer,$user_id,$post_id){
  $list = carbon_get_user_meta( $user_id, 'schedule' );
  $var=0;
  foreach ( $list as $key=>$el ) {
    if(intval($el['lesson_id']) === $post_id){
      carbon_set_user_meta( $user_id, 'schedule['.$key.']/first_reminder', $timer[0] );
      carbon_set_user_meta( $user_id, 'schedule['.$key.']/second_reminder', $timer[1] );
      carbon_set_user_meta( $user_id, 'schedule['.$key.']/third_reminder', $timer[2] );
      $var=1;
      return[$timer,$user_id,$post_id];
    }
  }
  if($var===0){
    carbon_set_user_meta( $user_id, 'schedule['.count($list).']/lesson_id', $post_id );
    carbon_set_user_meta( $user_id, 'schedule['.count($list).']/first_reminder', $timer[0] );
    carbon_set_user_meta( $user_id, 'schedule['.count($list).']/second_reminder', $timer[1] );
    carbon_set_user_meta( $user_id, 'schedule['.count($list).']/third_reminder', $timer[2] );
  }
  return[$timer,$user_id,$post_id];
 };
// FILL USERS CUSTOM FIELDS WITH TIMERS



// DELETE OLD AND CREATE NEW TIMERS (ALSO DELETE CRON SCHEDULERS FOR MAIL)
function update_scheduleMail($timer,$user_id,$post_id){
  
  // foreach([0,1,2,3] as $key){
    wp_clear_scheduled_hook( 'send_notify',[$post_id,$user_id] );
    // Удаляет все крон-задачи прикрепленные к указанному хуку и имеющие указанные параметры.
  // }
  set_scheduleMail($timer,$user_id,$post_id);
}
// DELETE OLD AND CREATE NEW TIMERS (ALSO DELETE CRON SCHEDULERS FOR MAIL)






// PARSE SCHEDULE RULES (LIGHT,normal ETC)
// AND SET TIMERS
// AND CALL A FUNCTION TO SEND LETTERS
function set_scheduleMail($timer,$user_id,$post_id) {

  if( !wp_next_scheduled('send_notify') )
  foreach($timer as $key=>$_timer){
    wp_schedule_single_event( $_timer, 'send_notify', [$post_id,$user_id] );
  }
  return true;
}
// PARSE SCHEDULE RULES (LIGHT,normal ETC)
// AND SET TIMERS
// AND CALL A FUNCTION TO SEND LETTERS




//MOVING LESSON FROM CF TO CF ARCHIVE_LIST
function move_cf_to_cf_archive($post_id,$user_id){

  global $now_incTZ;
  $list = carbon_get_user_meta( $user_id, 'schedule' );
  $length = count($list)-1;
  foreach ( $list as $key=>$el ) {
    if(intval($el['lesson_id']) === $post_id){
      switch (get_user_meta($user_id)['frequency'][0]) {
        case 'light':
          $last_lesson = $el['second_reminder'];
          break;
        case 'normal':
          $last_lesson = $el['third_reminder'];
          break;
        case 'zombo':
          $last_lesson = $el['third_reminder'];
          break;
      }
      if($last_lesson <= $now_incTZ ) {
        cource_deletion($user_id,$key,$length);
      }
    }
  }

  $cur = carbon_get_user_meta( intval($user_id), 'passed_lessons' );
  $arr = implode(",",array_unique(explode(",", $cur.','.$post_id)));
  carbon_set_user_meta( intval($user_id), 'passed_lessons', trim($arr,',') );
}
//MOVING LESSON FROM CF TO CF ARCHIVE_LIST



//DELETION COURCE
function cource_deletion($user_id,$key,$length) {
  if($key < $length){
    _update_item( $user_id, $key, $length );
    _delete_item( $user_id, $length );
  } else {
    _delete_item( $user_id, $key );
  }
}
//DELETION COURCE


// SENDING EMAIL FUNCTION
add_action('send_notify', 'send_notify_fun',10,2);


function send_notify_fun($post_id,$user_id) {

  // move_cf_to_cf_archive($post_id,$user_id);
  $headers = ['Content-type: text/html; charset=utf-8','From: Шедлер <notify@cq77457.tmweb.ru>'];

  $recepient = get_userdata($user_id)->user_email;
  // $recepient = 'grigiriy.malyshev@gmail.com';
  if($post_id === 'starter'){
    $post_link = '<html><head></head><body><h3>Здравствуйте!</h3><p>Напоминаем, что сегодня вы можете добавить новый урок! "<a href="cq77457.tmweb.ru/cources/">Библиотека уроков</a>".</p></body></html>';
    $post_header = 'Новый урок!';
  } else {
    $post_name = get_the_title($post_id);
    $post_link = '<html><head></head><body><h3>Здравствуйте!</h3><p>Напоминаем, что у вас запланировано повторение урока "<a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>".</p></body></html>';
    $post_header = 'Напоминание о повторении урока '.$post_name;
  }
  wp_mail($recepient, $post_header, $post_link, $headers);
return true;
}
// SENDING EMAIL FUNCTION


// UPDATE PREV
function _update_item( $user_id, $key, $length ) {
  update_user_meta(
    $user_id,
    '_schedule|lesson_id|'.$key.'|0|value',
    implode(',',get_user_meta($user_id,'_schedule|lesson_id|'.$length.'|0|value'))
  );
  update_user_meta(
    $user_id,
    '_schedule|first_reminder|'.$key.'|0|value',
    implode(',',get_user_meta($user_id,'_schedule|first_reminder|'.$length.'|0|value'))
  );
  update_user_meta(
    $user_id,
    '_schedule|second_reminder|'.$key.'|0|value',
    implode(',',get_user_meta($user_id,'_schedule|second_reminder|'.$length.'|0|value'))
  );
  update_user_meta(
    $user_id,
    '_schedule|third_reminder|'.$key.'|0|value',
    implode(',',get_user_meta($user_id,'_schedule|third_reminder|'.$length.'|0|value'))
  );
  update_user_meta(
    $user_id,
    '_schedule|||'.$key.'|value',
    implode(',',get_user_meta($user_id,'_schedule|||'.$length.'|value'))
  );
}
// UPDATE PREV
// DELETE KEY
function _delete_item( $user_id, $key ) {
delete_user_meta( $user_id, '_schedule|lesson_id|'.$key.'|0|value');
delete_user_meta( $user_id, '_schedule|first_reminder|'.$key.'|0|value');
delete_user_meta( $user_id, '_schedule|second_reminder|'.$key.'|0|value');
delete_user_meta( $user_id, '_schedule|third_reminder|'.$key.'|0|value');
delete_user_meta( $user_id, '_schedule|||'.$key.'|value');
}
// DELETE KEY


// "ADDING NEW COURSE" TIMER
function set_adding_timeout($user_id){

  $user_timeRange = strtotime(get_user_meta($user_id)['mrng_practice'][0]) ? strtotime(get_user_meta($user_id)['mrng_practice'][0])+$timeZone_msc : strtotime(get_user_meta(1)['mrng_practice'][0])+$timeZone_msc;

  global $now_incTZ;
  global $_day;
  $next_add = $user_timeRange + $_day*2;
  // $next_add = $now_incTZ + 20;
  carbon_set_user_meta( intval($user_id), 'next_lesson', $next_add );
  wp_schedule_single_event( $next_add, 'send_notify', ['starter',$user_id] );
}
// "ADDING NEW COURSE" TIMER


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


function n_days_crop($days) {
  global $now_incTZ;
  global $_day;
  $days *= $_day;
  return ($now_incTZ + $days);
}
// FINCTIONS, TO USE IN LAYOUT