<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Создание подкатегории

// Подключаем обработчик ошибок
require_once "../../../utils/error_handler_dir_back.php";
// Подключаем проверку Admin
require_once "../../../utils/admin_session.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\..\\" . $className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Если действие подтверждено
if (isset($_POST["submit"])) {
    $subcategory = new \models\SubCategory();

    // Проверка введённых данных
    if (empty($_POST["name"]) || strlen($_POST["name"]) > 40) {
        header("location: ../../../views/error/error_400.php");
        die();
    } // if

    // Попытка выполнить соединение с базой данных
    try {
        // DAO подкатегорий
        $subcatDao = \models\database\SubCategoriesDao::getInstance();
        // Устанавливаем данные подкатегории
        $subcategory->setName(htmlentities($_POST["name"]));
        $subcategory->setCategoryId(htmlentities($_POST["category_id"]));
        // Создаём
        $id = $subcatDao->createSubCategory($subcategory);
        header("location: ../../../views/admin/subcategories/subcategories_view.php");
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("location: ../../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    try {
        $catDao = \models\database\CategoriesDao::getInstance();
        $categories = $catDao->getAllCategories();
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("location: ../../../views/error/error_500.php");
        die();
    } // try-catch
} // if