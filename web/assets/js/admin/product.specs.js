// Загрузка спецификаций
async function loadSpecs() {
    return new Promise((resolve, reject) => {
        var xhttp = new XMLHttpRequest();
        var subCatId = document.getElementById("selectSubCatId").value;
        
        xhttp.onreadystatechange = function () {
            if (this.status == 500 && this.readyState == 4) {
                window.location.replace("../error/error_500.php");
            } else if (this.status == 400 && this.readyState == 4) {
                window.location.replace("../error/error_400.php");
            } else if (this.status == 200 && this.readyState == 4) {
                var specWindow = document.getElementById("specsWindow");
                specWindow.innerHTML = "";
                
                var specs = JSON.parse(this.responseText);
                
                var i = 0;
                for (var key in specs) {
                    if (specs.hasOwnProperty(key)) {
                        var specInput = document.createElement("input");
                        specInput.type = "text";
                        specInput.setAttribute("name", "specValue-" + i);
                        specInput.setAttribute("placeholder", specs[key]['name']);

                        var specId = document.createElement("input");
                        specId.type = "hidden";
                        specId.setAttribute("name", "specValueId-" + i);
                        specId.setAttribute("value", specs[key]["id"]);

                        specWindow.append(specs[key]['name'] + ": ");
                        specWindow.appendChild(specInput);
                        specWindow.appendChild(specId);
                        specWindow.innerHTML += "<br>";

                        i++;
                    } // if
                } // foreach

                var specCount = document.createElement("input");
                specCount.type = "hidden";
                specCount.setAttribute("name", "specsCount");
                specCount.setAttribute("value", i);

                specWindow.appendChild(specCount);
            } // if
        };

        xhttp.open("GET", "../../../controllers/admin/products_promotions_reviews/new_product_fill_specs_controller.php?scid=" + subCatId, true);
        xhttp.send();
        resolve();
    });
} // loadSpecs