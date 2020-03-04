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



function lesson_passed() {
  $post_id = $_POST['post_id'];
  set_scheduleMail(get_schedule($post_id));
  wp_die();
  return true;
}

add_action('wp_ajax_lesson_passed', 'lesson_passed'); 

function get_schedule($post_id) {
  $post =  get_post($post_id);
  $post_scheduler = get_post_custom($post_id)['frequency'][0];
  $user_timeRange = unserialize(get_user_meta($post->post_author)['from_range'][0]);

  return [$post_scheduler, $user_timeRange,$post_id];
}

function set_scheduleMail($arr) {
  $post_scheduler = $arr[0];
  $user_timeRange = $arr[1];
  $post_id = $arr[2];

  
  switch ($post_scheduler) {
    case 'Ежедневно':
      $timer =  "daily";
        break;
         case 'Раз в два дня':
      $timer = "two_days";
        break;
        case 'Раз в три дня':
      $timer =  "three_days";
        break;
        case 'Еженедельно':
      $timer =  "weekly";
        break;
}


  if( !wp_next_scheduled('send_notify') )
    wp_schedule_event( strtotime("now"), $timer, 'send_notify',[$post_id]);
  return true;
}

add_action('send_notify', 'send_notify');


function send_notify($post_id) {
  $headers = ['Content-type: text/html; charset=utf-8','From: Шедлер <notify@sche.cq77457.tmweb.ru>'];
  $post =  get_post($post_id);

  $author_mail = get_user_meta($post->post_author)['nickname'][0];
  $post_name = get_the_title($post_id);
  $post_link = '<html><head></head><body><h3>Добрый день!</h3><p>Напоминаем, что на сегодня у вас запланировано повторение урока "<a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>".</p></body></html>';
  wp_mail($author_mail, 'Напоминание о повторении урока '. $post_name, $post_link,$headers);
}



add_action('future_to_publish', 'send_emails_on_new_event');
add_action('new_to_publish', 'send_emails_on_new_event');
add_action('draft_to_publish' ,'send_emails_on_new_event');
add_action('auto-draft_to_publish' ,'send_emails_on_new_event');
 
/**
 * Send emails on event publication
 *
 * @param WP_Post $post
 */
function send_emails_on_new_event($post) {
  set_scheduleMail(get_schedule($post->ID));
}


add_filter( 'cron_schedules', 'cron_add_custom_intervals' );
function cron_add_custom_intervals( $schedules ) {
  $_day = 60 * 60 * 24;
	$schedules['two_days'] = array(
		'interval' =>  $_day * 2,
		'display'  => 'Каждые 2 дня'
  );
	$schedules['three_days'] = array(
		'interval' => $_day * 3,
		'display'  => 'Каждые 3 дня'
  );
	$schedules['weekly'] = array(
		'interval' => $_day * 7,
		'display'  => 'Еженедельно'
	);
	return $schedules;
}