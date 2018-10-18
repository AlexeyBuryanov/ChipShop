var offset = 0;

// первая загрузка
$(document).ready(function () {
    loadProducts(offset);
});

// вызов бесконечной прокрутки
$(window).scroll(function () {
        onScrollToBottom();
    }
);

// при изменении фильтра
function filteredProducts() {
    $(window).bind('scroll', function () {
        onScrollToBottom();
    });
    offset = 0;
    loadProducts(offset);
} // filteredProducts

// бесконечная функция прокрутки (отдельная для вызова из нескольких мест)
function onScrollToBottom() {
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 50) {
        loadProducts(offset += 8);
    } // if
} // onScrollToBottom

// фильтр ценового диапазона
var minPrice = 0;
var maxPrice = 200000;
$(function () {
    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 200000,
        values: [0, 200000],
        step: 5,
        slide: function (event, ui) {
            $("#amount").val("₴" + ui.values[0] + " - ₴" + ui.values[1]);
            minPrice = ui.values[0];
            maxPrice = ui.values[1];
        },
        stop: function (event, ui) {
            $(window).bind('scroll', function () {
                onScrollToBottom();
            });
            offset = 0;
            loadProducts(offset);
        }
    });
    $("#amount").val("₴" + $("#slider-range").slider("values", 0) + " - ₴" + $("#slider-range").slider("values", 1));
});

// загрузка товаров (вызывается всеми)
function loadProducts(offset) {
    var xhttp = new XMLHttpRequest();
    var productsWindow = document.getElementById("productsWindow");

    var loading = document.createElement("img");
    loading.setAttribute("src", "../../web/assets/images/ajax-loader.gif");
    loading.setAttribute("class", "center-block");

    var loaderDiv = document.getElementById("loader");
    if (loaderDiv.children.length < 1) {
        loaderDiv.appendChild(loading);
    } // if

    xhttp.onreadystatechange = function () {
        if (this.status == 500 && this.readyState == 4) {
            window.location.replace("../error/error_500.php");
        } else if (this.status == 200 && this.readyState == 4) {
            loaderDiv.innerHTML = "";

            if (offset == 0) {
                productsWindow.innerHTML = "";
            } // if

            var products = JSON.parse(this.responseText);
            if (products.length == 0) {
                $(window).unbind('scroll');
            } // if

            var i = 0;
            var content = '';
            for (var key in products) {
                if (products.hasOwnProperty(key)) {
                    if (products[key]['percent'] !== null) {
                        var promotedPrice = Math.round((products[key]['price'] - ((products[key]['price'] * products[key]['percent']) / 100)) * 100) / 100;
                    } else {
                        promotedPrice = null;
                    } // if

                    if (products[key]['average'] === null) {
                        var productAverage = 0;
                    } else {
                        productAverage = Math.round(products[key]['average']);
                    } // if

                    if (key == 0) {
                        content += '<div class="products-grid-lft">';
                    } // if

                    if (i == 4) {
                        content += '<div class="products-grid-lft">';
                        i = 0;
                    } // if

                    content +=
                        '<div class="products-grd">' +
                        '<div id="categoryMarginUnderButton" class="p-one">' +
                        '<a href="single.php?pid=' + products[key]['id'] + '">' +
                        '<img src="' + products[key]['image_url'] + '"' +
                        'alt="Product Image" class="img-responsive"/>' +
                        '</a>' +
                        '<h4>' + products[key]['title'] + '</h4>' +
                        '<img class="ratingCatDiv media-object img"' +
                        ' src="../../web/assets/images/rating' + productAverage + '.png">' +
                        '<span>(' + products[key]['reviewsCount'] + ')</span>' + '<br/><br/>' +
                        '<p><a id="addButtonBlock" class="btn btn-default btn-sm"' +
                        'onclick="addToCart(' + products[key]['id'] +
                        ',' + (promotedPrice != null ? promotedPrice : products[key]['price']) + ')">' +
                        '<i class="glyphicon glyphicon-shopping-cart"></i>&nbspВ корзину' +
                        '</a>&nbsp&nbsp';

                    if (promotedPrice != null) {
                        content +=
                            '<span class="item_price valsa"' +
                            'style="color: red;">₴' + promotedPrice + '</span>' +
                            ' <span class="item_price promoValsa">₴' + products[key]['price'] + '</span>';
                    } else {
                        content += '<span class="item_price valsa">₴' + products[key]['price'] + '</span>';
                    } // if

                    content +=
                        '</p>' +
                        '<div class="pro-grd">' +
                        '<a href="single.php?pid=' + products[key]['id'] + '">Просмотреть</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    if (key == products.length - 1) {
                        content += '</div>';
                        $('#productsWindow').append(content);
                    } // if

                    i++;
                } // if
            } // foreach
        } // if
    };

    var filter = document.getElementById('filter').value;
    var subcid = location.search;

    xhttp.open("GET", "../../controllers/products/products_by_category_controller.php" + subcid + "&offset=" + offset + "&filter=" + filter + "&minP=" + minPrice + "&maxP=" + maxPrice, true);
    xhttp.send();
} // loadProducts