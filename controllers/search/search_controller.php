<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует поиск

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Если запрос от AJAX
if (isset($_GET["needle"])) {
    // Echo пустой JSON, если поиск пуст
    if ($_GET["needle"] == "") {
        echo("{}");
    } else {
        // Попытка выполнить соединение с базой данных
        try {
            // DAO товаров
            $searchDao = \models\database\ProductsDao::getInstance();
            // Ищем
            $result = $searchDao->searchProduct($_GET["needle"]);
            // Результат энкодим в JSON
            $resultJson = json_encode($result, JSON_UNESCAPED_SLASHES);
            echo($resultJson);
        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
            error_log($message, 3, "../../errors.log");
            header("HTTP/1.1 500 Internal Server Error", true, 500);
            die();
        } // try-catch
    } // if
// Обычный запрос
} else {
    if (!trim($_GET["search"]) == "") {
        try {
            // DAO товаров
            $searchDao = \models\database\ProductsDao::getInstance();
            // Ищем
            $result = $searchDao->searchProductNoLimit($_GET["search"]);
        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
            error_log($message, 3, "../../errors.log");
            header("HTTP/1.1 500 Internal Server Error", true, 500);
            die();
        } // try-catch
    } else {
        $result = array();
    } // if
} // if