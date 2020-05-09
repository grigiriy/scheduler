var $ = jQuery;

$(document).ready(function () {
  $('input.timepicker').timepicker({
    timeFormat: 'h:mm a',
    minTime: '6:00am',
    maxTime: '11:30pm',
    showDuration: true,
  });
});
