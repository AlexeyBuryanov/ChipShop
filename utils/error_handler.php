<?php
// @codingStandardsIgnoreStart

// Обработка ошибок

// Обработка ошибки 500
if (!function_exists("Error500")) {
    function Error500($errno, $errmsg) { // @codingStandardsIgnoreEnd
        // Формируем сообщение
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $errno $errmsg  \n";
        // Логируем сообщение
        error_log($message, 3, "../../errors.log");
        // Перенаправляем пользователя на страницу с ошибкой
        header("location: ../../views/error/error_500.php");
        die();
    } // Error500
} // if

// Установить обработчик ошибок
set_error_handler("Error500");