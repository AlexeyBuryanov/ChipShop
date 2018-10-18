// Удалить из корзины
async function removeFromCart(productId, productPrice) {
    return new Promise((resolve, reject) => {
        $('#button-' + productId).remove();
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.status == 404 && this.readyState == 4) {
                window.location.replace("../error/error_404.php");
            } else if (this.status == 200 && this.readyState == 4) {
                var currentQuantity = document.getElementById("product-" + productId + "-quantity");
                
                var items = document.getElementById("cartItems");
                items.innerHTML = parseInt(items.innerHTML) - parseInt(currentQuantity.innerHTML);
                
                var price = document.getElementById("cartTotalPrice");
                price.innerHTML = (parseFloat(price.innerHTML) - (productPrice * parseInt(currentQuantity.innerHTML))).toFixed(2);
                
                var items2 = document.getElementById("cartItems2");
                items2.innerHTML = parseInt(items2.innerHTML) - parseInt(currentQuantity.innerHTML);
                
                var price2 = document.getElementById("cartTotalPrice2");
                price2.innerHTML = (parseFloat(price2.innerHTML) - (productPrice * parseInt(currentQuantity.innerHTML))).toFixed(2);
                
                $('#product-' + productId).remove();
            } // if
        };

        xhttp.open("GET", "../../controllers/cart/remove_from_cart_controller.php?pid=" + productId, true);
        xhttp.send();
        resolve();
    });
} // removeFromCart