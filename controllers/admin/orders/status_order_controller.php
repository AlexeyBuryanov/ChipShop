<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует статус заказа

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

// Если есть id заказа
if (isset($_GET["oid"])) {
    try {
        $orderId = $_GET["oid"];
        $newStatus = $_GET["ns"];
        // DAO заказа
        $orderDao = \models\database\OrdersDao::getInstance();
        // Меняем статус заказа
        $userEmail = $orderDao->changeOrderStatus($orderId, $newStatus);

        // Статус может быть только 4-х типов
        if (!($newStatus == 1 
            || $newStatus == 2 
            || $newStatus == 3 
            || $newStatus == 4)
        ) {
            header("HTTP/1.1 400 Bad Request", true, 400);
            die();
        } // if

        if ($newStatus == 2) {
            $status = "был отправлен!";
        } else if ($newStatus == 3) {
            $status = "был доставлен!";
        } else if ($newStatus == 4) {
            $status = "был отменён!";
        } // if

        if ($newStatus != 1) {
            // Отправляем новый статус пользователю
            include_once "send_status_change.php";
        } // if
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("location: ../../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    die();
} // if