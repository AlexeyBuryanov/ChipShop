<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллит отображение деталей заказа

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

try {
    // Получаем id заказа
    $orderId = $_GET["oid"];
    // DAO заказа
    $orderDao = \models\database\OrdersDao::getInstance();
    // Получаем детали заказа
    $userDetails = $orderDao->getOrderDetails($orderId);
} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
    error_log($message, 3, "../../../errors.log");
    header("location: ../../../views/error/error_500.php");
    die();
} // try-catch