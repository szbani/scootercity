const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

var nav = true;
$(document).ready(function () {
    var navbar = $("#mainNavbar");
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
        history.pushState(null, "", pageURL + '?keyword=' + keyword);
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
        reloadMarkak();
    });
    $("#search").keypress(function (e) {
        if (e.wich == 13) {
            var keyword = $('#search').val();
            var pageURL = '/bolt/kereses';
            const state = {url: pageURL,content:''};
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
                    state.content = data;
                    console.log('asd');
                },
            });
            reloadMarkak();

            history.pushState(state, "", pageURL + '?keyword=' + keyword);
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

window.addEventListener('popstate', (event) => {
    console.log("popstate");
    const state = event.state;
    const content = state.content;
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
    reloadMarkak();
});

$(document).on("change", '.marka', function (e) {
    e.preventDefault();
    let brand = '';
    $('.marka').each(function (index) {
        if ($(this).is(':checked')) {
            if (brand != '') brand += '|';
            brand += $(this).val();
        }
    });
    if (brand != '') brand = 'brand=' + brand;
    let url = makeURL(getKeyword(), getSort(), brand);
    history.pushState(null, "", url);
    reloadItems();
});
// Rendezés mező
$('#sort').change(function (e) {
    e.preventDefault();
    if (!decodeURI(window.location.pathname).includes("/termek/")) {
        let sort = '';
        if ($(this).val() != '')
            sort = 'sort=' + $(this).val();
        console.log(getBrand());
        let url = makeURL(getKeyword(), sort, getBrand());
        history.pushState(null, "", url);
        reloadItems();
    }
})

function reloadItems() {

    let page = decodeURI(window.location.pathname).split('/');
    let keyword = getKeyword().replace('keyword=', '');
    let sort = getSort().replace('sort=', '');
    let brand = getBrand().replace('brand=', '');

    $.ajax({
        type: "GET",
        url: "itemload.php",
        data: {
            page: page,
            keyword: keyword,
            sort: sort,
            brand: brand,
        },
        dataType: "html",
        success: function (data) {
            $("#pageContent").html(data);
        },
    });
}

function reloadMarkak(){
    let page = decodeURI(window.location.pathname).split('/');
    let keyword = getKeyword().replace('keyword=', '');
    $.ajax({
        type: "GET",
        url: "/query/marka.php",
        data: {
            page: page,
            keyword: keyword,
        },
        dataType: "html",
        success: function (data2) {
            $('#markak').html(data2);
        }
    });
}


function getKeyword() {
    let keyword = new URL(location.href).searchParams.get('keyword');
    let search = ''
    if (keyword != null) search += 'keyword=' + keyword;
    return search
}

function getSort() {
    let sort = new URL(location.href).searchParams.get('sort');
    let search = '';
    if (sort != null) search += 'sort=' + sort;
    return search;
}

function getBrand() {
    let brand = new URL(location.href).searchParams.get('brand');
    let search = '';
    if (brand != null) search += 'brand=' + brand;
    return search;
}

function makeURL(keyword, sort, brand) {
    let url = '';
    url = addToURL(url, keyword);
    url = addToURL(url, sort);
    url = addToURL(url, brand);
    if (url != '') url = '?' + url;
    url = decodeURI(window.location.pathname) + url;
    return url;
}

function addToURL(url, param) {
    if (url != '' && param != '') url += '&';
    return url + param;
}

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
