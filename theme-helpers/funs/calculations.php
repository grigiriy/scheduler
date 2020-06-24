<?php
function is_paid($user_id){
    if (carbon_get_theme_option( 'teacher' )) {
      return !empty(carbon_get_user_meta( $user_id, 'new_lessons_left' )) ? carbon_get_user_meta( $user_id, 'new_lessons_left' ) : false;
    } else {
      return true;
    }
  }
function is_post_exist($parent,$author){
    $posts = get_posts([
      'post_type'  => 'lessons',
      'author'=>$author,
      'post_parent'=>$parent
    ]);
    wp_reset_postdata();
    return count($posts);
  }
function is_time_to_add($next_lesson_adding_time){
    global $now_incTZ;
    return $next_lesson_adding_time <= $now_incTZ;
}
function set_timers( $post_id, $user_id, $update)  {
    $timer = get_schedule( $user_id, $update );
    fill_lesson_cf( $timer, $post_id );
    set_scheduleMail($timer,$user_id,$post_id);
}
function update_schedulers($user_id){
    $list = get_posts([
        'post_type'  => 'lessons',
        'author'=> $user_id,
    ]);
    foreach( $list as $_post ){
        set_timers($_post->ID,$user_id,get_the_time('U',$_post->ID));
    }
}
function get_schedule( $user_id, $update ) {
    $active_mode = carbon_get_user_meta($user_id, 'mode');

    global $_day;
    global $timeZone_msc;

    if($update){
        $today_midnight = $update - $update % (3600*24);
        $__now = $update;
    } else {
        global $now_incTZ;
        $today_midnight = strtotime('today midnight');
        $__now = $now_incTZ;
    }
    $mrng = explode(':',carbon_get_user_meta($user_id,'mrng_practice'));
    $evng = explode(':',carbon_get_user_meta($user_id,'evng_practice'));
    $user_timeRange = [
        ($mrng[0]*60+$mrng[1])*60,
        ($evng[0]*60+$evng[1])*60
    ];

    $schedules['Light'] = [
        $today_midnight + $_day * 1 + $user_timeRange[0],
        $today_midnight + $_day * 5 + $user_timeRange[1],
    ];

    $schedules['Medium'] = [
        $today_midnight + $_day * 1 + $user_timeRange[0],
        $today_midnight + $_day * 4 + $user_timeRange[1],
        $today_midnight + $_day * 8 + $user_timeRange[1],
    ];

    $var = ( ($today_midnight + $user_timeRange[1]) > $__now ) ? 1 : 0;

    $schedules['Fire'] = [
        $today_midnight + $user_timeRange[1],
        $today_midnight + ( $_day * (1 + $var) ) + $user_timeRange[1],
        $today_midnight + ( $_day * (8 + $var) ) + $user_timeRange[0],
    ];

    $timer = $schedules[$active_mode];

    return $timer;
}
function init_schedule($user_id){
    // if ( carbon_get_user_meta( intval($user_id), 'next_lesson' ) === '') {
      start_scheduler(intval($user_id));
    // }
    return true;
  }
  function start_scheduler($user_id){
    // global $now_incTZ;
    $now_incTZ = strtotime('today midnight');
    global $_day;
    global $timeZone_msc;
    $timeZone_msc = 0 - $timeZone_msc;
  
    $user_timeRange = strtotime(carbon_get_user_meta($user_id,'mrng_practice'))
    ? strtotime(carbon_get_user_meta($user_id,'mrng_practice'))+$timeZone_msc
    : strtotime(carbon_get_user_meta(1,'mrng_practice'))+$timeZone_msc;
  
    $next_add = $user_timeRange + $_day*2;
  
    carbon_set_user_meta( intval($user_id), 'next_lesson', $next_add );
  
    wp_schedule_event( $next_add, 'in_two_days', 'send_notify',['starter',$user_id] );
  }
?>