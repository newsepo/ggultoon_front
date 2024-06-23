$(document).ready(function () {
 $(".lib_tab_top .tab_wrap .tab_item").click(function () {

  $(".lib_tab_top .tab_wrap .tab_item").removeClass("active");
  $(this).addClass("active");

  library.reset();
  if ($(this).hasClass('recent')) {
   location.replace('/my/lib/view');
  } else if ($(this).hasClass('rent')) {
   location.replace('/my/lib/rent');
  } else if ($(this).hasClass('have')) {
   location.replace('/my/lib/have');
  } else if ($(this).hasClass('like')) {
   location.replace('/my/lib/favorite');
  }
 });
});
