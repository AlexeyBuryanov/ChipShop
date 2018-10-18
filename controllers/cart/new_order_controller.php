<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует новый заказ

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

// Если корзина не пустая
if (isset($_SESSION["cart"])) {
    $cart = $_SESSION["cart"];

    // Проверка для зарегистрированного пользователя
    if (!empty($_SESSION["loggedUser"])) {
        $userId = $_SESSION["loggedUser"];
    } else {
        header("location: ../../views/user/login.php");
        die();
    } // if

    // DAO юзера
    $userDao = \models\database\UserDao::getInstance();
    // Создаём объект юзера
    $user = new \models\User();
    $user->setId($userId);

    // Если адреса не сущесвует - просим ввести
    if (!($userDao->checkAddressSet($user))) {
        header("location: ../../views/user/edit.php?addAddress#address");
        die();
    } // if

    // Создаём объект заказа
    $order = new \models\Order($userId, $cart);

    try {
        // DAO заказов
        $ordersDao = \models\database\OrdersDao::getInstance();

        // Создаём новый заказ
        $result = $ordersDao->newOrder($order, $cart);
        if ($result === false) {
            header("location: ../../views/error/error_500.php");
            die();
        } // if
        $orderId = $result[0];
        $totalPrice = $result[1];
        $quantity = $result[2];
        $userEmail = $result[3];

        // Отправляем письмо пользователю о подтверждении заказа
        include_once "send_order_confirm.php";

        // Очищаем корзину
        unset($_SESSION["cart"]);

        // Храним в сессии данные о покупке
        $_SESSION["oid"] = $orderId;
        $_SESSION["oItems"] = $quantity;
        $_SESSION["oTotalPrice"] = $totalPrice;
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../errors.log");
        header("location: ../../views/error/error_500.php");
        die();
    } // try-catch
    header("location: ../../views/main/checkout.php");
    die();
} else {
    header("location: ../../views/error/error_400.php");
    die();
} // if