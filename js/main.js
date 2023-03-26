var nav = true;
$(document).ready(function () {
    var navbar = $("#navbar");
    navcheck(navbar);
    $(document).scroll(function (e) {
        navcheck(navbar);
    });
});

function navcheck(navbar) {
    var height = screen.height * 0.1;
    if ($(this).scrollTop() < height && !nav) {
        $(navbar).toggleClass("bg-transparent", true);
        $(navbar).toggleClass("shadow-lg", false);
        nav = true;
    } else if ($(this).scrollTop() > height && nav) {
        $(navbar).toggleClass("bg-transparent", false);
        $(navbar).toggleClass("shadow-lg", true);
        nav = false;
    }
}

$(document).ready(function () {
    $("#search").keyup(function (e) {
        var search_query = $(this).val();
        if (search_query != "") {
            $.ajax({
                url: "/query/search.php",
                type: "POST",
                async: false,
                data: {
                    search: search_query,
                },
                success: function (data) {
                    $("#list").fadeIn("fast").html(data);
                },
            });
        } else {
            $("#list").fadeOut();
        }
    });
    $("#submit").on("click", function (e) {
        e.preventDefault();
        var keyword = $('#search').val();
        var pageURL = '/bolt/kereses';
        history.pushState(null, "", pageURL+'?keyword='+keyword);
        pageURL = pageURL.split('/');
        $('#sort').val('');
        $.ajax({
            type: "GET",
            url: "itemload.php",
            data: {
                page: pageURL,
                keyword: keyword,
                },
            dataType: "html",
            success: function (data) {
                $("#pageContent").html(data);
            },
        });
    });
    $("#search").keypress(function (e) {
        if (e.wich == 13) {
            var keyword = $('#search').val();
            var pageURL = '/bolt/kereses';
            history.pushState(null, "", pageURL+'?keyword='+keyword);
            pageURL = pageURL.split('/');
            $('#sort').val('');
            $.ajax({
                type: "GET",
                url: "itemload.php",
                data: {
                    page: pageURL,
                    keyword: keyword,
                },
                dataType: "html",
                success: function (data) {
                    $("#pageContent").html(data);
                },
            });
        }
    });
    $("#search").focusin(function (e) {
        if ($(this).val() != "") {
            $("#list").fadeIn();
        }
    });
    $("#search").focusout(function (e) {
        $("#list").fadeOut();
    });
});

const swiper2 = new Swiper(".swiper-thumb", {
    loop: true,
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
});
const swiper = new Swiper(".swiper-main", {
    loop: true,
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    thumbs: {
        swiper: swiper2,
    },
});

$(document).on("click", "a.link", function (e) {
    e.preventDefault();
    var pageURL = $(this).attr("href");
    history.pushState(null, "", pageURL);
    pageURL = pageURL.split('/');
    $('#sort').val('');

    $.ajax({
        type: "GET",
        url: "itemload.php",
        data: {
            page: pageURL,
            },
        dataType: "html",
        success: function (data) {
            $("#pageContent").html(data);
        },
    });
});

$('#sort').change(function (e) {
    e.preventDefault();
    if (!decodeURI(window.location.pathname).includes("/termek/")) {
        var pageURL = decodeURI(window.location.pathname);
        var keyword = new URL(location.href).searchParams.get('keyword');
        var search = ''
        if (keyword != null)search += 'keyword='+keyword;
        if (search != '')search+= "&";
        search += 'sort='+$(this).val();
        history.pushState(null, "", pageURL+"?"+search);
        pageURL = pageURL.split('/');

        $.ajax({
            type: "GET",
            url: "itemload.php",
            data: {
                page: pageURL,
                keyword:keyword,
                sort: $(this).val(),
                },
            dataType: "html",
            success: function (data) {
                $("#pageContent").html(data);
            },
        });
    }
})


//sidebar

// $(document).ready(function () {
//   $(":checkbox:not(:checked)").map(function () {
//     var search = sessionStorage.getItem(this.value);
//     if (search == "checked") {
//       this.checked = true;
//     }
//   });
//   $(":checkbox").on("change", function () {
//     var search = $("checkbox").map(function () {
//       return this;
//     });
//     if (search.checked == true) {
//       sessionStorage.setItem(this.value, "checked");
//     } else {
//       sessionStorage.setItem(this.value, null);
//     }
//   });
// });

// $(function () {
//   $(".form-check-input").on("change", function () {
//     var search = $(".form-check-input:checked")
//       .map(function () {
//         sessionStorage.setItem(this.value, "checked");
//         return this.value;
//       })
//       .toArray();
//     url = "";
//     $(search).each(function () {
//       attr = this.split("=");
//       if (url.includes(attr[0] + "=")) {
//         url += "|" + attr[1];
//       } else {
//         if (url != "") {
//           url += "&" + this;
//         } else {
//           url += this;
//         }
//       }
//     });
//     location.search = url;
//   });
// });
