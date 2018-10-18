// Поиск по предложенному
async function searchSuggest() {
    return new Promise((resolve, reject) => {
        // Введённое значение
        var needle = document.getElementById("search").value;
        // Создаём объект XMLHTTPrequest (AJAX)
        var xhttp = new XMLHttpRequest();

        // Что происходит при получении ответа
        xhttp.onreadystatechange = function () {
            if (this.status == 500 && this.readyState == 4) {
                window.location.replace("../error/error_500.php");
            } else if (this.readyState == 4 && this.status == 200) {
                var flag = true;
                // Парсим товары из responseText
                var products = JSON.parse(this.responseText);
                // Результирующий контейнер
                var container = document.getElementById('result');
                container.style.display = "block";
                container.innerHTML = "";

                for (var pid in products) {
                    flag = false;
                    var result = "<a href=\"single.php?pid=" + products[pid]["id"] + "\">" +
                                 "<div class='search-result'>" + 
                                 "<img class='search-result-img'" + " src='" + products[pid]['image_url'] + "'>" + 
                                 "<p class='search-result-p'>" + products[pid]['title'] + "<br/>" + 
                                 "₴" + products[pid]['price'] + "</p></div></a>";
                    var productDiv = document.createElement('div');
                    productDiv.innerHTML = result;
                    container.appendChild(productDiv);
                } // foreach

                // Если товаров нет - не отображаем результат
                if (flag) {
                    container.style.display = "none";
                } // if
            } // if
        };

        // Где отправить запрос
        xhttp.open("GET", "../../controllers/search/search_controller.php?needle=" + needle, true);
        xhttp.send();
        resolve();
    });
} // searchSuggest