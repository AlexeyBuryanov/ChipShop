<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует продукты по категории

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Если задан фильтр
if (isset($_GET["filter"])) {
    $offset = $_GET["offset"];
    $subcatId = $_GET["subcid"];
    $filter = $_GET["filter"];
    $minPrice = $_GET["minP"];
    $maxPrice = $_GET["maxP"];

    try {
        // DAO товаров
        $productsDao = \models\database\ProductsDao::getInstance();
        // Получаем товары в заданной подкатегории
        $products = $productsDao->getSubCatProducts($subcatId, $offset, $filter, $minPrice, $maxPrice);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../errors.log");
        header("HTTP/1.1 500 Internal Server Error", true, 500);
        die();
    } // try-catch

    // Кодируем полученные товары в json
    header("content-type: application/json");
    echo json_encode($products);
} else {
    try {
        $subcatDao = \models\database\SubCategoriesDao::getInstance();
        $subcatName = $subcatDao->getSubCategoryName($_GET["subcid"]);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../errors.log");
        header("location: ../../views/error/error_500.php");
        die();
    } // try-catch
} // if