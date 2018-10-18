// Добавить в избранное
async function addFavourite(product_id) {
    return new Promise((resolve, reject) => {
        // Создаём объект XMLHTTPrequest (AJAX)
        var xhttp = new XMLHttpRequest();

        // Что происходит при получении ответа
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('favourite').innerHTML = "";
                document.getElementById('favourite').innerHTML = "<button class='btn btn-danger' onclick='removeFavourite(" + product_id + ")'>" + 
                                                                 "<span class='glyphicon glyphicon-heart-empty'></span> Удалить из избранного</button>";
            } // if
        };

        // Где отправить запрос
        xhttp.open("GET", "../../../Chip/controllers/favourites/add_favourites_controller.php?product_id=" + product_id, true);
        xhttp.send();
        resolve();
    });
} // addFavourite

// Удалить из избранного
async function removeFavourite(product_id) {
    return new Promise((resolve, reject) => {
        // Создаём объект XMLHTTPrequest (AJAX)
        var xhttp = new XMLHttpRequest();

        // Что происходит при получении ответа
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('favourite').innerHTML = "";
                document.getElementById('favourite').innerHTML = "<button class='btn btn-primary' onclick='addFavourite(" + product_id + ")'>" + 
                                                                 "<span class='glyphicon glyphicon-heart'></span> Добавить в избранное</button>";
            } // if
        };

        // Где отправить запрос
        xhttp.open("GET", "../../../Chip/controllers/favourites/remove_favourites_controller.php?product_id_remove=" + product_id, true);
        xhttp.send();
        resolve();
    });
} // removeFavourite

async function removeFavouriteList(product_id) {
    return new Promise((resolve, reject) => {
        // Создаём объект XMLHTTPrequest (AJAX)
        var xhttp = new XMLHttpRequest();

        // Что происходит при получении ответа
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText) {
                    document.getElementById('favouritesTitle').innerHTML = "Список избранного пуст";
                } // if
                document.getElementById('deleteItem' + product_id).innerHTML = "";
            } // if
        };

        // Где отправить запрос
        xhttp.open("GET", "../../../Chip/controllers/favourites/remove_favourites_controller.php?product_id_remove=" + product_id, true);
        xhttp.send();
        resolve();
    });
} // removeFavouriteList