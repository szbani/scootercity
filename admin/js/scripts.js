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

function del_btn(id) {
  document.getElementById("del_id").innerHTML = id;
  document.getElementById("del_hidden").value = id;
}

//toast
function showToast(id) {
  var toastLiveExample = document.getElementById(id);
  var toast = new bootstrap.Toast(toastLiveExample);
  toast.show();
}

var toastnumber = 0;
function createToast(title, messages, success) {
  var text = "<strong>";
  $.each(messages, function (key, value) {
    if (key != 0) text += "<br>";
    text += value;
  });
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
      '<input class="form-control" id="inputTulajdonsag" type="text" name="tul-nev[]">' +
      "</div>" +
      '<div class="col-4">' +
      '<input class="form-control" id="inputTulajdonsag" type="text" name="tul-ertek[]">' +
      "</div>" +
      '<div class="col-4">' +
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

//multiple image
function imageZone() {
  // document
  //     .getElementById("pro-image")
  //     .addEventListener("change", readImage, false);
  $("#pro-image").on("change", function () {
    readImage();
  });
  $(".preview-images-zone").sortable();

  $(document).on("click", ".image-cancel", function () {
    let no = $(this).data("no");
    $(".preview-image.preview-show-" + no).remove();
    $("#input-" + no).remove();
  });
}

var num = 0;
function readImage() {
  if (window.File && window.FileList && window.FileReader) {
    var files = event.target.files; //FileList object
    var output = $(".preview-images-zone");

    for (i = 0; i < files.length; i++) {
      var file = files[i];

      if (!file.type.match("image")) continue;

      var picReader = new FileReader();
      picReader.addEventListener("load", function (event) {
        // console.log(output.children().length);

        var picFile = event.target;
        var html =
          '<div id="' +
          num +
          '"class="preview-image preview-show-' +
          num +
          '">' +
          '<div class="image-cancel" data-no="' +
          num +
          '">x</div>' +
          '<div class="image-zone"><img id="pro-img-' +
          num +
          '"src="' +
          picFile.result +
          '"></div>';
        output.append(html);

        num = num + 1;
      });
      picReader.addEventListener("loadend", function (event) {
        var blob = dataURItoBlob(event.target.result);

        var fd = new FormData();
        fd.append("file", blob, "tempFile-" + num);
        var temp = new DataTransfer();
        temp.items.add(fd.get("file"));

        var input = document.createElement("input");
        input.type = "file";
        input.name = "images[]";
        input.hidden = true;
        input.files = temp.files;

        output.find("div")[(num - 1) * 3].append(input);
      });
      picReader.readAsDataURL(file);
    }

    $("#pro-image").val("");
  } else {
    console.log("Browser not support");
  }
}

function dataURItoBlob(dataURI) {
  var byteString = atob(dataURI.split(",")[1]);

  var mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];

  var ab = new ArrayBuffer(byteString.length);
  var dw = new DataView(ab);
  for (var i = 0; i < byteString.length; i++) {
    dw.setUint8(i, byteString.charCodeAt(i));
  }

  return new Blob([ab], { type: mimeString });
}

function getBase64Image(path) {
  var img = new Image();
  img.src = path;
  var canvas = document.createElement("canvas");
  canvas.width = img.width;
  canvas.height = img.height;
  var ctx = canvas.getContext("2d");
  ctx.drawImage(img, 0, 0);
  var dataURL = canvas.toDataURL("image/jpg");
  return dataURL;
}

function resetPics() {
  $(".preview-images-zone").empty();
  num = 0;
}
