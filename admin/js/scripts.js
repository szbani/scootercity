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

//multiple image
function imageZone() {
    // document
    //     .getElementById("pro-image")
    //     .addEventListener("change", readImage, false);
    $('#pro-image').on('change',function(){
        readImage();
    });
    $(".preview-images-zone").sortable();

    $(document).on("click", ".image-cancel", function () {
        let no = $(this).data("no");
        $(".preview-image.preview-show-" + no).remove();
        $("#input-"+no).remove();
    });
};

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
                    '<div id="'+
                     num
                    +'"class="preview-image preview-show-' +
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
            picReader.addEventListener('loadend',function(event){

                var blob = dataURItoBlob(event.target.result);

                var fd = new FormData();
                fd.append("file",blob,"tempFile-"+num);
                var temp = new DataTransfer();
                temp.items.add(fd.get("file"));
                
                var input = document.createElement('input');
                input.type = "file";
                input.name = "images[]";
                input.id = num;
                input.hidden = true;
                input.files = temp.files;

                var t =num.toString();
                output.find("div")[(num-1)*3].append(input);
            })
            picReader.readAsDataURL(file);
        }
        
        $("#pro-image").val("");
    } else {
        console.log("Browser not support");
    }
}

function dataURItoBlob(dataURI) {

    var byteString = atob(dataURI.split(',')[1]);

    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    var ab = new ArrayBuffer(byteString.length);
    var dw = new DataView(ab);
    for(var i = 0; i < byteString.length; i++) {
        dw.setUint8(i, byteString.charCodeAt(i));
    }

    return new Blob([ab], {type: mimeString});
}