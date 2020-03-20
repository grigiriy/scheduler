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
  $frequency = $_POST['frequency'];

  $timer = get_schedule($frequency,$user_id);
  set_cf($timer,$user_id,$post_id);
  update_scheduleMail($timer,$user_id,$post_id);
  wp_die();
  return true;
}
add_action('wp_ajax_lesson_changed', 'lesson_changed'); 
// AJAX FUNCTION TO UPDATE USERS LESSON TIMERS (NOT READY YET)





// GET USER SPECIFIED TIME BY ID
function get_schedule($frequency,$user_id) {
  
  $user_timeRange = [
    strtotime(get_user_meta($user_id)['mrng_practice'][0]) ? strtotime(get_user_meta($user_id)['mrng_practice'][0]) : strtotime(get_user_meta(1)['mrng_practice'][0]),
    strtotime(get_user_meta($user_id)['daily_practice'][0]) ? strtotime(get_user_meta($user_id)['daily_practice'][0]) : strtotime(get_user_meta(1)['daily_practice'][0]),
    strtotime(get_user_meta($user_id)['evng_practice'][0]) ? strtotime(get_user_meta($user_id)['evng_practice'][0]) : strtotime(get_user_meta(1)['evng_practice'][0])
  ];

  $_day = 60 * 60 * 24;
  $timeZone_msc = 180*60;
	$schedules['light'] = [
    strtotime("now") + $_day * 1 - (strtotime("now")+$timeZone_msc - $user_timeRange[1]),
    strtotime("now") + $_day * 4 - (strtotime("now")+$timeZone_msc - $user_timeRange[2])
  ];
	$schedules['norm'] = [
    strtotime("now") + $_day * 1 - (strtotime("now")+$timeZone_msc - $user_timeRange[0]),
    strtotime("now") + $_day * 3 - (strtotime("now")+$timeZone_msc - $user_timeRange[1]),
    strtotime("now") + $_day * 5 - (strtotime("now")+$timeZone_msc - $user_timeRange[1])
  ];
	$schedules['zombo'] = [
    strtotime("now") + 5*60*60,
    strtotime("now") + $_day * 1 - (strtotime("now")+$timeZone_msc - $user_timeRange[2]),
    strtotime("now") + $_day * 7 - (strtotime("now")+$timeZone_msc - $user_timeRange[2])
  ];

  $timer = $schedules[$frequency];

  return [$frequency, $timer];
}
// GET USER SPECIFIED TIME BY ID






// FILL USERS CUSTOM FIELDS WITH TIMERS
function set_cf($arr,$user_id,$post_id){
  $list = carbon_get_user_meta( $user_id, 'schedule' );
  $var=0;
  foreach ( $list as $key=>$el ) {
    if(intval($el['lesson_id']) === $post_id){
      carbon_set_user_meta( $user_id, 'schedule['.$key.']/cource_frequency', $arr[0] );
      carbon_set_user_meta( $user_id, 'schedule['.$key.']/first_reminder', $arr[1][0] );
      carbon_set_user_meta( $user_id, 'schedule['.$key.']/second_reminder', $arr[1][1] );
      carbon_set_user_meta( $user_id, 'schedule['.$key.']/third_reminder', $arr[1][2] );
      carbon_set_user_meta( $user_id, 'schedule['.$key.']/fourth_reminder', $arr[1][3] );
      // carbon_set_user_meta( $user_id, 'schedule['.$key.']/lesson_id', null );
      // carbon_set_user_meta( $user_id, 'schedule['.$key.']/cource_frequency', null );
      // carbon_set_user_meta( $user_id, 'schedule['.$key.']/first_reminder', null );
      // carbon_set_user_meta( $user_id, 'schedule['.$key.']/second_reminder', null );
      // carbon_set_user_meta( $user_id, 'schedule['.$key.']/third_reminder', null );
      // carbon_set_user_meta( $user_id, 'schedule['.$key.']/fourth_reminder', null );
      // carbon_set_user_meta( $user_id, 'schedule['.$key.']/', [] );
      $var=1;
      return[$arr,$user_id,$post_id];
    }
  }
  if($var===0){
    carbon_set_user_meta( $user_id, 'schedule['.count($list).']/lesson_id', $post_id );
    carbon_set_user_meta( $user_id, 'schedule['.count($list).']/cource_frequency', $arr[0] );
    carbon_set_user_meta( $user_id, 'schedule['.count($list).']/first_reminder', $arr[1][0] );
    carbon_set_user_meta( $user_id, 'schedule['.count($list).']/second_reminder', $arr[1][1] );
    carbon_set_user_meta( $user_id, 'schedule['.count($list).']/third_reminder', $arr[1][2] );
    carbon_set_user_meta( $user_id, 'schedule['.count($list).']/fourth_reminder', $arr[1][3] );
  }
  return[$arr,$user_id,$post_id];
 };
// FILL USERS CUSTOM FIELDS WITH TIMERS



// DELETE OLD AND CREATE NEW TIMERS (ALSO DELETE CRON SCHEDULERS FOR MAIL)
function update_scheduleMail($arr,$user_id,$post_id){
  
  // foreach([0,1,2,3] as $key){
    wp_clear_scheduled_hook( 'send_notify',[$post_id,$user_id] );
    // Удаляет все крон-задачи прикрепленные к указанному хуку и имеющие указанные параметры.
  // }
  set_scheduleMail($arr,$user_id,$post_id);
}
// DELETE OLD AND CREATE NEW TIMERS (ALSO DELETE CRON SCHEDULERS FOR MAIL)






// PARSE SCHEDULE RULES (LIGHT,NORM ETC)
// AND SET TIMERS
// AND CALL A FUNCTION TO SEND LETTERS
function set_scheduleMail($arr,$user_id,$post_id) {

  if( !wp_next_scheduled('send_notify') )
  foreach($arr[1] as $key=>$_timer){
    wp_schedule_single_event( $_timer, 'send_notify',[$post_id,$user_id] );
  }
  return true;
}
// PARSE SCHEDULE RULES (LIGHT,NORM ETC)
// AND SET TIMERS
// AND CALL A FUNCTION TO SEND LETTERS




//MOVING LESSON FROM CF TO CF ARCHIVE_LIST
function move_cf_to_cf_archive($post_id,$user_id){
    // wp_logout();
  $list = carbon_get_user_meta( $user_id, 'schedule' );
  foreach ( $list as $key=>$el ) {
    if(intval($el['lesson_id']) === $post_id){
      switch ($el['cource_frequency']) {
        case 'light':
          $last_lesson = $el['second_reminder'];
          break;
        case 'norm':
          $last_lesson = $el['third_reminder'];
          break;
        case 'zombo':
          $last_lesson = $el['third_reminder'];
          break;
      }
      if($last_lesson <= strtotime("now") ) {
        cource_deletion($post_id,$user_id,$key);
      }
    }
  }

  $cur = carbon_get_user_meta( intval($user_id), 'passed_lessons' );
  $arr = implode(",",array_unique(explode(",", $cur.','.$post_id)));
  carbon_set_user_meta( intval($user_id), 'passed_lessons', $arr );
}
//MOVING LESSON FROM CF TO CF ARCHIVE_LIST


//DELETION COURCE
function cource_deletion($user_id,$key){
  delete_user_meta( intval($user_id), '_schedule|||'.intval($key).'|value');
  delete_user_meta( intval($user_id), '_schedule|lesson_id|'.intval($key).'|0|value');
  delete_user_meta( intval($user_id), '_schedule|cource_frequency|'.intval($key).'|0|value');
  delete_user_meta( intval($user_id), '_schedule|first_reminder|'.intval($key).'|0|value');
  delete_user_meta( intval($user_id), '_schedule|second_reminder|'.intval($key).'|0|value');
  delete_user_meta( intval($user_id), '_schedule|third_reminder|'.intval($key).'|0|value');
}
//DELETION COURCE


// SENDING EMAIL FUNCTION
add_action('send_notify', 'send_notify');

function send_notify($post_id,$user_id) {

  move_cf_to_cf_archive($post_id,$user_id);


  $headers = ['Content-type: text/html; charset=utf-8','From: Шедлер <notify@sche.cq77457.tmweb.ru>'];

  $author_mail = get_userdata($user_id)->user_email;
  $post_name = get_the_title($post_id);
  $post_link = '<html><head></head><body><h3>Добрый день!</h3><p>Напоминаем, что на сегодня у вас запланировано повторение урока "<a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>".</p></body></html>';
  wp_mail($author_mail, 'Напоминание о повторении урока '. $post_name, $post_link, $headers);
}
// SENDING EMAIL FUNCTION



// "ADDING NEW COURSE" TIMER
function adding_timer(){
  return true;
}
// "ADDING NEW COURSE" TIMER


// FINCTIONS, TO USE IN LAYOUT
function display_day($next){
  if($next['month'] === getdate(strtotime("now"))['month']){
    if(getdate(strtotime("now"))['mday'] === $next['mday']){
      $next = 'Today';
      goto fin;
    } else if($next['mday'] - getdate(strtotime("now"))['mday'] == 1) {
      $next = 'Tomorrow';
      goto fin;
    } else if($next['mday'] - getdate(strtotime("now"))['mday'] == 7){
      $next = 'In a week';
      goto fin;
    } else {
      $next = $next['weekday'];
      goto fin;
    }
    $next = $next['weekday'];
  }
  fin:
  echo $next;
};
// FINCTIONS, TO USE IN LAYOUT