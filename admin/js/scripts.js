window.addEventListener("DOMContentLoaded", (event) => {
  // Toggle the side navigation
  const sidebarToggle = document.body.querySelector("#sidebarToggle");
  if (sidebarToggle) {
    // Uncomment Below to persist sidebar toggle between refreshes
    // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
    //     document.body.classList.toggle('sb-sidenav-toggled');
    // }
    sidebarToggle.addEventListener("click", (event) => {
      event.preventDefault();
      document.body.classList.toggle("sb-sidenav-toggled");
      localStorage.setItem(
        "sb|sidebar-toggle",
        document.body.classList.contains("sb-sidenav-toggled")
      );
    });
  }
});

//ajax reload

$(document).on("click", "a.link", function (e) {
  e.preventDefault();
  var pageURL = $(this).attr("href");

  history.pushState(null, "", pageURL);

  $.ajax({
    type: "GET",
    url: "pageload.php",
    data: { page: pageURL },
    dataType: "html",
    success: function (data) {
      $("#pageContent").html(data);
    },
  });
});

//modify

// function del_btn(id) {
//   document.getElementById("del_id").innerHTML = id;
//   document.getElementById("del_hidden").value = id;
// }

//toast
function showToast(id) {
  var toastLiveExample = document.getElementById(id);
  var toast = new bootstrap.Toast(toastLiveExample);
  toast.show();
}

var toastnumber = 0;
function createToast(title, messages, success) {
  var text = "<strong>";
  if (Array.isArray(messages)) {
    $.each(messages, function (key, value) {
      if (key != 0) text += "<br>";
      text += value;
    });
  }else text += messages;
  text += "</strong>";

  var type = "bg-danger";
  if (success == true) type = "bg-success";

  var toast =
    '<div id="toast-' +
    toastnumber +
    '" class="toast" role="alert" aria-live="assertive" aria-atomic="true">' +
    '<div class="toast-header ' +
    type +
    ' text-white">' +
    '<strong class="me-auto" id="succesName">' +
    title +
    "</strong>" +
    '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
    "</div>" +
    '<div class="toast-body">' +
    text +
    "</div>" +
    "</div>";
  $(".toast-container").append(toast);
  var t = new bootstrap.Toast($("#toast-" + toastnumber));
  t.show();
  toastnumber++;
}

//bs tooltips
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

//modal row management
$(document).ready(function () {
  //add row
  $(document).on("click", ".add-row", function () {
    var newRow =
      '<div class="col-16">' +
      '<div class="row g-1">' +
      '<div class="col-4">' +
      '<input class="form-control tul" type="text" name="tul-nev[]">' +
      "</div>" +
      '<div class="col-7">' +
      '<input class="form-control tul2" type="text" name="tul-ertek[]">' +
      "</div>" +
      '<div class="col-1">' +
      '<a class="del-row" data-bs-toggle="tooltip" data-bs-placement="right" title="Sor törlése">' +
      '<i class="fa-solid fa-minus fa-2x" ></i>' +
      "</a>" +
      "</div>" +
      "</div>" +
      "</div>";
    $(".modal-scroll-zone").append(newRow);
  });
  //delete row
  $(document).on("click", ".del-row", function () {
    $(this).tooltip("hide");
    $(this).closest(".col-16").remove();
  });
});

function imageZone(kepek, file) {
  var output = $("#reorderZone");
  $.each(kepek, function (index, value) {
    var html =
      '<div class="preview-image preview-show-' +
      index +
      '">' +
      '<div class="image-cancel" data-no="' +
      index +
      '">x</div>' +
      '<div class="image-zone"><img id="pro-img-' +
      index +
      '" src="../media/products/' +
      value +
      '"></div>' +
      "</div>";
    output.append(html);
  });
  output.sortable();
  $(document).on("click", ".image-cancel", function () {
    //show image delete confirm
    let no = $(this).data("no");
    $.ajax({
      type: "POST",
      url: "query/" + file,
      dataType: "JSON",
      data: { imgDelete: "", image: $("#pro-img-" + no).attr("src") },
      success: function(data){
        var title = "Sikertelen törlés";
        if (data.success) title = "Sikeres törlés";
        createToast(title, data.messages, data.success);
      }
    });
    $(".preview-image.preview-show-" + no).remove();
  });
}

function imageReader() {
  $("#pro-image").on("change", function () {
    readImage();
  });
}

var num = 0;
function readImage() {
  if (window.File && window.FileList && window.FileReader) {
    var files = event.target.files; //FileList object
    var output = $("#uploadImages");
    output.html("");

    for (i = 0; i < files.length; i++) {
      var file = files[i];

      if (!file.type.match("image")) continue;

      var picReader = new FileReader();
      picReader.addEventListener("load", function (event) {
        // console.log(output.children().length);

        var picFile = event.target;
        var html =
          '<div class="preview-image">' +
          '<div class="image-zone"><img id="pro-img-' +
          num +
          '"src="' +
          picFile.result +
          '"></div>';
        output.append(html);

        num = num + 1;
      });

      picReader.readAsDataURL(file);
    }
  } else {
    console.log("Browser not support");
  }
}

function resetPics() {
  $(".preview-images-zone").empty();
  num = 0;
}

$(document).ready(function() {
  $(document).keypress('.tul',function (e){
    $('.tul').autocomplete({
      source: function(request,response){
        $.getJSON("query/autocomplete.php", {term: request.term,auto: 'nev'},
        response);
      }
    });
  });
  // $(document).keypress('.tul2',function (e){
  //   console.log($(this).closest('.tul'));
  //   $('.tul2').autocomplete({
  //     source: function(request,response){
  //       $.getJSON("query/autocomplete.php", {term: request.term,auto: 'ertek'},
  //       response);
  //     }
  //   });
  // });
});