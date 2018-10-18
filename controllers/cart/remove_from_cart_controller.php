<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Удаление из корзины

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

session_start();

// Если корзина не пустая и есть id товара - работаем
if (isset($_SESSION["cart"]) && isset($_GET["pid"])) {
    $productId = $_GET["pid"];
    $cart = $_SESSION["cart"];
    // Обработка по кол-ву товара
    if (isset($_GET["pqty"])) {
        $cartProduct = $cart[$productId];
        // Если кол-во товара 0, удаляем его из корзины
        if ($cartProduct->getQuantity() - 1 == 0) {
            unset($cart[$productId]);
        } else {
            $cartProduct->setQuantity($cartProduct->getQuantity() - 1);
            $cart[$productId] = $cartProduct;
        } // if
        $_SESSION["cart"] = $cart;
    } else {
        // Если корзина содержит уже товар с таким Id
        if (array_key_exists($productId, $cart)) {
            // Удаляем его из корзины
            unset($cart[$productId]);
            // Перезаписываем корзину
            $_SESSION["cart"] = $cart;
        } else {
            header("HTTP/1.1 404 Not Found", true, 404);
            die();
        } // if
    } // if
} else {
    header("HTTP/1.1 404 Not Found", true, 404);
    die();
} // if