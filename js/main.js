const $ = jQuery;

const $post_id = $('footer').data('post_id');
const $user_id = $('footer').data('user_id');

function showText(e) {
  $(e).toggleClass('active');
  $('#text').toggle(300);
  $('#player').toggleClass('col-6');
}

$(document).ready(function () {
  $('input.timepicker').timepicker({
    timeFormat: 'h:mm a',
    minTime: '6:00am',
    maxTime: '11:30pm',
    showDuration: true,
  });

  $('[data-toggle="popover"]').popover();

  $('#course_filter').submit(function () {
    var filter = $(this);
    console.log(JSON.stringify(filter.serializeArray()));
    $.post({
      url: '/wp-admin/admin-ajax.php',
      data: {
        action: 'myfilter',
        post_id: $post_id,
        data: JSON.stringify(filter.serializeArray()),
      },
      beforeSend: function (xhr) {
        filter.find('input[type="submit"]').val('Progress...'); // изменяем текст кнопки
      },
      success: function (data) {
        filter.find('input[type="submit"]').val('Show lessons!'); // возвращаеи текст кнопки
        $('#courses_wrapper').html(data);
        rerenderImages();
      },
      error: function (errorThrown) {
        filter.find('input[type="submit"]').val('error...');
        console.log(errorThrown);
      },
    });
    return false;
  });
});

function to_favorite_before(e) {
  let $target_post_id = $(e).parents('.card').attr('id');
  let __action = $(e).hasClass('active') ? 'remove_favor' : 'add_to_favor';
  to_favorite($target_post_id, $user_id, __action, e);
}

function to_favorite($target_post_id, $user_id, __action, e) {
  $.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      action: __action,
      post_id: $target_post_id,
      user_id: $user_id,
    }, // можно также передать в виде объекта
    success: function (data) {
      $(e).toggleClass('active');
      console.log(data);
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    },
  });
}

function start_course_before(e) {
  let $target_post_id = $(e).parents('.card').attr('id');
  start_course($target_post_id, $user_id, e);
}

function start_course($target_post_id, $user_id, e) {
  $.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      action: 'add_lesson',
      post_id: $target_post_id,
      user_id: $user_id,
    },
    success: function (data) {
      window.location.href = $(e).data('href');
    },
    error: function (errorThrown) {
      console.log('error...');
    },
  });
}

function lesson_passed() {
  $.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      action: 'lesson_passed',
      post_id: $post_id,
    }, // можно также передать в виде объекта
    success: function (data) {
      console.log(data);
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    },
  });
}
