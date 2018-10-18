<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует показ товаров в корзине

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

// Если корзина не пустая
if (isset($_SESSION["cart"])) {
    $cart = $_SESSION["cart"];
    $cartIsEmpty = 0;
// иначе пустая
} else {
    $cart = array();
    $cartIsEmpty = 1;
} // if

// Проверка заказа, забираем сессионные данные о покупке
if (isset($_SESSION["oid"])) {
    $orderNumber = $_SESSION["oid"];
    $orderQuantity = $_SESSION["oItems"];
    $orderTotalPrice = $_SESSION["oTotalPrice"];
    // Очищаем данные
    unset($_SESSION["oid"]);
    unset($_SESSION["oItems"]);
    unset($_SESSION["oTotalPrice"]);
    // Заказ успешен
    $orderSuccessful = 1;
} else {
    $orderSuccessful = 0;
} // if