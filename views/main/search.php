<!-- Поиск -->

<?php // @codingStandardsIgnoreStart
// Контроллер для показа всех результатов
require_once "../../controllers/search/search_controller.php";
// Основные заголовки
require_once "../elements/headers.php";
?>

<title>Chip :: Результаты поиска</title>
</head>

<?php
// Шапка
require_once "../elements/header.php";
// Навигация
require_once "../elements/navigation.php";
?>

<!-- Сетка результатов поиска товаров -->
<div class="products">
    <div class="container">
        <div class="products-grids">
            <?php 
            if (count($result)) {
                $counter = 0;
                foreach ($result as $product) {
                    if ($product["percent"] != null) {
                        $promotedPrice = round($product["price"] - (($product["price"] * $product["percent"]) / 100), 2);
                    } else {
                        unset($promotedPrice);
                    } // if ?>
                    <div class="products-grd" id="responsiveProductsDiv">
                        <div class="p-one">
                            <a href="single.php?pid=<?= $product["id"]; ?>">
                                <img src="<?= $product["image_url"] ?>" alt="Изображение товара" class="img-responsive"/></a>
                            <h4><?= $product["title"]; ?></h4>

                            <?php 
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
                                if (isset($promotedPrice)) { ?>
                                    <span class="item_price valsa" style="color: red;">$<?= $promotedPrice; ?></span>
                                    <span class="item_price promoValsa">$<?= $product["price"]; ?></span>
                                <?php
                                } else { ?>
                                    <span class="item_price valsa">$<?= $product["price"]; ?></span>
                                <?php
                                } // if ?>
                            </p><br/>
                            
                            <div class="pro-grd">
                                <a href="single.php?pid=<?= $product["id"]; ?>">Просмотреть</a>
                            </div>
                        </div>
                    </div>
          <?php } // foreach
            } else {
                echo("<h3 class='title'>НИЧЕГО НЕ НАЙДЕНО</h3>");
            } // if ?>
        </div>
    </div>
</div>

<?php
    // Подвал @codingStandardsIgnoreEnd
    require_once "../elements/footer.php";
?>