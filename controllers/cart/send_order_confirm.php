<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Отправляет письмо о подтверждении заказа

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";

// Импортировать классы PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Загрузка автолоадера композера
require "../../vendor/autoload.php";

// Передача `true` допускает исключения
$mail = new PHPMailer(true);

try {
    // Серверные настройки
    // ------------------------------------------------
    // Включаем подробный вывод отладки
    $mail->SMTPDebug = 2;
    // Устанавливаем мэйлер на использование SMTP
    $mail->isSMTP();
    // Специфицируем основные и резервные серверы SMTP
    $mail->Host = "smtp.mail.ru";
    // Включить аутентификацию SMTP
    $mail->SMTPAuth = true;
    // SMTP username
    $mail->Username = "dave.mayson@mail.ru";
    // SMTP password
    $mail->Password = "MaY_son___1337";
    // Включаем шифрование SSL
    $mail->SMTPSecure = "SSL";
    // TCP-порт для подключения
    $mail->Port = 587;
    $mail->SMTPOptions = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
            "allow_self_signed" => true
        )
    );

    // Отправитель
    $mail->setFrom("dave.mayson@mail.ru", "Chip");
    // Добавить получателя
    $mail->addAddress($userEmail, $userEmail);

    // Содержание ----------------------------------
    // Формат почты - HTML
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "Chip | Заказ получен";
    $mail->Body = "Ваш заказ с идентификатором <q><b>$orderId</b></q> был получен и обрабатывается!<br><br>".
                  "<b><i><small>Chip &mdash; магазин электроники - №1</small></i></b>";

    // Отправляем
    $mail->send();
    $mail->clearAddresses();
    $mail->clearAttachments();
} catch (Exception $e) {
    $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
    error_log($message, 3, "../../errors.log");
    header("location: ../../views/error/error_500.php");
    die();
} // try-catch