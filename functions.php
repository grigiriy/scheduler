<?php define('STATIC_FILES_BUILD_VERSION', '1.1');

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
  wp_enqueue_style('bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',[], STATIC_FILES_BUILD_VERSION);
  wp_enqueue_style('timepicker','https:////cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css',['bootstrap'], STATIC_FILES_BUILD_VERSION);
  wp_enqueue_style('main', get_template_directory_uri() . '/css/main.css',['timepicker'], STATIC_FILES_BUILD_VERSION);
}
function theme_scripts()
{
  // wp_enqueue_script('inputmask-multi', get_template_directory_uri() . '/js/jquery.inputmask-multi.min.js',['jquery'], STATIC_FILES_BUILD_VERSION, true);
  
  wp_enqueue_script('timepicker', 'https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js',['jquery'], STATIC_FILES_BUILD_VERSION, true);
  wp_enqueue_script('master-script', get_template_directory_uri() . '/js/main.js',['bootstrap'], STATIC_FILES_BUILD_VERSION, true);
  wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',['timepicker'], STATIC_FILES_BUILD_VERSION, true);
  wp_enqueue_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',['popper'], STATIC_FILES_BUILD_VERSION, true);

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
  include_once __DIR__ . '/theme-helpers/custom-fields/custom.php';
  include_once __DIR__ . '/theme-helpers/custom-fields/gutenberg.php';
}

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
  require_once( 'vendor/autoload.php' );
  \Carbon_Fields\Carbon_Fields::boot();
}

require_once __DIR__ . '/theme-helpers/cpt.php';
require_once __DIR__ . '/theme-helpers/taxonomy.php';


$timeZone_msc = 180*60;
$now_incTZ = strtotime("now")+$timeZone_msc;
// $now_incTZ = strtotime("now");
$_day = 60 * 60 * 24;

  
// FUNS
add_action('wp_ajax_log_out', 'log_out'); 
function log_out(){
  wp_logout();
  wp_die();
  return true;
}


function mins_trim($min) {
  return ($min === 0) ? '00' : $min;
}


function progress_icon($lesson_number,$active_mode){
  $frequency = ($active_mode === 'Light') ? 2 : 3;
  return (100 / ($frequency + 1) * $lesson_number); 
}


function n_days_crop($days) {
  global $now_incTZ;
  global $_day;
  $days *= $_day;
  return ($now_incTZ + $days);
}


// CREATE ARGS FOR COURSE LOOP
// RENDER COURSE LOOP
// FILTERING ON FRONTEND
// FINCTIONS, TO USE IN LAYOUT
// GET PASSED LESSONS ARR
require_once __DIR__ . '/theme-helpers/funs/layout_functions.php';


// IS_TIME_TO_ADD_CHECKER
// if PAID FUN
// is_post_exist
// SET TIMERS
// UPDATE SCHEDULERS ON MODE/TIME CHANGE
// GET USER SPECIFIED TIME BY ID
require_once __DIR__ . '/theme-helpers/funs/calculations.php';


// AJ add_lesson
// AJ leave_course
// AJ lesson_passed
// finish_course
// fill_lesson_cf
require_once __DIR__ . '/theme-helpers/funs/lesson_manipulations.php';


// AJAX FUNCTIONS TO ADD/REMOVE FAVOR
require_once __DIR__ . '/theme-helpers/funs/favor_actions.php';


// AJ update_profile
// AJ ava_file_upload
// AJ set_mode
// AJ update_os_cf
// FINISH REG
require_once __DIR__ . '/theme-helpers/funs/profile_actions.php';


function notify_manager() { return false; } //NOT READY ACTUALLY



// Оставляет пользователя на той же странице при вводе неверного логина/пароля в форме авторизации wp_login_form() //wp-kama
require_once __DIR__ . '/theme-helpers/funs/kama_admin.php';


//notifications
require_once __DIR__ . '/theme-helpers/funs/notifications.php';



// MOVE CURRENT TO PASSED

// function countdown_course($lesson_id) {
//   global $now_incTZ;
//   $timers = [
//     carbon_get_post_meta( $lesson_id, 'timecode_2')
//   ];
//   carbon_get_post_meta( $lesson_id, 'timecode_3' ) ? array_push($timers,carbon_get_post_meta( $lesson_id, 'timecode_3' )) : null;

//   if($timers[count($timers-1)] + 60*60*24 >=$now_incTZ){
//     finish_course($lesson_id);
//   }
// }
// MOVE CURRENT TO PASSED
