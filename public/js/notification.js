/**
 * Created by Emilien on 07/12/2017.
 */
$(document).ready(function () {

  var notif = $('.notifText').text();

  notif === '' ?  $('.notification').remove() : null;



  $('#closeNotif').click(function () {
     $('.notification').remove();
})



});