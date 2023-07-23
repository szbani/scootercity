const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

let nav = true;
const loading = {
    active: false
};
let limit = 10;

let urlJSON = {
    pageurl: decodeURI(window.location.pathname),
    keyword: getKeyword(),
    sort: getSort(),
    brand: getBrand(),
    pageNumber: 0,
    reloadbrand: true,
};

const state = {content: '', brandContent: '', sort: '', urlJSON: urlJSON, newpage: true};

const mswiper = new Swiper(".mSwiper", {
    slidesPerView: 'auto',
    spaceBetween: 40,
});
const dswiper = new Swiper(".dSwiper", {
    navigation: {
        nextEl: ".ds-next",
        prevEl: ".ds-prev",
    },
    spaceBetween: 30,
    slidesPerView: 'auto',
});
const nswiper = new Swiper(".nSwiper", {
    slidesPerView: 'auto',
    spaceBetween: 30,
    navigation: {
        nextEl: ".ns-next",
        prevEl: ".ns-prev",
    },
});


const swiper2 = new Swiper(".swiper-thumb", {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
});
const swiper = new Swiper(".swiper-main", {
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    thumbs: {
        swiper: swiper2,
    },
});

$(document).ready(function () {
    $("#search").keyup(function (e) {
        var search_query = $(this).val();

        if (search_query != "") {
            $.ajax({
                url: "/query/search.php",
                type: "POST",
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
        urlJSON.pageurl = '/bolt/kereses';
        urlJSON.keyword = $('#search').val()
        urlJSON.sort = '';
        urlJSON.brand = '';
        urlJSON.pageNumber = 0;
        $('#sort').val('');
        loadItems();
    });
    $("#search").focusin(function (e) {
        if ($(this).val() != "") {
            $("#list").fadeIn();
        }
    });
    $("#search").focusout(function (e) {
        $("#list").fadeOut();
    });
    if (decodeURI(window.location.pathname).includes("/bolt")) {
        if (!decodeURI(window.location.pathname).includes('/bolt/termek/')) {
            state.newpage = false;
            loadItems();
        }
        loadCategories();
        checkSidebarValues();
    } else {
        loadDiscount();
        loadNewest();
    }
});

function loadDiscount() {
    $.ajax({
        type: "GET",
        url: "/query/indexload.php",
        data: {
            where: 'indeximg is not null and learazas is not null',
            limit: 11,
        },
        dataType: "html",
        success: function (data) {
            if (data.trim()){
                data = JSON.parse(data)
                // console.log(data);
                $(data).each(function () {
                    $('#discounts').append(createItem($(this)[0],false));
                });
            }
        }
    })
}
function loadNewest(){
    $.ajax({
        type: "GET",
        url: "/query/indexload.php",
        data: {
            where: 'indeximg is not null ORDER BY id',
            limit: 11,
        },
        dataType: "html",
        success: function (data) {
            if (data.trim()){
                data = JSON.parse(data)
                // console.log(data);
                $(data).each(function () {
                    $('#newest').append(createItem($(this)[0],false));
                });
            }
        }
    })
}

window.addEventListener('popstate', (event) => {
    event.preventDefault();
    if (decodeURI(window.location.pathname).includes("/bolt")) {
        try {
            // console.log(event);
            $("#pageContent").html(event.state.content);
            $("#markak").html(event.state.brandContent);
            urlJSON = event.state.urlJSON;
            $('#sort').val(urlJSON.sort);
        } catch (ex) {
            console.log(ex);
            // window.location.href = decodeURI(window.location);
        }
        checkSidebarValues();
    }
});

function startLoading() {
    // $('.ajax-link').addClass('disabled');
    //loading screen?
    loading.active = true;
}

function stopLoading() {
    // $('.ajax-link').removeClass('disabled');
    //loading screen?
    loading.active = false;
}

//kategoria mezok
$(document).on("click", "a.link", function (e) {
    if (!decodeURI(window.location.pathname).includes('/bolt/termek/')) {
        e.preventDefault();
        $('#sort').val('');
        urlJSON.pageurl = $(this).attr("href");
        urlJSON.sort = '';
        urlJSON.keyword = '';
        urlJSON.brand = '';
        urlJSON.pageNumber = 0;
        loadItems();
    }
});
//marka mezo
$(document).on("change", '.marka', function (e) {
    e.preventDefault();
    let brand = '';
    $('.marka').each(function (index) {
        if ($(this).is(':checked')) {
            if (brand != '') brand += '|';
            brand += $(this).val();
        }
    });
    urlJSON.brand = brand;
    urlJSON.reloadbrand = false;
    urlJSON.pageNumber = 0;
    state.newpage = false;
    loadItems();
});
// Rendezés mező
$('#sort').change(function (e) {
    e.preventDefault();
    if (!decodeURI(window.location.pathname).includes("/termek/")) {
        let sort = '';
        if ($(this).val() != '')
            sort = $(this).val();
        urlJSON.sort = sort;
        urlJSON.reloadbrand = false;
        urlJSON.pageNumber = 0;
        state.newpage = false;
        loadItems();
    }
})

function loadMoreItem() {
    urlJSON.pageNumber++;
    loadItems();
}

function loadItems() {
    if (!loading.active) {
        startLoading();
        const url = makeURL();
        $.ajax({
            type: "GET",
            url: "/itemload.php",
            data: {
                page: urlJSON.pageurl.split('/'),
                keyword: urlJSON.keyword,
                sort: urlJSON.sort,
                brand: urlJSON.brand,
                pageNumber: urlJSON.pageNumber,
                limit: limit,
            },
            dataType: "html",
            success: function (data) {
                if (data.trim()) {
                    // console.log(data);
                    data = JSON.parse(data);

                    // console.log(data);

                    if (data.length < limit) $('#loadButton').attr('hidden', true);
                    else $('#loadButton').attr('hidden', false);
                    if (urlJSON.pageNumber > 0) {
                        $(data).each(function () {
                            $('#pageContent').append(createItem($(this)[0]));
                        });

                    } else {
                        $("#pageContent").empty();
                        $(data).each(function () {
                            $('#pageContent').append(createItem($(this)[0]));
                        });
                        state.url = url;
                        state.content = $('#pageContent').html();
                        if (urlJSON.reloadbrand) reloadMarkak(urlJSON.pageurl, urlJSON.keyword);
                        else {
                            urlJSON.reloadbrand = true;
                            state.urlJSON = urlJSON;
                            state.brandContent = $('#markak').html();
                            history.pushState(state, "", url);
                        }
                    }

                } else {
                    $('#loadButton').attr('hidden', true);
                }
                stopLoading();
            },
            error: function () {
                stopLoading();
            }
        });
    }
}

function reloadMarkak(page, keyword) {
    page = page.split('/');
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
            state.brandContent = data2;
            state.urlJSON = urlJSON;
            if (state.newpage === false) {
                history.replaceState(state, '', state.url);
                state.newpage = true;
            } else
                history.pushState(state, "", state.url);

        },
        error: function () {
            $('#markak').html('');
            state.brandContent = '';
        }
    });
}

function checkSidebarValues() {
    $('.marka').each(function (index) {
        const brands = urlJSON.brand.split('|');
        for (i = 0; i < brands.length; i++) {
            if ($(this).val() == brands[i]) {
                $(this).prop('checked', true);
            }
        }
    });
    $('#sort').val(urlJSON.sort);
}

function getKeyword() {
    let keyword = new URL(location.href).searchParams.get('keyword');
    let search = ''
    if (keyword != null) search += keyword;
    return search
}

function getSort() {
    let sort = new URL(location.href).searchParams.get('sort');
    let search = '';
    if (sort != null) search += sort;
    return search;
}

function getBrand() {
    let brand = new URL(location.href).searchParams.get('brand');
    let search = '';
    if (brand != null) search += brand;
    return search;
}

function makeURL() {
    let url = '';
    url = addToURL(url, 'keyword=', urlJSON.keyword);
    url = addToURL(url, 'sort=', urlJSON.sort);
    url = addToURL(url, 'brand=', urlJSON.brand);
    if (url != '') url = '?' + url;
    url = urlJSON.pageurl + url;
    return url;
}

function addToURL(url, param1, param2) {
    if (url != '' && param2) {
        url += '&';
        return url + param1 + param2;
    } else if (param2) {
        return url + param1 + param2;
    }
    return url;
}

function createItem(data, col = true) {
    let index = 'product-placeholder.png';
    if (data['indeximg'] != null) index = data['indeximg'];
    let price;
    if (data['ar'] != 0)
        price = data['ar'].toLocaleString('hu-HU', {style: 'currency', currency: 'HUF', minimumFractionDigits: 0});
    else
        price = 'Rendelelhető';
    // let learazas = data['learazas'] ? data['learazas'].toLocaleString('hu-HU', {style: 'currency', currency: 'HUF', minimumFractionDigits: 0}) : null;
    let item;
    if (col === true)
        item = $('<div>').addClass('col mt-3');
    else
        item = $('<div>').addClass('swiper-slide');
    let card = $('<div>').addClass('card rounded shadow-sm')
    let indeximg = $('<img>').addClass('card-img-top align-self-center').attr('src', '/media/products/' + index).attr('alt', data['nev'])
    let priceBlock;
    if (data['learazas'] !== null) {
        let learazas = data['learazas'].toLocaleString('hu-HU', {
            style: 'currency',
            currency: 'HUF',
            minimumFractionDigits: 0
        });
        priceBlock = $('<h5>').addClass('mb-1 w-100')
            .append($('<span>').addClass('w-100 d-inline-block fs-6')
                .append($('<s>').text(price)))
            .append($('<span>').addClass('w-100 d-inline-block fs-5').append($('<s>')).text(learazas));
    } else
        priceBlock = $('<h5>').append($('<span>').append($('<s>')).text(price));
    let textBlock = $('<div>').addClass('text-over-image').append(
        $('<div>').addClass('item-text px-2').append(
            $('<p>').addClass('card-title fw-bold mb-0').text(data['nev'])
        )
    ).append(
        $('<div>').addClass('d-flex bg-price px-2').append(
            priceBlock
        )
    );
    let href = $('<a>').addClass('card_click').attr('href', '/bolt/termek/' + data['id'] + '/' + data['nev']);

    item.append(card.append(indeximg, textBlock, href));
    return item;
}

function loadCategories() {
    $.ajax({
        type: "GET",
        url: "/query/categoryload.php",
        dataType: "html",
        success: function (data) {
            // console.log(JSON.parse(data));
            createCategory(JSON.parse(data));
        },
        error: function (data) {
            // console.log(data);
        }
    });
}

function createCategory(data) {
    let kat = $('<li>').addClass('mb-1').append(
        $('<button>').addClass('btn btn-toggle d-inline-flex align-items-center border-0 collapsed fw-bold w-100')
            .attr('data-bs-toggle', 'collapse')
            .attr('data-bs-target', '#kategoriakCollapse')
            .attr('aria-expanded', 'true')
            .text('Kategóriák')
    );
    let div = $('<div>').addClass('collapse show')
        .attr('id', 'kategoriakCollapse');
    let subkat;
    for (let i = 0; i < data.length; i++) {
        let currdata = data[i];
        // console.log(currdata['']);
        if (currdata['alkategoriak'] != null && currdata['subkat'] == null) {
            // console.log(currdata);
            subkat = createSubCategory(data, currdata);
            div.append(subkat);
        } else if (currdata['alkategoriak'] == null && currdata['hasznalva'] > 0 && currdata['subkat'] == null) {
            // console.log(currdata);
            div.append(
                $('<li>').addClass('link text-decoration-none fw-bold cursor')
                    .attr('href', '/bolt/' + currdata['nev']));
        }

    }
    // console.log(kat);
    $('#categories').append(kat.append(div));
}

function createSubCategory(data, currdata, last = false) {
    let subkat = $('<li>');
    let ul;
    if (currdata['alkategoriak'] == null) {
        subkat.append($('<li>').append($('<a>')
            .addClass('link text-decoration-none fw-bold cursor')
            .attr('href', '/bolt/' + currdata['nev'])
            .text(currdata['nev'])));
    } else {
        subkat.append($('<button>').addClass('btn btn-toggle d-inline-flex align-items-center border-0 fw-bold w-100')
            .attr('data-bs-toggle', 'collapse')
            .attr('data-bs-target', '#' + currdata['id'] + '-' + currdata['nev'])
            .attr('aria-expanded', false)
            .text(currdata['nev']));

        ul = $('<ul>').addClass('btn-toggle-nav mx-auto list-unstyled');
    }

    if (currdata['alkategoriak'] != null) {
        let alkat = currdata['alkategoriak'].split(',');
        alkat.forEach((element) => {
            for (let i = 0; i < data.length; i++) {
                if (element == data[i]['id']) {
                    if (data[i]['alkategoriak'] != null || data[i]['hasznalva'] > 0) {
                        let temp = createSubCategory(data, data[i]);
                        if (temp != null) ul.append(temp);
                    }
                    break;
                } else if (i == data.length - 1) {
                    if (currdata['hasznalva'] == 0 && currdata['subkat'] != null) {
                        // console.log(currdata);
                        // console.log(subkat);
                        subkat = null;
                    }
                }
            }
        });
    }
    if (subkat != null) {
        subkat.append($('<div>')
            .addClass('collapse')
            .attr('id', currdata['id'] + '-' + currdata['nev']).append(ul)
        );
    }
    // console.log(subkat);
    return subkat;
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
