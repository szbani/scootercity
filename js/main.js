var nav = new Boolean(false);

function navhide(){
  nav_check();
  $(document).scroll(function () {
    nav_check();
  });
}


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



// termekek


// function modal_c_change(szin){
//     $.ajax({
//         url:"/scootercity/parts/modal_change.php",
//         type: 'post',
//         data: {
//             prod_szin: szin
//         },
//     success: function (result) {
//         result = JSON.parse(result);
//         var mennyiseg = result.mennyiseg;
//         var kepek = result.kepek;
//         var raktar = "/scootercity/media/products/termek_";
        
//         if(mennyiseg > 2){raktar=raktar + 'ok.png';}
//         else if(mennyiseg > 0){raktar=raktar + 'some.png';}
//         else{raktar=raktar + 'cancel.png';}
//         //raktar_status
//         $('#raktar_status').attr('src', raktar);
//         $('#kepek').html(kepek);
//         $('#kepek1').html(kepek);
//         $('#kepek2').html(kepek);
//         swiper();
//         }
//     })
// }


//sidebar

$(document).ready(function (){
  $(":checkbox:not(:checked)").map(function () { 
      var search = sessionStorage.getItem(this.value);
      if(search == "checked"){
          this.checked = true;
      }
  });
  $(":checkbox").on("change", function () {
      var search = $('checkbox').map(function () {
          return this;
        });
      if(search.checked == true){
          sessionStorage.setItem(this.value, 'checked');
      }
      else{
          sessionStorage.setItem(this.value,null);
      }
  });
});

$(function() {

  $(".form-check-input").on("change", function() {
      var search = $(".form-check-input:checked").map(function() {
          
          sessionStorage.setItem(this.value,'checked');
          return this.value;
      }).toArray();
      search = search.join("|");
      if(search != ''){
          location.search = "termek="+search;
      }else{
          location.search = ''; 
      }
  });
});

