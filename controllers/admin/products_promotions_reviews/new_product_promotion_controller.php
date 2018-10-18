<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует создание акции для товара

// Подключаем обработчик ошибок
require_once "../../../utils/error_handler_dir_back.php";
// Подключаем проверку Admin/Mod
require_once "../../../utils/admin_mod_session.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

if (isset($_POST["submit"])) {
    // @codingStandardsIgnoreStart | Валидация
    if (empty($_POST["percent"]) ||
        empty($_POST["start_date"]) ||
        empty($_POST["end_date"]) ||
        empty($_POST["product_id"])) {
        header("location: ../../../views/error/error_400.php");
        die();
    } // @codingStandardsIgnoreEnd

    $percent = $_POST["percent"];
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $productId = $_POST["product_id"];

    // Объект акции
    $promotion = new \models\Promotion($percent, $startDate, $endDate, $productId);

    // Попытка выполнить соединение с базой данных
    try {
        // DAO акции
        $promoDao = \models\database\PromotionsDao::getInstance();
        // DAO избранного
        $favDao = \models\database\FavouritesDao::getInstance();
        // DAO товаров
        $productsDao = \models\database\ProductsDao::getInstance();
        // Создаём акцию
        $id = $promoDao->createPromotion($promotion);
        // Инфо о товаре
        $productInfo = $productsDao->getProductByID($productId);
        // Получаем подписанных пользователей на данный товар
        $subscribedUsers = $favDao->subscribedUsersForProduct($productId);

        // Проверить подписчиков
        if (!empty($subscribedUsers)) {
            // Разослать письма о старте акции
            include_once "send_promotion_controller.php";
        } // if

        header("location: ../../../views/admin/products_promotions_reviews/promotions_product_view.php?pid=".$productId);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("location: ../../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    header("location: ../../../views/error/error_400.php");
    die();
} // if