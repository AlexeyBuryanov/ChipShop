<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует навигацию

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
    // Получаем объекты DAO для всех категорий
    $supercatDao = \models\database\SuperCategoriesDao::getInstance();
    $catDao = \models\database\CategoriesDao::getInstance();
    $subcatDao = \models\database\SubCategoriesDao::getInstance();

    // Получаем все нужные категории
    $supercategories = $supercatDao->getAllSuperCategories();
    $categories = $catDao->getAllCategories();
    $subcategories = $subcatDao->getAllSubCategories();
} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
    error_log($message, 3, "../../errors.log");
    header("location: ../../views/error/error_500.php");
    die();
} // try-catch