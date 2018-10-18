<?php // @codingStandardsIgnoreStart
    require_once "../../../controllers/admin/supercategories/edit_supercategory_controller.php";
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
        <title>Chip :: Панель администратора :: Суперкатегории :: Редактировать суперкатегорию</title>
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    </head>
    <body>
        <div class="page">
            <form action="../../../controllers/admin/supercategories/edit_supercategory_controller.php" method="post">
                <input type="hidden" name="supercat_id" value="<?= $superCat['id'] ?>">
                Название:<br/>
                <input type="text" name="name" placeholder="Название суперкатегории" value="<?= $superCat['name'] ?>" maxlength="40" required style="width: 300px"/><br/>
                <input type="submit" value="Редактировать" name="submit">
            </form>
            <a href="supercategories_view.php"><button>Назад к суперкатегориям</button></a>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>