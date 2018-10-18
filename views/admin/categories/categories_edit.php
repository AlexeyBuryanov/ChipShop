<?php // @codingStandardsIgnoreStart
    require_once "../../../controllers/admin/categories/edit_category_controller.php";
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
        <title>Chip :: Панель администратора :: Категории :: Редактировать категорию</title>
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    </head>
    <body>
        <div class="page">
            <form action="../../../controllers/admin/categories/edit_category_controller.php" method="post">
                <input type="hidden" name="cat_id" value="<?= $cat['id'] ?>">
                <input type="text" name="name" placeholder="Category name" value="<?= $cat['name'] ?>" maxlength="40" required />
                <br/>
                <select name="supercategory_id" required>
                    <option disabled selected value="">Выберите Суперкатегорию</option>
                    <?php
                        foreach ($supercategories as $supercategory) {
                            echo("<option value=\"".$supercategory['id']."\"");
                            if ($supercategory["id"] == $cat["supercategory_id"]) {
                                echo("selected");
                            } // if
                            echo(">".$supercategory["name"]."</option>");
                        } // foreach
                    ?>
                </select><br/>
                <input type="submit" value="Редактировать" name="submit">
            </form>
            <a href="categories_view.php">
                <button>Назад к категориям</button>
            </a>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>