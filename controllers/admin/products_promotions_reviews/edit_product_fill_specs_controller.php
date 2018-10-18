<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует редактирование спецификаций товара

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

// Если существует айди продукта
if (isset($_GET["pid"])) {
    $productId = $_GET["pid"];
    try {
        // DAO спецификаций
        $productSpecsDao = \models\database\ProductSpecificationsDao::getInstance();
        // Получаем спецификации
        $specs = $productSpecsDao->getAllSpecificationsForProductAdmin($productId);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("HTTP/1.1 500 Internal Server Error", true, 500);
        die();
    } // try-catch

    // Кодируем спецификации в JSON
    header("content-type: application/json");
    echo(json_encode($specs));
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    die();
} // if