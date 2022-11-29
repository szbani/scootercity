var nav = new Boolean(false);

$(document).ready(function(){
  nav_check();
})

$(function () {
    $(document).scroll(function () {
      nav_check();
    });
  });


function nav_check(){
  var $nav = $(document.getElementById("navbar"));
  var height = screen.height * 0.15;
  if($(this).scrollTop() < height && !nav){
    $nav.toggle('scrolled',$(this).scrollTop() > height);
    nav = true;
  }else if($(this).scrollTop() > height && nav){
    $nav.toggle('scrolled',$(this).scrollTop() < height);
    nav = false;
  }

}
