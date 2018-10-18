<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Проверяет пользователя на блок на папку ниже

// Стартуем сессию
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // if

// Автозагрузчик файлов моделей
require_once "autoloader_dir_back.php";

// Если пользователь авторизирован
if (isset($_SESSION["loggedUser"])) {
    try {
        // Получаем DAO пользователя
        $userDao = \models\database\UserDao::getInstance();
        // Если пользователь не активен/включен
        if (!$userDao->checkEnabled($_SESSION["loggedUser"])) {
            // Блокируем доступ
            $_SESSION["enabled"] = 0;
        } // if
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../errors.log");
        header("location: ../views/error/error_500.php");
        die();
    } // try-catch

    // Проверяем есть ли у пользователя сессия (если пользователь зарегистрирован)
    if (isset($_SESSION["enabled"]) && $_SESSION["enabled"] == 0) {
        // Уничтожаем текущую сессию
        session_destroy();
        // Перенаправляем на страница входа с уведомлением о блоке
        header("location: ../../views/user/login.php?blocked");
        die();
    } // if
} // if