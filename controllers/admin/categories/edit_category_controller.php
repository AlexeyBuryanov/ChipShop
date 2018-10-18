<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Коньроллирует редактирование категории

// Подключаем обработчик ошибок
require_once "../../../utils/error_handler_dir_back.php";
// Подключаем проверку Admin/Mod
require_once "../../../utils/admin_session.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Если действие подтверждено
if (isset($_POST["submit"])) {
    $category = new \models\Category();

    // Валидация ввода
    if (empty($_POST["name"]) || strlen($_POST["name"]) > 40) {
        header("Location: ../../../views/error/error_400.php");
        die();
    } // if

    // Попытка выполнить соединение с базой данных
    try {
        // DAO категории
        $catDao = \models\database\CategoriesDao::getInstance();
        // Устанавливаем новые данные
        $category->setName(htmlentities($_POST["name"]));
        $category->setSupercategoryId(htmlentities($_POST["supercategory_id"]));
        $category->setId($_POST["cat_id"]);
        // Редактируем
        $catDao->editCategory($category);
        header("location: ../../../views/admin/categories/categories_view.php");
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("location: ../../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    try {
        $catId = $_GET["cid"];
        $supercatDao = \models\database\SuperCategoriesDao::getInstance();
        $catDao = \models\database\CategoriesDao::getInstance();
        $supercategories = $supercatDao->getAllSuperCategories();
        $cat = $catDao->getCategoryById($catId);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("location: ../../../views/error/error_500.php");
        die();
    } // try-catch
} // if