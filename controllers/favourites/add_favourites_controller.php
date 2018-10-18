<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует добавление в избранное

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";
// Проверка сессии
require_once "../../utils/no_session_main.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Если пользователь вошёл и существует id товара
if (isset($_SESSION["loggedUser"]) && isset($_GET["product_id"])) {
    // Получаем айди юзера и товара
    $userId = $_SESSION["loggedUser"];
    $productId = $_GET["product_id"];
    // Создаём объект избранного для работы с ним
    $favourites = new \models\Favourites();

    try {
        // DAO избранного
        $favouritesDao = \models\database\FavouritesDao::getInstance();
        $favourites->setUserId($userId);
        $favourites->setProductId($productId);
        // Добавляем в избранное
        $favouritesDao->addFavourite($favourites);
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