<!-- Главная страница -->

<?php // @codingStandardsIgnoreStart
// Подключаем контроллер для отображения товаров
require_once "../../controllers/products/home_products_controller.php";
// Подключаем основные заголовки
require_once "../elements/headers.php";
?>

<title>Chip &mdash; магазин электроники - №1</title>

<?php
// Шапка
require_once "../elements/header.php";
// Навигация
require_once "../elements/navigation.php";
?>

<!-- Самые продаваемые товары -->
<div class="main_filtered_products-section">
    <div class="container">
        <h3 class="title">САМЫЕ ПРОДАВАЕМЫЕ</h3>
        <div class="main_filtered_product-info">
            <?php 
                // Проходим по самым продаваемым товарам
                foreach ($mostSold as $product) {
                    // Если есть скидка учитываем её
                    if ($product["percent"] != null) {
                        $promotedPrice = round($product["price"] - (($product["price"] * $product["percent"]) / 100), 2);
                    } else {
                        unset($promotedPrice);
                    } // if ?>

                    <!-- Единица товара -->
                    <div class="products-grd" id="responsiveProductsDiv">
                        <div class="p-one">
                            <a href="single.php?pid=<?= $product["id"]; ?>">
                                <img src="<?= $product["image_url"] ?>" alt="Изображение товара" class="img-responsive"/>
                            </a>
                            <h4><?= $product["title"]; ?></h4>

                            <?php 
                            // Округляем средний рейтинг, если он есть, иначе 0
                            if ($product["average"] === null) {
                                $product["average"] = 0;
                            } else {
                                $product["average"] = round($product["average"], 0);
                            } // if ?>

                            <img class="ratingCatDiv media-object img" src="../../web/assets/images/rating<?= $product["average"] ?>.png">
                            <span>(<?= $product["reviewsCount"] ?>)</span>
                            <br/><br/>

                            <p>
                                <a id="addButtonBlock" class="btn btn-default btn-sm" onclick="addToCart(<?= $product["id"].",".$product["price"] ?>)">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>&nbspВ корзину
                                </a>&nbsp&nbsp
                                <?php
                                // Если есть скидка, меняем стиль отображения цены
                                if (isset($promotedPrice)) {
                                ?>
                                    <span class="item_price valsa" style="color: red;">₴<?= $promotedPrice; ?></span>
                                    <span class="item_price promoValsa">₴<?= $product["price"]; ?></span>
                                <?php
                                // иначе стандартное отображение
                                } else {
                                ?>
                                    <span class="item_price valsa">₴<?= $product["price"]; ?></span>
                                <?php
                                } // if ?>
                            </p>
                            <br/>

                            <div class="pro-grd">
                                <a href="single.php?pid=<?= $product["id"]; ?>">Просмотреть</a>
                            </div>
                        </div>
                    </div>
          <?php } // foreach ?>
          
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<!-- Самые популярные товары -->
<div class="main_filtered_products-section">
    <div class="container">
        <h3 class="title">САМЫЕ ПОПУЛЯРНЫЕ</h3>
        <div class="main_filtered_product-info">
            
            <?php 
                // Проходим по топовым товарам
                foreach ($topRated as $product) {
                    // Если есть скидка учитываем её
                    if ($product["percent"] != null) {
                        $promotedPrice = round($product["price"] - (($product["price"] * $product["percent"]) / 100), 2);
                    } else {
                        unset($promotedPrice);
                    } // if ?>

                    <!-- Единица товара -->
                    <div class="products-grd" id="responsiveProductsDiv">
                        <div class="p-one">
                            <a href="single.php?pid=<?= $product["id"]; ?>">
                                <img src="<?= $product["image_url"] ?>" alt="Product Image" class="img-responsive"/>
                            </a>
                            <h4><?= $product["title"]; ?></h4>

                            <?php 
                            // Округляем средний рейтинг, если он есть, иначе 0
                            if ($product["average"] === null) {
                                $product["average"] = 0;
                            } else {
                                $product["average"] = round($product["average"], 0);
                            } // if ?>

                            <img class="ratingCatDiv media-object img" src="../../web/assets/images/rating<?= $product["average"] ?>.png">
                            <span>(<?= $product["reviewsCount"] ?>)</span>
                            <br/><br/>

                            <p>
                                <a id="addButtonBlock" class="btn btn-default btn-sm" onclick="addToCart(<?= $product["id"].",".$product["price"] ?>)">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>&nbspВ корзину
                                </a>&nbsp&nbsp
                                <?php
                                // Если есть скидка, меняем стиль отображения цены
                                if (isset($promotedPrice)) {
                                ?>
                                    <span class="item_price valsa" style="color: red;">₴<?= $promotedPrice; ?></span>
                                    <span class="item_price promoValsa">₴<?= $product["price"]; ?></span>
                                <?php
                                // иначе стандартное отображение
                                } else {
                                ?>
                                    <span class="item_price valsa">₴<?= $product["price"]; ?></span>
                                <?php
                                } // if
                                ?>
                            </p>
                            <br/>

                            <div class="pro-grd">
                                <a href="single.php?pid=<?= $product["id"]; ?>">Просмотреть</a>
                            </div>
                        </div>
                    </div>
          <?php } // foreach ?>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<!-- Самые последние товары -->
<div class="main_filtered_products-section">
    <div class="container">
        <h3 class="title">САМЫЕ ПОСЛЕДНИЕ</h3>
        <div class="main_filtered_product-info">

            <?php 
                // Проходим по последним товарам
                foreach ($mostRecent as $product) {
                    // Если есть скидка учитываем её
                    if ($product["percent"] != null) {
                        $promotedPrice = round($product["price"] - (($product["price"] * $product["percent"]) / 100), 2);
                    } else {
                        unset($promotedPrice);
                    } // if ?>

                    <!-- Единица товара -->
                    <div class="products-grd" id="responsiveProductsDiv">
                        <div class="p-one">
                            <a href="single.php?pid=<?= $product["id"]; ?>">
                                <img src="<?= $product["image_url"] ?>" alt="Product Image" class="img-responsive"/>
                            </a>
                            <h4><?= $product["title"]; ?></h4>

                            <?php 
                            // Округляем средний рейтинг, если он есть, иначе 0
                            if ($product["average"] === null) {
                                $product["average"] = 0;
                            } else {
                                $product["average"] = round($product["average"], 0);
                            } // if ?>

                            <img class="ratingCatDiv media-object img" src="../../web/assets/images/rating<?= $product["average"] ?>.png">
                            <span>(<?= $product["reviewsCount"] ?>)</span>
                            <br/><br/>
                            
                            <p>
                                <a id="addButtonBlock" class="btn btn-default btn-sm" onclick="addToCart(<?= $product["id"].",".$product["price"] ?>)">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>&nbspВ корзину
                                </a>&nbsp&nbsp
                                <?php
                                // Если есть скидка, меняем стиль отображения цены
                                if (isset($promotedPrice)) {
                                ?>
                                    <span class="item_price valsa" style="color: red;">₴<?= $promotedPrice; ?></span>
                                    <span class="item_price promoValsa">₴<?= $product["price"]; ?></span>
                                <?php
                                // иначе стандартное отображение
                                } else {
                                ?>
                                    <span class="item_price valsa">₴<?= $product["price"]; ?></span>
                                <?php
                                } // if
                                ?>
                            </p>
                            <br/>

                            <div class="pro-grd">
                                <a href="single.php?pid=<?= $product["id"]; ?>">Просмотреть</a>
                            </div>
                        </div>
                    </div>
          <?php } // foreach ?>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php
    // Подвал @codingStandardsIgnoreEnd
    require_once "../elements/footer.php";
?>