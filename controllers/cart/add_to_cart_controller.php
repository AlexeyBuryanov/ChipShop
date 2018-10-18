<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует добавление товара в корзину

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

// Если существует айди товара
if (isset($_GET["pid"])) {
    $productId = $_GET["pid"];
    $quantity = $_GET["pqty"];
    try {
        // DAO товаров
        $productsDao = \models\database\ProductsDao::getInstance();
        // DAO изображений
        $productImagesDao = \models\database\ProductImagesDao::getInstance();
        // Детали о товаре
        $productDetails = $productsDao->getProductByID($productId);
        // Первое изображение товара
        $productImage = $productImagesDao->getFirstProductImage($productId);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../errors.log");
        header("HTTP/1.1 500 Internal Server Error", true, 500);
        die();
    } // try-catch
    $cartProduct = new \models\CartProduct();
    $cartProduct->setId($productId);
    $cartProduct->setTitle($productDetails["title"]);
    // Если есть скидка - подсчитываем вместе со скидкий
    if ($productDetails["percent"] != null) {
        $cartProduct->setPrice(round($productDetails["price"] - (($productDetails["price"] * $productDetails["percent"]) / 100), 2));
    } else {
        $cartProduct->setPrice($productDetails["price"]);
    } // if
    $cartProduct->setImage($productImage);

    // Если корзина не пустая
    if (isset($_SESSION["cart"])) {
        $cart = $_SESSION["cart"];
        // Если корзина содержит уже товар с таким Id
        if (array_key_exists($cartProduct->getId(), $cart)) {
            $cartProduct->setQuantity($cart[$cartProduct->getId()]->getQuantity() + $quantity);
            $cart[$cartProduct->getId()] = $cartProduct;
        } else {
            $cartProduct->setQuantity($quantity);
            $cart[$cartProduct->getId()] = $cartProduct;
        } // if
        $_SESSION["cart"] = $cart;
    } else {
        $cartProduct->setQuantity($quantity);
        $cart[$cartProduct->getId()] = $cartProduct;
        $_SESSION["cart"] = $cart;
    } // if

    header("location: ../../views/main/index.php");
    die();
} else {
    header("HTTP/1.1 404 Not Found", true, 404);
    die();
} // if