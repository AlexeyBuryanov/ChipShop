<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Удаление подкатегории

// Подключаем обработчик ошибок
require_once "../../../utils/error_handler_dir_back.php";
// Подключаем проверку Admin
require_once "../../../utils/admin_session.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Если существует айди подкатегории
if (isset($_GET["scid"])) {
    // Попытка выполнить соединение с базой данных
    try {
        $subcatId = $_GET["scid"];
        // DAO подкатегории
        $subcatDao = \models\database\SubCategoriesDao::getInstance();
        // Удаляем
        $subcatDao->deleteSubCategory($subcatId);
        header("location: ../../../views/admin/subcategories/subcategories_view.php");
        die();
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