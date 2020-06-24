<?php
add_action('wp_ajax_course_filter', 'course_filter'); 
add_action('wp_ajax_nopriv_course_filter', 'course_filter');


function course_filter() {
    $post_id = intval($_POST['post_id']);
    $args = set_course_loop($post_id);
    $data = json_decode(stripcslashes($_POST['data']));
  
    $args['tax_query'] = [ 'relation'=>'OR' ];
  
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
  wp_die();
  }
function display_day($next_lesson_adding_time) {
    $next_formated = getdate($next_lesson_adding_time);
    global $now_incTZ;
      if($now_incTZ > $next_lesson_adding_time){
        $next = 'Today';
        goto fin;
      } else if(getdate($now_incTZ)['mday'] === $next_formated['mday']){
        $next = 'Today';
        goto fin;
      } else if($next_formated['mday'] - getdate($now_incTZ)['mday'] == 1) {
        $next = 'Tomorrow';
        goto fin;
      } else if($next_formated['mday'] - getdate($now_incTZ)['mday'] == 7){
        $next = 'In a week';
        goto fin;
      } else {
        $next = $next_formated['weekday'];
        goto fin;
      }
      $next = $next_formated['weekday'];
    fin:
    return $next;
  };
  function get_passed_lessons_arr($user_id){
    $args = array(
      'post_type'  => 'lessons',
      'author'     => $user_id,
      'course_status'   => 'finished',
  );
  wp_reset_postdata();
  return count(get_posts($args));
  }
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
      'post_type' => 'lessons',
      'numberposts' => -1
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
          $sub_args['author']=$user_id;
  
          $par_list=[];
          $cur_list = get_posts($sub_args);
          foreach ($cur_list as $post){
            array_push( $par_list, wp_get_post_parent_id( $post ) );
          }
          wp_reset_postdata();
          
          $args['post_parent']=0;
          $args['post__not_in']=$par_list;
      } else if ($this_page==='favorite') {
          $args['post__in']=$selected_posts;
      }
    }
    return ($args);
  }
  function render_courses($args) {
    $lessons_query = get_posts($args);
    if(count($lessons_query) ){
      foreach ($lessons_query as $_post) {
        set_query_var('_post',$_post);
        get_template_part('theme-helpers/template-parts/courses','card');
      } 
    } else { get_template_part('theme-helpers/template-parts/courses','empty'); }
  }
?>