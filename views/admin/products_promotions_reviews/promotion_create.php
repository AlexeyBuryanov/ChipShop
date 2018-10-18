<?php // @codingStandardsIgnoreStart
    // Включить проверку админа
    require_once "../../../utils/admin_mod_session.php";
    // Проверка, если пользователь заблокирован
    require_once "../../../utils/blocked_user_dir_back.php";
?>

<!DOCTYPE html>
<html lang="ru-RU">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Алексей Бурьянов"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Chip :: Панель администратора :: Товары :: Акции для товара :: Создание акции</title>
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    </head>
    <body>
        <div class="page">
            <form action="../../../controllers/admin/products_promotions_reviews/new_product_promotion_controller.php" method="post">
                Процент: <input type="number" name="percent" placeholder="%" required><br/>
                Формат написания дат: (yyyy-mm-dd hh:mm:ss)<br/>
                Начало: <input type="datetime-local" name="start_date" placeholder="Дата начала" required><br/>
                Конец: <input type="datetime-local" name="end_date" placeholder="Дата завершения" required><br/>
                <input type="hidden" name="product_id" value="<?= $_GET['pid'] ?>">
                <input type="submit" name="submit" value="Добавить акцию">
            </form>
            <a href="promotions_product_view.php?pid=<?= $_GET['pid'] ?>"><button>Назад к акциям</button></a>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>