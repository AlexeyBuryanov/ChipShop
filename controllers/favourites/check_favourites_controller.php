<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Проверяет есть ли продукт в избранном

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";

session_start();

// Если пользователь вошёл
if (isset($_SESSION["loggedUser"])) {
    $favourites = new \models\Favourites();

    // Попытка выполнить соединение с базой данных
    try {
        // DAO избранного
        $favouritesDao = \models\database\FavouritesDao::getInstance();
        $favourites->setUserId($_SESSION["loggedUser"]);
        $favourites->setProductId($product["id"]);
        // 1, если есть в избранном, а 2 - нет.
        $isFavourite = $favouritesDao->checkFavourites($favourites);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../errors.log");
        header("location: ../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    // Когда isFavourite равно 3, это означает, что пользователь не вошёл
    // (используем цифры т.к. 1 и 2 мы уже имеем)
    $isFavourite = 3;
} // if