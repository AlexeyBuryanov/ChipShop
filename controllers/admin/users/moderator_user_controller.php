<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует назначение рядового пользователя на должность модератора и обратно

// Подключаем обработчик ошибок
require_once "../../../utils/error_handler_dir_back.php";
// Подключаем проверку Admina
require_once "../../../utils/admin_session.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Если существует айди пользователя
if (isset($_GET["uid"])) {
    // Валидация
    if (!($_GET["nrole"] == 1 || $_GET["nrole"] == 2)) {
        header("HTTP/1.1 400 Bad Request", true, 400);
        die();
    } // if

    // Попытка выполнить соединение с базой данных
    try {
        $userId = $_GET["uid"];
        $newRole = $_GET["nrole"];
        // DAO юзера
        $userDao = \models\database\UserDao::getInstance();
        // Дать/отнять модератора в зависимости от текущей роли
        $userDao->makeUnmakeModUser($userId, $newRole);
        header("location: ../../../views/admin/users/users_view.php");
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("HTTP/1.1 500 Internal Server Error", true, 500);
        die();
    } // try-catch
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    die();
} // if