<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует создание новых спецификаций товара

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

// Если существует айди подкатегории
if (isset($_GET["scid"])) {
    $subCatId = $_GET["scid"];

    try {
        // DAO спецификаций
        $specsDao = \models\database\SubcatSpecificationsDao::getInstance();
        // Получаем спецификации для данной подкатегории
        $specs = $specsDao->getAllSpecificationsForSubcategory($subCatId);
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