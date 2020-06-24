<?php
add_action('wp_ajax_update_profile', 'update_profile'); 
add_action('wp_ajax_ava_file_upload', 'ava_file_upload'); 
add_action('wp_ajax_set_mode', 'set_mode'); 
add_action('wp_ajax_update_os_cf', 'update_os_cf'); 
add_action('wp_ajax_finish_reg', 'finish_reg'); 

function update_profile() {
  $user_id = intval($_POST['user_id']);
  $type = $_POST['type'];
  $sche = $_POST['sche'];
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
    if($sche){
      update_schedulers($user_id);
    }
  }
}

function ava_file_upload(){
    check_ajax_referer( 'uplfile', 'nonce' );
    $user_id = intval($_POST['user_id']);
    if( empty($_FILES) )
      wp_send_json_error( 'No files...' );
  
    $sizedata = getimagesize( $_FILES['upfile']['tmp_name'] );
    $max_size = 2000;
    
    if( $sizedata[0]/*width*/ > $max_size || $sizedata[1]/*height*/ > $max_size )
          wp_send_json_error( __('Max width/height '. $max_size .'px ','km') );
    
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
              $uploaded_imgs[] = 'File uploading error... `'. $data['name'] .'`: '. $attach_id->get_error_message();
      } else {
        $uploaded_imgs[] = wp_get_attachment_url( $attach_id );
      }
      }
    carbon_set_user_meta($user_id,'avatar', $uploaded_imgs);
      wp_send_json_success( $uploaded_imgs );
}

function set_mode() {
  $user_id = intval($_POST['user_id']);
  $active_mode = $_POST['mode'];
  $sche = $_POST['sche'];
  
  carbon_set_user_meta( $user_id, 'mode', $active_mode );
  if($sche){
    update_schedulers($user_id);
  }
}

function update_os_cf() {
  $user_id = $_POST['user_id'];
  $os_user_id = $_POST['os_user_id'];

  $os_list = carbon_get_user_meta( $user_id,'onesignal_ids');
  
  $os_list = implode(",",array_unique(explode(",", $os_list.','.$os_user_id)));
  $os_list = carbon_set_user_meta( intval($user_id),'onesignal_ids',trim($os_list,','));

  echo 'os '.$os_list;
  return true;
      // на сервере:
      // если есть - возвращаю "гуд"
      // если нет - добавляю к данному юзеру
}

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
?>
