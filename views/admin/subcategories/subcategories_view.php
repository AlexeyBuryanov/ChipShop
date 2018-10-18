<?php // @codingStandardsIgnoreStart
    require_once "../../../controllers/admin/subcategories/view_subcategories_controller.php";
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
        <title>Chip :: Панель администратора :: Подкатегории</title>
        <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
        <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
        <script src="../../../web/assets/js/admin/remove.admin.js"></script>
    </head>
    <body>
        <div align="center">
            <h2>Подкатегории</h2>
            <p>Здесь Вы можете добавлять, редактировать или удалять подкатегории.</p>
            <a href="../admin_panel.php"><button class="btn btn-primary">Назад к админ. панели</button></a>
            <a href="subcategories_create.php"><button class="btn btn-primary">Новая подкатегория</button></a>
        </div>
        <div class="adminMainWindow">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Опции</th>
                </tr>
                <?php
                foreach ($subCats as $subCat) {
                ?>
                    <tr id="delId-<?= $subCat['id'] ?>">
                        <td><?= $subCat["id"] ?></td>
                        <td><a href="../../../views/main/product.php?subcid=<?= $subCat['id'] ?>"><?= $subCat["name"] ?></a></td>
                        <td><?= $subCat["catname"] ?></td>
                        <td>
                            <a href="subcategories_edit.php?scid=<?= $subCat['id'] ?>"><button class="btn btn-warning">Редактировать</button></a>
                            <button class="btn btn-danger" onclick="deleteSubCat(<?= $subCat['id'] ?>)">Удалить</button>
                        </td>
                    </tr>
                <?php
                } // foreach
                ?>
            </table>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>