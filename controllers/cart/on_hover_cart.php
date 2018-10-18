<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// При наведении курсором мыши на корзину

// Обработка ошибок
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
    $products = array();

    foreach ($cart as $key => $value) {
        $products[$key]["id"] = $value->getId();
        $products[$key]["image_url"] = $value->getImage();
        $products[$key]["title"] = $value->getTitle();
        $products[$key]["price"] = $value->getPrice();
        $products[$key]["quantity"] = $value->getQuantity();
    } // foreach

    // Отправляем данные в JSON
    echo(json_encode($products, JSON_UNESCAPED_SLASHES));
} else {
    echo(json_encode(array()));
} // if