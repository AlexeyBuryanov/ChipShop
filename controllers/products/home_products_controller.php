<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует товары на главной странице

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

try {
    // Получаем объект DAO для продуктов/товаров
    $productsDao = \models\database\ProductsDao::getInstance();
    // Получаем топовые товары
    $topRated = $productsDao->getTopRated();
    // Получаем самые последние товары
    $mostRecent = $productsDao->getMostRecent();
    // Получаем самые продаваемые товары
    $mostSold = $productsDao->mostSoldProducts();
} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
    error_log($message, 3, "../../errors.log");
    header("location: ../../views/error/error_500.php");
    die();
} // try-catch