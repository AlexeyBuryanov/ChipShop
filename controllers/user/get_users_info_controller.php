<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует получение информации о пользователе

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";
// Проверка для сессии
require_once "../../utils/no_session_main.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Получаем объект юзера
$user = new \models\User();

// Попытка выполнить соединение с базой данных
try {
    $userDao = \models\database\UserDao::getInstance();
    $user->setId($_SESSION["loggedUser"]);

    // Получаем массив с информацией пользователя
    $userArr = $userDao->getUserInfo($user);
} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
    error_log($message, 3, "../../errors.log");
    header("location: ../../views/error/error_500.php");
    die();
} // try-catch