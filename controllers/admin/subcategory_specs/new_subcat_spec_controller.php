<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Создание новой  спецификации подкатегории

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

if (isset($_POST["submit"])) {
    $specification = new \models\SubcatSpecification();

    // Проверка введённых данных
    if (empty($_POST["name"]) || strlen($_POST["name"]) > 40) {
        header("location: ../../../views/error/error_400.php");
        die();
    } // if

    // Попытка выполнить соединение с базой данных
    try {
        $specDao = \models\database\SubcatSpecificationsDao::getInstance();

        $specification->setName(htmlentities($_POST["name"]));
        $specification->setSubcategoryId(htmlentities($_POST["subcategory_id"]));

        $id = $specDao->createSpecification($specification);

        header("location: ../../../views/admin/subcategory_specs/subcat_specs_view.php");
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("location: ../../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    $subcatDao = \models\database\SubCategoriesDao::getInstance();
    $subcategories = $subcatDao->getAllSubCategoriesWithoutProducts();
} // if