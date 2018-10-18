<?php // @codingStandardsIgnoreStart
    require_once "../../../controllers/admin/products_promotions_reviews/edit_product_controller.php";
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
        <title>Chip :: Панель администратора :: Товары :: Редактирование товара</title>
        <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
        <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
        <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
        <script src="../../../web/assets/js/admin/product.specs.js"></script>
        <script src="../../../web/assets/js/admin/product.specs.edit.js"></script>
    </head>
    <body onload="loadFilledSpecs()">
        <div class="page">
            <form enctype="multipart/form-data" action="../../../controllers/admin/products_promotions_reviews/edit_product_controller.php" method="post">
                <input type="hidden" name="pid" value="<?= $product['id'] ?>">
                <input type="hidden" name="scid" value="<?= $product['subcategory_id'] ?>">
                Заголовок: <input type="text" name="title" placeholder="Заголовок" value="<?= $product['title'] ?>" maxlength="40" required/><br/>
                Описание: <textarea name="description" placeholder="Описание" maxlength="150000" required><?= $product['description'] ?></textarea><br/>
                Цена: <input type="number" name="price" step="1.00" placeholder="Цена" value="<?= $product['price'] ?>" min="0" maxlength="10000000" required/><br/>
                Количество: <input type="number" name="quantity" placeholder="Количество" value="<?= $product['quantity'] ?>" min="0" maxlength="1000000000" required/><br/><br/><br/>
                Изображения (Все или ни одного):<br/>
                <input type="file" name="pic1"><br/>
                <input type="file" name="pic2"><br/>
                <input type="file" name="pic3"><br/><br/><br/>
                Подкатегория и спецификации:<br/><br/>
                Выберите подкатегорию
                <select id="selectSubCatId" onchange="loadSpecs()" name="subcategory_id" required>
                    <option disabled selected value="">Выберите подкатегорию</option>
                    <?php
                    foreach ($subcategories as $subcategory) {
                    ?>
                        <option value="<?= $subcategory['id'] ?>"
                            <?php
                            if ($subcategory["id"] == $product["subcategory_id"]) {
                                echo("selected");
                            } // if
                            ?>
                        ><?= $subcategory['name'] ?></option>
                    <?php
                    } // foreach
                    ?>
                </select><br/>
                <div id="specsWindow"></div>
                <br/><br/><br/><br/>
                <input type="submit" value="Редактировать товар" name="submit">
            </form>
            <a href="products_view.php"><button>Назад к товарам</button></a>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>