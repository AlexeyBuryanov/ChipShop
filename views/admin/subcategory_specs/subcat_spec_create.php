<?php // @codingStandardsIgnoreStart
    require_once "../../../controllers/admin/subcategory_specs/new_subcat_spec_controller.php";
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
        <title>Chip :: Панель администратора :: Спецификации подкатегории :: Новая спецификация</title>
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    </head>
    <body>
        <div class="page">
            <form action="../../../controllers/admin/subcategory_specs/new_subcat_spec_controller.php" method="post">
                <input type="text" name="name" placeholder="Заголовок" maxlength="40" required/><br/>
                <select name="subcategory_id" required>
                    <option disabled selected value="">Выберите подкатегорию</option>
                    <?php
                    foreach ($subcategories as $subcategory) {
                        echo("<option value=\"".$subcategory['id']."\">".$subcategory['name']."</option>");
                    } // foreach
                    ?>
                </select><br/>
                <input type="submit" value="Создать" name="submit">
            </form>
            <a href="subcat_specs_view.php"><button>Назад к спецификациям подкатегории</button></a>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>