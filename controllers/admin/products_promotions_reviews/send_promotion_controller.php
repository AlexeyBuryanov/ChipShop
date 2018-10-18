<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Отправляет письмо-уведомление о старте акции

// Подключаем обработчик ошибок
require_once "../../../utils/error_handler.php";
// Подключаем проверку Admin/Mod
require_once "../../../utils/admin_mod_session.php";

// Импортировать классы PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Загрузка автолоадера композера
require "../../../vendor/autoload.php";

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
    // Включаем аутентификацию SMTP
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
    
    // От кого
    $mail->setFrom("dave.mayson@mail.ru", "Chip");

    // Получатели
    foreach ($subscribedUsers as $userEmail) {
        // Добавляем
        $mail->addAddress($userEmail["email"], $userEmail["email"]);
    } // foreach

    // Настройка формата электронной почты
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "Chip | Акция на товар \"".$productInfo["title"]."\"";
    $mail->Body = "Уважаемый покупатель!<br><br>Товар \"".$productInfo["title"]."\" будет продаваться со скидкой в ".$percent.
                  "%.<br><br>Начало акции ".$startDate." по ".$endDate." включительно.<br><br>Спасибо, что посещаете наш сайт!<br><br><br>".
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