<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует создание токкена для сброса пароля

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";
// Проверка, если пользователь выполнил вход
require_once "../../utils/session_main.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

if (!empty($_POST["email"])) {
    $userEmail = $_POST["email"];
    $user = new \models\User;

    try {
        // DAO пользователя
        $userDao = \models\database\UserDao::getInstance();
        $user->setEmail($userEmail);
        
        // Проверяем пользователя в базе, если такого нет - ошибка
        if (!($userDao->checkUserExist($user))) {
            header("location: ../../views/user/forgotten.php?error");
            die();
        } // if

        // Используем алгоритм шифрования SHA256
        $tokken = hash('sha256', $userEmail.microtime());

        // Отправляем токкен
        include_once "send_tokken_controller.php";

        // Храним в сессии email, tokken и время
        $_SESSION["passReset"]["email"] = $userEmail;
        $_SESSION["passReset"]["tokken"] = $tokken;
        $_SESSION["passReset"]["time"] = time();

        header("location: ../../views/user/forgotten.php?tokken");
        die();
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../errors.log");
        header("location: ../../views/error/error_500.php");
        die();
    } // try-catch
} // if

// Когда токен получен
if (!empty($_POST["tokken"])) {
    $tokkenReceive = $_POST["tokken"];
    $tokken = $_SESSION["passReset"]["tokken"];
    $email = $_SESSION["passReset"]["email"];

    if ($tokkenReceive == $tokken) {
        header("location: ../../views/user/newPass.php");
        die();
    } else {
        session_destroy();
        header("location: ../../views/user/forgotten.php?errorTokken");
        die();
    } // if
} // if