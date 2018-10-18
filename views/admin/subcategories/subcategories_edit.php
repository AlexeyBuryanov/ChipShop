<?php // @codingStandardsIgnoreStart
    require_once "../../../controllers/admin/subcategories/edit_subcategory_controller.php";
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
        <title>Chip :: Панель администратора :: Подкатегории :: Редактировать подкатегорию</title>
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    </head>
    <body>
        <div class="page">
            <form action="../../../controllers/admin/subcategories/edit_subcategory_controller.php" method="post">
                <input type="hidden" name="subcat_id" value="<?= $subcat['id'] ?>">
                <input type="text" name="name" placeholder="Название подкатегории" value="<?= $subcat['name'] ?>" maxlength="40" required/><br/>
                <select name="category_id" required>
                    <option disabled selected value="">Выберите категорию</option>
                    <?php
                    foreach ($categories as $category) {
                        echo("<option value=\"".$category['id']."\"");
                        if ($category['id'] == $subcat['category_id']) {
                            echo("selected");
                        } // if
                        echo(">".$category["name"]."</option>");
                    } // foreach
                    ?>
                </select><br/>
                <input type="submit" value="Редактировать" name="submit">
            </form>
            <a href="subcategories_view.php"><button>Назад к подкатегориям</button></a>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>