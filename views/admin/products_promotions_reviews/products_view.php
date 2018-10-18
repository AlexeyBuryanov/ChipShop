<?php // @codingStandardsIgnoreStart
    require_once "../../../controllers/admin/products_promotions_reviews/view_products_controller.php";
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
        <title>Chip :: Панель администратора :: Товары</title>
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
        <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
        <script src="../../../web/assets/js/admin/remove.admin.js"></script>
    </head>
    <body>
        <div align="center">
            <h2>Товары</h2>
            <p>Здесь Вы можете добавлять, редактировать или удалять товары.</p>
            <a href="../admin_panel.php"><button class="btn btn-primary">Назад к админ. панели</button></a>
            <a href="product_create.php"><button class="btn btn-primary">Новый товар</button></a>
        </div>
        <div class="adminMainWindow">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Заголовок</th>
                    <!-- <th>Описание</th> -->
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Видимость</th>
                    <th>Когда создан</th>
                    <th>Название подкатегории</th>
                    <th>Опции</th>
                </tr>
                <?php
                foreach ($products as $product) {
                ?>
                    <tr>
                        <td><?= $product["id"] ?></td>
                        <td><a href="../../../views/main/single.php?pid=<?= $product['id'] ?>"><?= $product["title"] ?></a></td>
                        <!-- <td style="font-size: 80%; max-width: 150px;
                                   overflow: hidden; text-overflow: ellipsis;
                                   white-space: nowrap;">< //$product["description"] ?></td> -->
                        <td><?= $product["price"] ?></td>
                        <td><?= $product["quantity"] ?></td>
                        <td id="togId-<?= $product['id'] ?>"><?= ($product["visible"] == 1 ? "Да" : "Нет") ?></td>
                        <td><?= $product["created_at"] ?></td>
                        <td><?= $product["subcat_name"] ?></td>
                        <td>
                            <a href="product_edit.php?pid=<?= $product['id'] ?>"><button class="btn btn-warning">Редактировать</button></a>
                            <button class="btn btn-danger" onclick="toggleVisibility(<?= $product['id'].", ".$product['visible'] ?>)">Переключить видимость</button>
                            <a href="promotions_product_view.php?pid=<?= $product['id'] ?>"><button class="btn btn-success">Акции</button></a>
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