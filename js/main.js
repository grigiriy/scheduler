const $ = jQuery;

const $post_id = $('footer').data('post_id');
const $user_id = $('footer').data('user_id');

let file;

function showText(e) {
  $(e).toggleClass('active');
  $('#text').toggle(300);
  $('#player').toggleClass('col-6');
  $(e)
    .find('span')
    .text($(e).hasClass('active') ? 'Hide text' : 'Show text');
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

  $('.timer_input')
    .find('input')
    .click(function () {
      $(this).siblings('.edit').fadeIn(100);
    });

  $('.timer_input')
    .find('.edit')
    .click(function () {
      let val = $(this).siblings('input').val();

      val =
        val.indexOf('pm') !== -1
          ? get_pm(val.replace(/\s\w\w/, ''))
          : val.replace(/\s\w\w/, '');

      function get_pm(val) {
        val = val.split(':');
        val[0] = parseInt(val[0]) + 12;
        return val.join(':');
      }

      let type = $(this).parents('.timer_input').data('type');

      save_data(type, val);
      $(this).text('Success!');
      setTimeout(() => $(this).fadeOut(300), 500);
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

        save_data(type, text);
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
});

function go_third(e) {
  const parents = [
    $("[data-type='mrng_practice']").find('input').val(),
    $("[data-type='evng_practice']").find('input').val(),
  ];
  if (parents[0] !== '' && parents[1] !== '') {
    $('#element').popover('disable');
    third_step();
  } else {
    $('#element').popover('enable');
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
  var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;

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

function save_data(type, val) {
  $.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      action: 'update_profile',
      type: type,
      val: val,
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

function changeModals(e) {
  $(e).parents('.modal').modal('hide');
  $(e).parents('.modal').siblings('.modal').modal('show');
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

// function validatePhone(_this) {
//   var listCountries = $.masksSort(
//     $.masksLoad(
//       'https://cdn.rawgit.com/andr-04/inputmask-multi/master/data/phone-codes.json'
//     ),
//     ['#'],
//     /[0-9]|#/,
//     'mask'
//   );
//   var maskOpts = {
//     inputmask: {
//       definitions: {
//         '#': {
//           validator: '[0-9]',
//           cardinality: 1,
//         },
//       },
//       showMaskOnHover: false,
//       autoUnmask: true,
//       clearMaskOnLostFocus: false,
//     },
//     match: /[0-9]/,
//     replace: '#',
//     listKey: 'mask',
//     onMaskChange: function (maskObj, completed) {
//       if (completed) {
//         var hint = maskObj.cc;
//         $(_this).attr('data-hint', hint);
//       }
//     },
//   };

//   $(_this, 'input[name="mode"]').change(function () {
//     $(_this).inputmask('remove');
//     $(_this).inputmasks(
//       $.extend(true, {}, maskOpts, {
//         list: listCountries,
//       })
//     );
//   });

//   return true;
// }
