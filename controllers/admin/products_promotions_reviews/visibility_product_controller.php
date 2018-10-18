<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует видимость товара

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

// Если существует айди товара
if (isset($_GET["pid"])) {
    // Валидация
    if (!($_GET["vis"] == 1 || $_GET["vis"] == 0)) {
        header("HTTP/1.1 400 Bad Request", true, 400);
        die();
    } // if

    // Попытка выполнить соединение с базой данных
    try {
        $productId = $_GET["pid"];
        $currentVis = $_GET["vis"];
        // В зависимости от текущей настройки видимости
        if ($currentVis == 1) {
            $toggleTo = 0;
        } else {
            $toggleTo = 1;
        } // if
        // DAO товаров
        $productDao = \models\database\ProductsDao::getInstance();
        // Переключить видимость
        $productDao->toggleVisibility($productId, $toggleTo);
        header("location: ../../../views/admin/products_promotions_reviews/products_view.php");
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("HTTP/1.1 500 Internal Server Error", true, 500);
        die();
    } // try-catch
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    die();
} // if