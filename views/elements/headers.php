<?php // @codingStandardsIgnoreStart
// Стартуем сессию, если по какой-то причине её нет
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // if
// Проверяем вдруг пользователь заблокирован
require_once "../../utils/blocked_user.php";
?>

<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="author" content="Алексей Бурьянов"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Bootstrap CSS -->
    <link href="../../web/assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <!-- Главные стили CSS -->
    <link href="../../web/assets/css/style.css" rel="stylesheet" type="text/css"/>
    <!-- Навигация CSS -->
    <link href="../../web/assets/css/megaMenu.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- JQuery -->
    <script type="text/javascript" src="../../web/assets/js/jquery-1.11.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script type="text/javascript" src="../../web/assets/js/bootstrap.js"></script>
    <!-- Поиск JS -->
    <script type="text/javascript" src="../../web/assets/js/search.js"></script>
    <!-- Навигация JS -->
    <script type="text/javascript" src="../../web/assets/js/mega.menu.js"></script>
    <!-- Корзина JS -->
    <script type="text/javascript" src="../../web/assets/js/cart/add.cart.js"></script>
    <!-- Footer slider JS -->
    <script type="text/javascript" src="../../web/assets/js/jquery.footer.slider.js"></script>
    <!-- Корзина при наведении JS -->
    <script type="text/javascript" src="../../web/assets/js/cart/cart.hover.js"></script>

    <!-- Шрифты -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,300italic,600,700" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Roboto+Slab:300,400,700" rel="stylesheet" type="text/css">
<?php // @codingStandardsIgnoreEnd ?>