<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует удаление отзыв

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

session_start();

// Если пользователь вошёл и это не простой смертный
if (isset($_SESSION["loggedUser"]) && ($_SESSION["role"] == 3 || $_SESSION["role"] == 2)) {
    try {
        // DAO обзоров
        $reviewDao = \models\database\ReviewsDao::getInstance();
        // Удаляем обзор
        $reviewDao->removeReview($_GET["rev"]);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../errors.log");
        header("location: ../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    header("location: ../../views/error/error_403.php");
    die();
} // if
