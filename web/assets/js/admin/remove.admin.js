// Удалить суперкатегорию
async function deleteSuperCat(superCatId) {
    return new Promise((resolve, reject) => {
        if (confirm("Вы действительно хотите удалить суперкатегорию с идентификатором " + superCatId + "? \n\nПРЕДУПРЕЖДЕНИЕ:\n" +
                    "Это также удалит подкатегории и товары из этой суперкатегории!")) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.status == 500 && this.readyState == 4) {
                    window.location.replace("../error/error_500.php");
                } else if (this.status == 400 && this.readyState == 4) {
                    window.location.replace("../error/error_400.php");
                } else if (this.status == 200 && this.readyState == 4) {
                    $('#delId-' + superCatId).remove();
                } // if
            };

            xhttp.open("GET", "../../../controllers/admin/supercategories/delete_supercategory_controller.php?scid=" + superCatId, true);
            xhttp.send();
        } // if
        resolve();
    });
} // deleteSuperCat

// Удалить категорию
async function deleteCat(catId) {
    return new Promise((resolve, reject) => {
        if (confirm("Вы действительно хотите удалить категорию с идентификатором " + catId + "? \n\nПРЕДУПРЕЖДЕНИЕ:\n" +
                    "Это также приведёт к удалению подкатегорий и товаров из этой категории!")) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.status == 500 && this.readyState == 4) {
                    window.location.replace("../error/error_500.php");
                } else if (this.status == 400 && this.readyState == 4) {
                    window.location.replace("../error/error_400.php");
                } else if (this.status == 200 && this.readyState == 4) {
                    $('#delId-' + catId).remove();
                } // if
            };

            xhttp.open("GET", "../../../controllers/admin/categories/delete_category_controller.php?cid=" + catId, true);
            xhttp.send();
        } // if
        resolve();
    });
} // deleteCat

// Удалить подкатегорию
async function deleteSubCat(subcatId) {
    return new Promise((resolve, reject) => {
        if (confirm("Вы действительно хотите удалить подкатегорию с идентификатором " + subcatId + "? \n\nПРЕДУПРЕЖДЕНИЕ:\n" +
                    "Это также приведёт к удалению товаров, которые входят в эту подкатегорию!")) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.status == 500 && this.readyState == 4) {
                    window.location.replace("../error/error_500.php");
                } else if (this.status == 400 && this.readyState == 4) {
                    window.location.replace("../error/error_400.php");
                } else if (this.status == 200 && this.readyState == 4) {
                    $('#delId-' + subcatId).remove();
                } // if
            };

            xhttp.open("GET", "../../../controllers/admin/subcategories/delete_subcategory_controller.php?scid=" + subcatId, true);
            xhttp.send();
        } // if
        resolve();
    });
} // deleteSubCat

// Удалить спецификацию
async function deleteSpec(specId) {
    return new Promise((resolve, reject) => {
        if (confirm("Вы действительно хотите удалить спецификацию подкатегории с идентификатором " + specId + "? \n\nПРЕДУПРЕЖДЕНИЕ:\n" +
                    "Это также удалит спецификацию товара для любых товаров, имеющих эту спецификацию подкатегории!")) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.status == 500 && this.readyState == 4) {
                    window.location.replace("../error/error_500.php");
                    return;
                } else if (this.status == 400 && this.readyState == 4) {
                    window.location.replace("../error/error_400.php");
                    return;
                } else if (this.status == "") {
                    $('#delId-' + specId).remove();
                } // if
            };

            xhttp.open("GET", "../../../controllers/admin/subcategory_specs/delete_subcat_spec_controller.php?ssid=" + specId, true);
            xhttp.send();
        } // if
        resolve();
    });
} // deleteSpec

// Удалить акцию
async function deletePromo(promoId) {
    return new Promise((resolve, reject) => {
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.status == 500 && this.readyState == 4) {
                window.location.replace("../error/error_500.php");
            } else if (this.status == 400 && this.readyState == 4) {
                window.location.replace("../error/error_400.php");
            } else if (this.status == 200 && this.readyState == 4) {
                $('#delId-' + promoId).remove();
            } // if
        };

        xhttp.open("GET", "../../../controllers/admin/products_promotions_reviews/delete_product_promotion_controller.php?prid=" + promoId, true);
        xhttp.send();
        resolve();
    });
} // deletePromo

// Переключить видимость
async function toggleVisibility(productId, currentVis) {
    return new Promise((resolve, reject) => {
        if (confirm("Вы уверены, что хотите переключить видимость продукта с идентификатором " + productId + "?")) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.status == 500 && this.readyState == 4) {
                    window.location.replace("../error/error_500.php");
                } else if (this.status == 400 && this.readyState == 4) {
                    window.location.replace("../error/error_400.php");
                } else if (this.status == 200 && this.readyState == 4) {
                    var visibility = document.getElementById("togId-" + productId);
                    if (visibility.innerHTML == "Да") {
                        visibility.innerHTML = "Нет";
                    } else {
                        visibility.innerHTML = "Да";
                    } // if
                } // if
            };

            xhttp.open("GET", "../../../controllers/admin/products_promotions_reviews/visibility_product_controller.php?pid=" + productId + "&vis=" + currentVis, true);
            xhttp.send();
        } // if
        resolve();
    });
} // toggleVisibility