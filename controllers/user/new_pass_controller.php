<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует установку нового пароля, то есть его сброс

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";
// Проверка для сессии
require_once "../../utils/session_main.php";

// Если в сессии вообще есть passReset
if (!isset($_SESSION["passReset"])) {
    header("location: ../../views/user/login.php");
    die();
} // if

// Если прошло 10 минут с момента отправки токена сброса
if (abs(($_SESSION["passReset"]["time"] - time())) > 600) {
    // Дестроим сессию
    session_destroy();
    header("location: ../../views/user/login.php");
    die();
} // if

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

if (!empty($_POST["pass1"]) && !empty($_POST["pass2"])) {
    $pass1 = $_POST["pass1"];
    $pass2 = $_POST["pass2"];

    // Если пароли не совпадают
    if (!($pass1 == $pass2)) {
        header("location: ../../views/user/newPass.php?errorPassMatch");
        die();
    } // if

    // Если с длинной пароля всё ок
    if (strlen($pass1) >= 4 && strlen($pass1) <= 20) {
        $user = new models\User;

        try {
            // DAO пользователя
            $userDao = models\database\UserDao::getInstance();
            $user->setPassword(hash('sha256', $pass1));
            $user->setEmail($_SESSION["passReset"]["email"]);
            // Сбрасываем пароль
            $userDao->resetPassword($user);
            // Дестроим сессию
            session_destroy();
            header("location: ../../views/user/login.php");
            die();
        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
            error_log($message, 3, "../../errors.log");
            header("location: ../../views/error/error_500.php");
            die();
        } // try-catch
    } else {
        header("location: ../../views/user/newPass.php?errorPassSyntax");
        die();
    } // if
} else {
    header("location: ../../views/user/newPass.php?errorPassSyntax");
} // if