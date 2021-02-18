// 01. Switchery  js
// 02. calling timer js
// 03 .Add class to body for identify this is application page
// 04. Mobile responsive screens

(function($) {
 "use strict";
 /*=====================
 02 . calling timer js
 ==========================*/
 var timer = new Timer();
 timer.start();
 timer.addEventListener('secondsUpdated', function(e) {
  $('#basicUsage').html(timer.getTimeValues().toString());
});
 timer.addEventListener('secondsUpdated', function(e) {
  $('#basicUsage3').html(timer.getTimeValues().toString());
});
 timer.addEventListener('secondsUpdated', function(e) {
  $('#basicUsage2').html(timer.getTimeValues().toString());
});


 
})(jQuery);
function toggleFullScreen() {    
  $('#videocall').toggleClass("active");
}

function removedefault(){
       $('body').removeClass("sidebar-active");
       $('.app-sidebar').removeClass("active");
}
