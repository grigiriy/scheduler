<?php
add_action('send_notify', 'send_notify_fun',10,2);


function set_scheduleMail($timer,$user_id,$post_id) {
  // if( !wp_next_scheduled('send_notify')

  wp_clear_scheduled_hook('send_notify', [$post_id,$user_id] );

  foreach($timer as $key=>$_timer){
    wp_schedule_single_event( $_timer, 'send_notify', [$post_id,$user_id] );
  }
  return true;
}

function set_text($post_id){
    switch ($post_id) {
      case 'greetings':
        $title = 'Hello';
        $text = 'Nice to meet you!';
        $link = 'https://snackers.ru/account/';
        $link_title = 'Start learning';
        break;
      case 'reminder':
        $title = 'Hey there! It`s time to learn!';
        $text = 'Are you ready to repeat level up?';
        $link = get_permalink($post_id);
        $link_title = get_the_title($post_id);
        break;
      case 'starter':
        $title = 'Hey there! It`s a new lesson day!';
        $text = 'Greetings! You can chose a new lesson today!';
        $link = 'https://snackers.ru/catalog/';
        $link_title = 'Start learning';
        break;
      case 'finish':
        $title = 'Great! You`ve finish with this lesson!';
        $text = 'You can always repeat it if you want.';
        $link = 'https://snackers.ru/account/passed/';
        $link_title = 'Your archive';
        break;
    }
    return [
      'title'=> $title,
      'text'=> $text,
      'link'=> $link,
      'link_title'=> $link_title
  ];
}


function send_notify_fun($post_id,$user_id) {
    $ids = carbon_get_user_meta($user_id,'onesignal_ids');
    $recepient = carbon_get_user_meta($user_id,'notify_email') ? carbon_get_user_meta($user_id,'notify_email') : get_user_data($user_id)->user_email;
    $data = set_text($post_id);
    if($ids){
        sendPush($ids,$data['title'],$data['text'],$data['link']);
    }
    sendEmail($recepient,$data['title'],$data['text'],$data['link'],$data['link_title']);
    return true;
}


function sendEmail($recepient,$title,$text,$link,$link_title) {
  
    $headers = ['Content-type: text/html; charset=utf-8','From: Happy English <notify@snackers.ru>'];
  
    
    $post_header = $title;
    $post_content = '<html><head></head><body><h3>'.$title.'</h3><p>'.$text.'<a href="'.$link.'">'.$link_title.'</a>".</p></body></html>';
  
    wp_mail($recepient, $post_header, $post_content, $headers);
  }
  
  function sendPush($ids,$title,$text,$link) {
  
    $ids = explode(",", 
      $ids
    );
  
    $content = array(
        "en" => $title
    );
    $fields = array(
        'app_id' => "c511d27e-186f-48ed-b001-560c997c2387",
        // 'included_segments' => array(
        //     'All'
        // ),
        'include_player_ids' => $ids,
        'contents' => $content,
    );
    
    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic NTNmNTU0OTUtMThkZi00YmI5LTg3ZTctMTFhYjA1YmJlNjY4'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

?>