<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллит отображение товаров

// Подключаем обработчик ошибок
require_once "../../../utils/error_handler_dir_back.php";
// Подключаем проверку Admin/Mod
require_once "../../../utils/admin_mod_session.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

try {
    // DAO товаров
    $productDao = \models\database\ProductsDao::getInstance();
    // Получаем все товары
    $products = $productDao->getAllProductsAdmin();
} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
    error_log($message, 3, "../../../errors.log");
    header("location: ../../../views/error/error_500.php");
    die();
} // try-catch