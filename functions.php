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
  
//нужно будет делать проверку и писать в пост__нот_ин как на сет_курс_луп. пока на паузу (не помню зачем - надо будет разобраться)
// прояснить с тегами - ор или энд
wp_die();
}

add_action('wp_ajax_log_out', 'log_out'); 
function log_out(){
  wp_logout();
  wp_die();
  return true;
}


add_action('wp_ajax_myfilter', 'myfilter'); 
add_action('wp_ajax_nopriv_myfilter', 'myfilter');
// FILTERING ON FRONTEND

// IS_TIME_TO_ADD_CHECKER
function is_time_to_add($next_lesson_adding_time){
  return display_day(getdate($next_lesson_adding_time)) === 'Today' ? true : false;
}
// IS_TIME_TO_ADD_CHECKER

//AJAX SET ACTIVE MODE
function set_mode() {
  $user_id = intval($_POST['user_id']);
  $active_mode = $_POST['mode'];
  carbon_set_user_meta( $user_id, 'mode', $active_mode );
}
add_action('wp_ajax_set_mode', 'set_mode'); 
//AJAX SET ACTIVE MODE


// "ADDING NEW COURSE" TIMER
function set_adding_timeout($user_id){

  $user_timeRange = strtotime(carbon_get_user_meta($user_id,'mrng_practice'))
  ? strtotime(carbon_get_user_meta($user_id,'mrng_practice'))+$timeZone_msc
  : strtotime(carbon_get_user_meta(1,'mrng_practice'))+$timeZone_msc;

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
  $post_id = intval($_POST['post_id']);

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

  set_timers($my_post_id,$user_id);
  if($type === 'with-teacher'){
    notify_manager($my_post_id); //not done yet!
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
add_action('wp_ajax_lesson_passed', 'lesson_passed'); 
// AJAX FUNCTION TO MARK LESSON AS COMPLETED


// UPDATE USER AVATAR
function ava_file_upload(){
  check_ajax_referer( 'uplfile', 'nonce' );
  $user_id = intval($_POST['user_id']);
  if( empty($_FILES) )
    wp_send_json_error( 'Файлов нет...' );

  $sizedata = getimagesize( $_FILES['upfile']['tmp_name'] );
  $max_size = 2000;
  
  if( $sizedata[0]/*width*/ > $max_size || $sizedata[1]/*height*/ > $max_size )
		wp_send_json_error( __('Картинка не может быть больше чем '. $max_size .'px в ширину или высоту...','km') );
  
  require_once ABSPATH . 'wp-admin/includes/image.php';
  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/media.php';

  add_filter( 'upload_mimes', function( $mimes ){
		return [
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif'          => 'image/gif',
			'png'          => 'image/png',
		];
	} );

	$uploaded_imgs = array();
  
	foreach( $_FILES as $file_id => $data ){
    $attach_id = media_handle_upload( $file_id, 0 );

		// ошибка
		if( is_wp_error( $attach_id ) ) {
			$uploaded_imgs[] = 'Ошибка загрузки файла `'. $data['name'] .'`: '. $attach_id->get_error_message();
    } else {
      $uploaded_imgs[] = wp_get_attachment_url( $attach_id );
    }
	}
  carbon_set_user_meta($user_id,'avatar', $uploaded_imgs);
	wp_send_json_success( $uploaded_imgs );
}
add_action('wp_ajax_ava_file_upload', 'ava_file_upload'); 
// UPDATE USER AVATAR


// UPDATE USER INFO
function update_profile() {
  $user_id = intval($_POST['user_id']);
  $type = $_POST['type'];
  $value = htmlspecialchars($_POST['val']);

  if($type === 'first_name') {
    $userdata = [
      'ID' => $user_id,
      'first_name' => $value,
    ];
    wp_update_user( $userdata );
    print_r($userdata);
  } else {
    carbon_set_user_meta( $user_id, $type, $value);
  }
}
add_action('wp_ajax_update_profile', 'update_profile'); 
// UPDATE USER INFO

function notify_manager() { return false; }

function finish_course($post_id) {
  wp_set_post_terms( $post_id, 'finished', 'course_status', false );
}

function set_timers( $post_id, $user_id)  {
  $active_mode = carbon_get_user_meta($user_id, 'mode');
  $timer = get_schedule( $active_mode, $user_id );
  fill_lesson_cf( $timer, $post_id );
}

function fill_lesson_cf ( $timers, $post_id ) {
  foreach ($timers as $key=>$timer) {
    carbon_set_post_meta( $post_id, 'timecode_'.($key+1), $timer );
  }
}

// GET USER SPECIFIED TIME BY ID
function get_schedule($active_mode,$user_id) {
  
  global $now_incTZ;
  global $_day;
  global $timeZone_msc;

  $user_timeRange = [
    strtotime(carbon_get_user_meta($user_id,'mrng_practice'))
    ? strtotime(carbon_get_user_meta($user_id,'mrng_practice'))+$timeZone_msc
    : strtotime(carbon_get_user_meta(1,'mrng_practice'))+$timeZone_msc,

    strtotime(carbon_get_user_meta($user_id,'evng_practice'))
    ? strtotime(carbon_get_user_meta($user_id,'evng_practice'))+$timeZone_msc
    : strtotime(carbon_get_user_meta(1,'evng_practice'))+$timeZone_msc
  ];

	$schedules['Light'] = [
    $now_incTZ + $_day * 1 - ($now_incTZ - $user_timeRange[1]),
    $now_incTZ + $_day * 4 - ($now_incTZ - $user_timeRange[1])
  ];
	$schedules['Medium'] = [
    $now_incTZ + $_day * 1 - ($now_incTZ - $user_timeRange[0]),
    $now_incTZ + $_day * 3 - ($now_incTZ - $user_timeRange[1]),
    $now_incTZ + $_day * 5 - ($now_incTZ - $user_timeRange[1])
  ];
	$schedules['Fire'] = [
    $now_incTZ + 5*60*60,
    $now_incTZ + $_day * 1 - ($now_incTZ - $user_timeRange[1]),
    $now_incTZ + $_day * 7 - ($now_incTZ - $user_timeRange[1])
  ];

  $timer = $schedules[$active_mode];

  return $timer;
}

function get_passed_lessons_arr($user_id){
  $args = array(
    'post_type'  => 'lessons',
    'author'     => $user_id,
    'course_status'   => 'finished',
);
wp_reset_postdata();
return count(get_posts($args));
}

## Оставляет пользователя на той же странице при вводе неверного логина/пароля в форме авторизации wp_login_form() //wp-kama
add_action( 'wp_login_failed', 'my_front_end_login_fail' );
function my_front_end_login_fail( $username ) {
	$referrer = $_SERVER['HTTP_REFERER'];  // откуда пришел запрос

	// Если есть referrer и это не страница wp-login.php
	if( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
		wp_redirect( add_query_arg('login', 'failed', $referrer ) );  // редиркетим и добавим параметр запроса ?login=failed
		exit;
	}
}

add_action('wp_ajax_finish_reg', 'finish_reg'); 
function finish_reg(){
  $user_id = intval($_POST['user_id']);
  $role = get_userdata($user_id)->roles[0];

  if( $role === 'need-confirm' ) {

    $def_ava = '/wp-content/plugins/ultimate-member/assets/img/default_avatar.jpg';
    carbon_set_user_meta($user_id,'avatar', $def_ava);
    
    $def_free = (carbon_get_theme_option('free_courses') ) &&
    !empty(carbon_get_theme_option('free_courses')
    ) ?
    carbon_get_theme_option('free_courses')
    :
    $def_free = 0;
    carbon_set_user_meta($user_id,'new_lessons_left', $def_free);

    $wp_user_object = new WP_User($user_id);
    $wp_user_object->set_role( 'subscriber' );
  }
}