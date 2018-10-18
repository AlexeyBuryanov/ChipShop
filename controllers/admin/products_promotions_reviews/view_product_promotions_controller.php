<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует отображение акций товара

// Подключаем обработчик ошибок
require_once "../../../utils/error_handler_dir_back.php";
// Подключаем проверку Admin/Mod
require_once "../../../utils/admin_mod_session.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\..\\" . $className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

try {
    $productId = $_GET["pid"];
    // DAO товаров
    $productDao = \models\database\ProductsDao::getInstance();
    // Получаем товар
    $product = $productDao->getProductByID($productId);
    // DAO акций
    $promoDao = \models\database\PromotionsDao::getInstance();
    // Получаем все акции для товара
    $promotions = $promoDao->getAllPromotionsForProduct($productId);
} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
    error_log($message, 3, "../../../errors.log");
    header("location: ../../../views/error/error_500.php");
    die();
} // try-catch