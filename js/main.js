const $ = jQuery;

const $post_id = $('footer').data('post_id');
const $user_id = $('footer').data('user_id');

let file;

function showText(e) {
  $(e).toggleClass('active');
  $('#text').toggle(300);
  $('#text+.player_wrap').toggleClass('col-12 col-md-6 sticky');
  $(e)
    .find('span')
    .text($(e).hasClass('active') ? 'Hide text' : 'Show text');
}

function toggleVideo(e) {
  $(e).toggleClass('_second');
  $(e).hasClass('_second')
    ? $(e).find('span').text('Show first video')
    : $(e).find('span').text('Show second video');

  let _video = $(e).hasClass('_second') ? yt_code_2 : 1;

  new_video(_video);
}

$(document).ready(function () {
  $('[data-toggle="popover"]').popover();

  $('[data-toggle="tooltip"]').tooltip();

  if (window.location.href.indexOf('#signup') != -1) {
    $('#signup').modal('show');
  }
  if (window.location.href.indexOf('#login') != -1) {
    $('#login').modal('show');
  }
  if (window.location.href.indexOf('#reset') != -1) {
    $('#reset').modal('show');
  }

  $('#course_filter').submit(function () {
    var filter = $(this);
    console.log(JSON.stringify(filter.serializeArray()));
    $.post({
      url: '/wp-admin/admin-ajax.php',
      data: {
        action: 'course_filter',
        post_id: $post_id,
        data: JSON.stringify(filter.serializeArray()),
      },
      beforeSend: function (xhr) {
        filter.find('input[type="submit"]').val('Progress...'); // изменяем текст кнопки
      },
      success: function (data) {
        filter.find('input[type="submit"]').val('Show lessons'); // возвращаеи текст кнопки
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

  $('#_file').change(function () {
    $('#ava_img')[0].src = (window.URL ? URL : webkitURL).createObjectURL(
      this.files[0]
    );
    $('#ava_img')[0].src = (window.URL ? URL : webkitURL).createObjectURL(
      this.files[0]
    );
    file = this.files[0];
  });

  $('#_label').click(function () {
    $(this).hide();
    $('#_save').show();
  });
  $('#_save').click(function (e) {
    event.stopPropagation();
    e.preventDefault();
    $(this).hide();
    $('#_label').show();

    if (typeof file == 'undefined') return;

    let nonce = $(this).data('hash');
    let data = new FormData();
    data.append('fileName', file);
    data.append('action', 'ava_file_upload');
    data.append('nonce', nonce);
    data.append('user_id', $user_id);

    $.ajax({
      url: '/wp-admin/admin-ajax.php',
      type: 'POST',
      processData: false,
      contentType: false,
      dataType: 'json',
      data: data,
      success: function (respond, status, jqXHR) {
        if (typeof respond.error === 'undefined') {
          // выведем пути загруженных файлов в блок '.ajax-reply'
          var files_path = respond.files;
          var html = '';
          $.each(files_path, function (key, val) {
            html += val + '<br>';
          });
          console.log(respond + ' - html');
        } else {
          console.log('ОШИБКА: ' + respond.data);
        }
      },
      error: function (jqXHR, status, errorThrown) {
        console.log('ОШИБКА: ' + jqXHR);
      },
    });
  });

  $('[data-new="true"]').click(function () {
    $(this).parents('._not_set').hide();
    $(this).parents('._not_set').next('._set').show();
    $(this).parents('._not_set').next('._set').find('.edit').click();
  });

  $('#configs')
    .find('.edit')
    .click(function () {
      let type = $(this).data('type');
      $(this).parent().next('.invalid-feedback').hide();
      if ($(this).hasClass('active')) {
        let text = $(this).prev('input').val();

        if (validateField(text, type, this) !== true) {
          $(this).parent().next('.invalid-feedback').show();
          return false;
        }

        $(this).removeClass('active');
        $(this)
          .prev('input')
          .replaceWith('<span>' + text + '</span>');
        $(this).html(
          '<svg viewBox="0 0 492.49284 492" width="0.8em" xmlns="http://www.w3.org/2000/svg"><path fill="#007bff" d="m304.140625 82.472656-270.976563 270.996094c-1.363281 1.367188-2.347656 3.09375-2.816406 4.949219l-30.035156 120.554687c-.898438 3.628906.167969 7.488282 2.816406 10.136719 2.003906 2.003906 4.734375 3.113281 7.527344 3.113281.855469 0 1.730469-.105468 2.582031-.320312l120.554688-30.039063c1.878906-.46875 3.585937-1.449219 4.949219-2.8125l271-270.976562zm0 0" /><path fill="#007bff" d="m476.875 45.523438-30.164062-30.164063c-20.160157-20.160156-55.296876-20.140625-75.433594 0l-36.949219 36.949219 105.597656 105.597656 36.949219-36.949219c10.070312-10.066406 15.617188-23.464843 15.617188-37.714843s-5.546876-27.648438-15.617188-37.71875zm0 0" /><!-- Icons made by Pixel perfect (https://www.flaticon.com/authors/pixel-perfect) for Flaticon (https://www.flaticon.com/) --></svg>&#160;Edit'
        );

        save_data(type, text, false);
      } else {
        $(this).addClass('active');
        $(this).html('save');
        let text = $(this).prev('span').text();
        $(this)
          .prev('span')
          .replaceWith(
            '<input type="text" value="" placeholder="' + text + '" />'
          );
      }
    });

  let $first = $($('.timer_input')[0]).find('input');

  let $second = $($('.timer_input')[1]).find('input');

  if ($first.length) {
    $first.val(set_pmam($first.val()));
    $second.val(set_pmam($second.val()));
  }

  $first.timepicker({
    timeFormat: 'h:mm a',
    minTime: '5:00am',
    maxTime: $second.val() === '' ? '11:30pm' : $second.val(),
    showDuration: true,
    dynamic: false,
  });

  $('.timer_input')
    .find('input')
    .click(function () {
      let $this = $(this);

      $('.ui-timepicker-viewport').click(function () {
        $this.addClass('onload');
        $this.attr('disabled', 'disabled');
        $second.addClass('onload');

        setTimeout(() => {
          $first.timepicker(
            'option',
            'maxTime',
            $second.val() === '' ? '11:30pm' : $second.val()
          );

          $this.removeClass('onload');
          $this.removeAttr('disabled');

          $second.removeClass('onload');
          $second.removeAttr('disabled');

          $second.timepicker(
            'option',
            'minTime',
            $first.val() === '' ? '06:00am' : $first.val()
          );
          $second.timepicker({
            timeFormat: 'h:mm a',
            minTime: $first.val() === '' ? '06:00am' : $first.val(),
            maxTime: '11:30pm',
            showDuration: true,
            dynamic: false,
          });

          let val = $this.val();
          val =
            val.indexOf('pm') !== -1
              ? get_pm(val.replace(/\s\w\w/, ''))
              : val.replace(/\s\w\w/, '');

          let type = $this.parents('.timer_input').data('type');

          save_data(type, val, true);
        }, 1000);
      });
    });
});

function set_pmam(val) {
  if (val !== '') {
    if (val.indexOf('m') === -1) {
      val = val.split(':');
      is_pm = parseInt(val[0]) > 12 ? true : false;
      val[0] = is_pm ? parseInt(val[0]) - 12 : parseInt(val[0]);
      val = val.join(':');
      val = is_pm ? val + ' pm' : val + ' am';
    }
  }
  return val;
}

function get_pm(val) {
  val = val.split(':');
  val[0] = parseInt(val[0]) === 12 ? parseInt(val[0]) : parseInt(val[0]) + 12;
  return val.join(':');
}

function preview_video(e, id) {
  e.appendChild(createIframe(id));
  e.querySelector('img').remove();
  e.removeAttribute('onclick');
  e.querySelector('iframe').style.width = '100%';
  e.querySelector('iframe').style.height = e.offsetWidth * 0.55 + 'px';
}

//// for videos
function createIframe(id) {
  let iframe = document.createElement('iframe');

  iframe.setAttribute('allowfullscreen', '');
  iframe.setAttribute('allow', 'autoplay');
  iframe.setAttribute('src', generateURL(id));

  return iframe;
}
function generateURL(id) {
  let query = '?rel=0&showinfo=0&autoplay=1';
  return 'https://www.youtube.com/embed/' + id + query;
}
//// for videos

function go_third(e) {
  const parents = [
    $("[data-type='mrng_practice']").find('input').val(),
    $("[data-type='evng_practice']").find('input').val(),
  ];
  if (parents[0] !== '' && parents[1] !== '') {
    third_step();
  }
}

function validateField(text, type) {
  return type === 'notify_email' ? validateEmail(text) : validateText(text);
}

function validateText(text) {
  if (text != '') {
    return true;
  } else {
    return false;
  }
}

function validateEmail(text) {
  var pattern = /^[a-z0-9._-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;

  if (text != '') {
    if (text.search(pattern) == 0) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

function save_data(type, $val, sche) {
  $.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      action: 'update_profile',
      type: type,
      val: $val,
      user_id: $user_id,
      sche: sche,
    }, // можно также передать в виде объекта
    success: function (data) {
      console.log(data);
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    },
  });
}

function file_upload(type, val) {
  $.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      action: 'file_upload',
      user_id: $user_id,
    }, // можно также передать в виде объекта
    success: function (data) {
      console.log(data);
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    },
  });
}

function finish_reg($user_id) {
  $.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      action: 'finish_reg',
      user_id: $user_id,
    }, // можно также передать в виде объекта
    success: function (data) {
      console.log(data);
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    },
  });
}

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
  $('#proofModal').modal('show');
  let $target_post_id = $(e).parents('.card').attr('id');
  $('#proofModal button[data-action="start_lesson"]').click(function () {
    start_course($target_post_id, $user_id, e);
  });
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

function push_hash(e) {
  window.location = $(e).data('target');
}

function changeModals(e) {
  $(e).parents('.modal').modal('hide');
  let new_modal = $(e).data('modalto');
  $(e)
    .parents('.modal')
    .siblings('#' + new_modal)
    .modal('show');
  window.location = '#' + new_modal;
}

function set_mode(e, $user_id) {
  let mode = e.getAttribute('data-mode');
  let new_step = location.href.indexOf('reg-intro') !== -1 ? true : false;

  $.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      action: 'set_mode',
      user_id: $user_id,
      mode: mode,
      sche: !new_step,
    },
    success: function (data) {
      if (new_step) {
        second_step();
      } else {
        location.reload();
      }
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    },
  });
}

function log_out() {
  $.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      action: 'log_out',
    },
    success: function (data) {
      location.reload();
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    },
  });
}

function os_toggle() {
  console.log('handlerr is here');
  OneSignal.push(function () {
    OneSignal.showNativePrompt();
  });
}

OneSignal.push(function () {
  console.log($user_id);
  $os_user_id = '';

  OneSignal.getNotificationPermission().then(function (permission) {
    if (permission === 'granted') {
      OneSignal.getUserId().then(function (userId) {
        $os_user_id = userId;
        console.log('ok', permission, $os_user_id);

        $.ajax({
          url: '/wp-admin/admin-ajax.php',
          type: 'POST',
          data: {
            action: 'update_os_cf',
            os_user_id: $os_user_id,
            user_id: $user_id,
          },
          success: function (data) {
            console.log(data);
          },
          error: function (errorThrown) {
            console.log(errorThrown);
          },
        });
        // запускаю аякс для проверки наличия данного юзер_ид в массиве юзер_кф_ос
        // и вешаю актив на псевдоселекторы
      });
      document.querySelector('.pseudocheckbox').classList.add('active');
    } else if (permission === 'denied') {
      $('#configs').find('.pseudocheckbox').popover();
    } else {
      console.log('SCHAßE! Permission:', permission);
      os_toggle();
    }
  });
});
