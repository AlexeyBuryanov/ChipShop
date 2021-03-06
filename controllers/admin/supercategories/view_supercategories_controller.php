<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует отображение суперкатегорий

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

try {
    // DAO суперкатегорий
    $superCatDao = \models\database\SuperCategoriesDao::getInstance();
    // Получить все суперкатегории
    $superCats = $superCatDao->getAllSuperCategories();
} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
    error_log($message, 3, "../../../errors.log");
    header("location: ../../../views/error/error_500.php");
    die();
} // try-catch