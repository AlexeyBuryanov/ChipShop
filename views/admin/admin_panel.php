<!-- Панель администратора -->

<?php // @codingStandardsIgnoreStart

// Стартуем сессию
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // if

// Проверяем есть ли у пользователя сессия (если пользователь вошёл)
if (!isset($_SESSION["role"]) || $_SESSION["role"] == 1) {
    // Перенаправляем на ошибку
    header("location: ../../views/error/error_400.php");
    die();
} // if

// Проверяем вдруг пользователь заблокирован
require_once "../../utils/blocked_user.php";

// Подключаем заголовочные файлы
require_once "../elements/headers.php";
?>

<!-- <!DOCTYPE html> -->
<!-- <html lang="ru-RU"> -->
    <!-- <head> -->
        <title>Chip :: Панель администратора</title>
        <link rel="stylesheet" href="../../web/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../web/assets/css/adminPanel.css">
        <link rel="stylesheet" href="../../web/assets/css/font-awesome.min.css">
    <!-- </head> -->
    <?php
    // Подключаем шапку
    require_once "../elements/header.php";
    ?>
    <!-- <body> -->
        <br/><br/><br/><br/>
        <a href="../main/index.php"><button class="btn btn-primary">Главная</button></a>
        <div align="center">
            <h3>Добро пожаловать! Что бы Вы хотели проверить?</h3>
            <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == 3) { ?>
            <a href="supercategories/supercategories_view.php">
                <button class="btn btn-sq-lg btn-primary">
                    <i class="fa fa-th-large fa-4x" aria-hidden="true"></i><br/>Суперкатегории
                </button>
            </a>
            <a href="categories/categories_view.php">
                <button class="btn btn-sq-lg btn-primary">
                    <i class="fa fa-th fa-4x" aria-hidden="true"></i><br/>Категории
                </button>
            </a>
            <a href="subcategories/subcategories_view.php">
                <button class="btn btn-sq-lg btn-primary">
                    <i class="fa fa-th-list fa-4x" aria-hidden="true"></i><br/>Подкатегории
                </button>
            </a>
            <a href="subcategory_specs/subcat_specs_view.php">
                <button class="btn btn-sq-lg btn-primary">
                    <i class="fa fa-info fa-4x" aria-hidden="true"></i><br/>Спецификации<br/>подкатегорий
                </button>
            </a><br/>
            <?php } // if ?>
            <a href="products_promotions_reviews/products_view.php">
                <button class="btn btn-sq-lg btn-primary">
                    <i class="fa fa-cubes fa-4x" aria-hidden="true"></i><br/>Товары и<br/>Акции
                </button>
            </a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 3) { ?>
            <a href="users/users_view.php">
                <button class="btn btn-sq-lg btn-primary">
                    <i class="fa fa-user fa-4x" aria-hidden="true"></i><br/>Пользователи
                </button>
            </a>
            <?php } // if ?>
            <a href="orders/orders_view.php">
                <button class="btn btn-sq-lg btn-primary">
                    <i class="fa fa-plane fa-4x" aria-hidden="true"></i><br/>Заказы
                </button>
            </a>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>