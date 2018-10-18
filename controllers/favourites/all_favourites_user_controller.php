<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует все избранные товары пользователя

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

// Если пользователь вошёл
if (isset($_SESSION["loggedUser"])) {
    // Товары
    $products = null;
    // Избранное
    $favourites = new \models\Favourites();
    $favourites->setUserId($_SESSION["loggedUser"]);

    // Попытка выполнить соединение с базой данных
    try {
        // Получаем избранное из БД
        $favouritesDao = \models\database\FavouritesDao::getInstance();
        $products = $favouritesDao->getAllFavourites($favourites);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../errors.log");
        header("location: ../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    header("location: ../../views/error/error_400.php");
    die();
} // if