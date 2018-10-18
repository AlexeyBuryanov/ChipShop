<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует отображение одного товара

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Попытка выполнить соединение с базой данных
try {
    // Идентификатор товара
    $productId = $_GET["pid"];
    // DAO товаров
    $productsDao = \models\database\ProductsDao::getInstance();
    // DAO характеристик, они же спецификации
    $specsDao = \models\database\ProductSpecificationsDao::getInstance();
    // DAO обзоров
    $reviewsDao = \models\database\ReviewsDao::getInstance();
    // DAO изображений
    $imagesDao = \models\database\ProductImagesDao::getInstance();
    // DAO акций
    $promoDao = \models\database\PromotionsDao::getInstance();

    // Получаем товар по id
    $product = $productsDao->getProductByID($productId);
    // Если товар недоступен к просмотру
    if ($product["visible"] == 0) {
        header("location: ../../views/error/error_404.php");
        die();
    } // if

    // Получаем все данные товара
    $specifications = $specsDao->getAllSpecificationsForProduct($productId);
    $reviews = $reviewsDao->getReviewsForProduct($productId);
    $images = $imagesDao->getAllProductImages($productId);
    $promotion = $promoDao->getBiggestActivePromotionByProductId($productId);
    $reviewsCount = count($reviews);
    $relatedProducts = $productsDao->getRelated($product["subcategory_id"], $productId);

    $promotedPrice = null;
    // Если существуют скидки учитываем этот факт
    if ($promotion != null) {
        $promotedPrice = round($product["price"] - (($product["price"] * $promotion["percent"]) / 100), 2);
    } // if

    // Проверка на ноль средней оценки
    if ($product["average"] === null) {
        $product["average"] = 0;
    } else {
        $product["average"] = round($product["average"], 0);
    } // if
} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
    error_log($message, 3, "../../errors.log");
    header("location: ../../views/error/error_500.php");
    die();
} // try-catch