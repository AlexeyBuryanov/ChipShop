<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует корзину

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Если корзина не пустая
if (isset($_SESSION["cart"])) {

    // Смотрим, что там в корзине
    $cart = $_SESSION["cart"];
    $cartItems = 0;
    $cartTotalPrice = 0;
    
    // Подсчитываем общую цену и кол-во элементов в корзине
    foreach ($cart as $cartProduct) {
        $cartItems += $cartProduct->getQuantity();
        $cartTotalPrice += $cartProduct->getPrice() * $cartProduct->getQuantity();
    } // foreach
// иначе пустая
} else {
    $cartItems = "0";
    $cartTotalPrice = "0.00";
} // if