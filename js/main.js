var $ = jQuery;

$(document).ready(function () {
  $('input.timepicker').timepicker({
    timeFormat: 'h:mm a',
    minTime: '6:00am',
    maxTime: '11:30pm',
    showDuration: true,
  });
});

function showText(e) {
  $(e).toggleClass('active');
  $('#text').toggle(300);
  $('#player').toggleClass('col-6');
}

$(function () {
  $('[data-toggle="popover"]').popover();
});
