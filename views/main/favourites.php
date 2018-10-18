<!-- Избранные товары -->

<?php // @codingStandardsIgnoreStart
// Подключаем контроллер всех избранных товаров
require_once "../../controllers/favourites/all_favourites_user_controller.php";
// Подключаем основные заголовки
require_once "../elements/headers.php";
?>

<!-- Для удаления товаров из избранного -->
<script type="text/javascript" src="../../web/assets/js/favourites.js"></script>

<title>Chip :: Избранное</title>

<?php
// Подключаем шапку 
require_once "../elements/header.php";
// Подключаем навигацию
require_once "../elements/navigation.php";
?>

<!-- Избранные товары -->
<div class="cart-items">
    <div class="container">
        <h3 id="favouritesTitle" class="title">
            <?= (count($products) ? "Избранное" : "Не найдено избранных товаров!") ?>
        </h3>

        <?php 
            foreach ($products as $product) { ?>
                <div id="deleteItem<?= $product["id"] ?>">
                    <div class="cart-header">
                        <div class="close1" onclick="removeFavouriteList(<?= $product['id'] ?>)"></div>
                        <div class="cart-sec simpleCart_shelfItem">
                            <div class="cart-item cyc">
                                <a href="single.php?pid=<?= $product["id"] ?>">
                                    <img src="<?= $product["image_url"] ?>" class="img-responsive" alt="">
                                </a>
                            </div>
                            <div class="cart-item-info">
                                <h3><a href="single.php?pid=<?= $product["id"] ?>"> <?= $product["title"] ?> </a></h3>
                                <div class="delivery">
                                    <p>₴<?= $product["price"] ?></p>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
      <?php } // foreach ?>
    </div>
</div>

<?php
    // Подвал @codingStandardsIgnoreEnd
    require_once "../elements/footer.php";
?>