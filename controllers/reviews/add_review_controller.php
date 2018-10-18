<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует добавление отзыва

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

session_start();

// Если юзер вошёл
if (isset($_SESSION["loggedUser"])) {
    // @codingStandardsIgnoreStart
    // Проверка вводимых данных
    if (isset($_POST["rating"]) && isset($_POST["title"]) && isset($_POST["review"]) 
        && isset($_GET["pid"]) && strlen($_POST["review"]) >= 3 && strlen($_POST["review"]) <= 255
        && strlen($_POST["title"]) >= 3 && strlen($_POST["title"]) <= 20
        && $_POST["rating"] >= 1 && $_POST["rating"] <= 5) { // @codingStandardsIgnoreEnd
    
        // Создаём объект отзывов
        $review = new \models\Reviews();

        // Устанавливаем параметры
        $review->setRating(htmlentities($_POST["rating"]));
        $review->setTitle(htmlentities($_POST["title"]));
        $review->setComment(htmlentities($_POST["review"]));
        $review->setUserId($_SESSION["loggedUser"]);
        $review->setProductId($_GET["pid"]);

        try {
            // DAO отзывов
            $reviewDao = \models\database\ReviewsDao::getInstance();
            // Добавляем новый отзыв
            $reviewDao->addNewReview($review);
            // Перенаправляем на страницу с товаром на который оставили отзыв
            header("location: ../../views/main/single.php?pid=".$_GET["pid"]);
            die();
        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
            error_log($message, 3, "../../errors.log");
            header("location: ../../views/error/error_500.php");
            die();
        } // try-catch
    } else {
        header("location: ../../views/error/error_400.php");
        die();
    } // if
} else {
    header("location: ../../views/main/index.php");
    die();
} // if