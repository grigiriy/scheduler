<?php
add_action('wp_ajax_add_to_favor', 'add_to_favor'); 
add_action('wp_ajax_remove_favor', 'remove_favor'); 

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

function add_to_favor(){
    $post_id = intval($_POST['post_id']);
    $user_id = intval($_POST['user_id']);
  
    $fav = carbon_get_user_meta( intval($user_id), 'favor_lessons' );
    $arr = implode(",",array_unique(explode(",", $fav.','.$post_id)));
    carbon_set_user_meta( intval($user_id), 'favor_lessons', trim($arr,',') );
  
    return true;
}

?>