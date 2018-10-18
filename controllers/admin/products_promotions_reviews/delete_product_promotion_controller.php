<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Удаление акции на товар

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

// Если есть id акции
if (isset($_GET["prid"])) {
    // Попытка выполнить соединение с базой данных
    try {
        $promoId = $_GET["prid"];
        // DAO акций
        $promoDao = \models\database\PromotionsDao::getInstance();
        // Удаляем
        $promoDao->deletePromotion($promoId);
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