<!-- Единица товара -->

<?php // @codingStandardsIgnoreStart
// Подключаем контроллер для отображения товара
require_once "../../controllers/products/single_product_controller.php";
// Подключаем контроллер для проверки, находится ли продукт в избранном, если пользователь зарегистрирован
require_once "../../controllers/favourites/check_favourites_controller.php";
// Подключаем основные заголовки
require_once "../elements/headers.php";
?>

<!-- CSS Flex Slider -->
<link rel="stylesheet" href="../../web/assets/css/flexSliderJQuery.css" type="text/css" media="screen"/>
<!-- CSS Simple Slider  -->
<link rel="stylesheet" href="../../web/assets/css/simplerSliderW3.css" type="text/css">
<!-- CSS для замены Flex Slider на Normal Slider -->
<link rel="stylesheet" href="../../web/assets/css/replaceFlexNormalSlider.css" type="text/css">
<!-- CSS для обзоров -->
<link rel="stylesheet" href="../../web/assets/css/reviews.css" type="text/css"/>
<!-- CSS для аккордиона -->
<link rel="stylesheet" href="../../web/assets/css/accordion.css" type="text/css"/>
<!-- Скрипт для добавления товара в избранное -->
<script type="text/javascript" src="../../web/assets/js/favourites.js"></script>
<!-- JS Flex Slider-->
<script type="text/javascript" defer src="../../web/assets/js/jquery.flexslider.js"></script>
<!-- Image Zoom JS -->
<script type="text/javascript" src="../../web/assets/js/image.zoom.js"></script>
<!-- Удаление обзора с AJAX JS -->
<script type="text/javascript" src="../../web/assets/js/delReview.js"></script>

<title>Chip :: <?= $product["title"] ?></title>

<?php
// Шапка
require_once "../elements/header.php";
// Навигация
require_once "../elements/navigation.php";
?>

<!-- Один товар -->
<div class="products">
    <div class="container">
        <div class="products-grids">
            <div class="col-md-8 products-single">

                <!-- Simple Slider, display: none by default -->
                <div id="normalSlider" class="col-md-5 grid-single">
                    <div class="flexslider">
                        <ul class="slides">
                            <div class="w3-content">
                                <img class="mySlides" src="<?= $images[0]["image_url"] ?>">
                                <img class="mySlides" src="<?= $images[1]["image_url"] ?>">
                                <img class="mySlides" src="<?= $images[2]["image_url"] ?>">

                                <div class="w3-row-padding w3-section">
                                    <div class="w3-col s4">
                                        <img class="demo w3-opacity w3-hover-opacity-off "
                                            src="<?= $images[0]["image_url"] ?>"
                                            onclick="currentDiv(1)">
                                    </div>
                                    <div class="w3-col s4">
                                        <img class="demo w3-opacity w3-hover-opacity-off"
                                            src="<?= $images[1]["image_url"] ?>"
                                            onclick="currentDiv(2)">
                                    </div>
                                    <div class="w3-col s4">
                                        <img class="demo w3-opacity w3-hover-opacity-off"
                                            src="<?= $images[2]["image_url"] ?>"
                                            onclick="currentDiv(3)">
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>

                <!-- JS для Simple Slider -->
                <script src="../../web/assets/js/simple.slider.w3.js"></script>

                <!-- Flex Slider -->
                <div id="flexSliderDiv" class="col-md-5 grid-single">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php 
                            foreach ($images as $image) { ?>
                                <li data-thumb="<?= $image["image_url"] ?>">
                                    <div class="thumb-image">
                                        <img src="<?= $image["image_url"] ?>" data-imagezoom="true" class="img-responsive" alt=""/>
                                    </div>
                                </li>
                      <?php } // foreach ?>
                        </ul>
                    </div>
                </div>

                <!-- Информация товара -->
                <div class="col-md-7 single-text">
                    <h3><?= $product["title"]; ?></h3>
                    <p class="availability">Доступность: 
                        <span class="color">
                            <?php 
                            if ($product["quantity"] == 0) {
                                echo("Нет в наличии ");
                            } else echo("В наличии"); ?>
                        </span>
                    </p>
                    <div class="price_single">
                        <?php
                        if ($promotedPrice !== null) { ?>
                            <span class="reducedfrom">₴<?= $product["price"]; ?></span>
                            <span class="actual item_price">₴<?= $promotedPrice; ?></span>
                        <?php
                        } else { ?>
                            <span class="actual item_price">₴<?= $product["price"]; ?></span>
                        <?php
                        } // if ?>
                    </div>
                    <img id="averageRating" class="media-object img" src="../../web/assets/images/rating<?= $product["average"] ?>.png"><br/>
                    <div class="clearfix"></div>

                    <!-- Кнопки для добавления в корзину, избранное & обзор -->
                    <span id="quantityTextSingle" class="label label-default">Количество:</span>
                    <select id="buyQuantity" class="form-control">
                        <?php for ($i = 1; $i <= 50; $i++) {
                            echo("<option value=\"$i\">$i</option>");
                        } // for i ?>
                    </select>
                    <button id="addCartButtonSingle" type="submit" class="btn btn-default" 
                        onclick="addToCartSingle(<?= $product["id"].",".(isset($promotedPrice) ? $promotedPrice : $product["price"]) ?>)">
                            <span class="glyphicon glyphicon-shopping-cart"></span> В корзину
                    </button>
                    <br/>
                    <?php 
                        if (!($isFavourite == 3)) {
                            if ($isFavourite == 2) { ?>
                                <div id="favourite">
                                    <button style="display: inline-block;" class="btn btn-primary" onclick="addFavourite(<?= $product["id"] ?>)">
                                        <span class="glyphicon glyphicon-heart"></span> Добавить в избранное
                                    </button>
                                </div>
                      <?php } else { ?>
                                <div id="favourite">
                                    <button style="display: inline-block;" class="btn btn-danger" onclick="removeFavourite(<?= $product["id"] ?>)">
                                        <span class="glyphicon glyphicon-heart-empty"></span> Удалить из избранного
                                    </button>
                                </div>
                      <?php } // if
                        } // if
                    if (isset($_SESSION["loggedUser"])) { ?>
                        <br/>
                        <a href="review.php?pid=<?= $product["id"] ?>" style="display: inline-block;" class="btn btn-primary btn-warning">
                            <span class="glyphicon glyphicon-tag"></span> Добавить отзыв</a>
              <?php } // if ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>

            <!-- Информация о продукте -->
            <div class="panel-group collpse" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" 
                                href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Описание
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <?= $product["description"]; ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Характеристики
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <table>
                                <tr>
                                    <th>Спецификация</th>
                                    <th>Значение</th>
                                </tr>
                                <?php
                                foreach ($specifications as $spec) {
                                ?>
                                    <tr>
                                        <td><?= $spec["name"]; ?></td>
                                        <td><?= $spec["value"]; ?></td>
                                    </tr>
                                <?php
                                } // foreach
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Отзывы (<?= $reviewsCount ?>)
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">

                        <?php 
                            foreach ($reviews as $review) { ?>
                                <div id="rev-<?= $review["id"] ?>">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="comments-logout">
                                            <ul class="media-list">
                                                <li class="media">
                                                    <div class="pull-left" href="#">
                                                        <img class="media-object img-circle"
                                                            src="<?= $review["image_url"] ?>"
                                                            alt="profile">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="well well-lg">
                                                            <h4 class="media-heading text-uppercase reviews">
                                                                <?= $review["title"]."<small>"."&nbsp от ".$review["first_name"]."</small>" ?>
                                                                <img id="reviewRating" class="media-object img"
                                                                    src="../../web/assets/images/rating<?= $review["rating"] ?>.png">
                                                            </h4>
                                                            <?php if (isset($_SESSION["role"]) && ($_SESSION["role"] == 3 || $_SESSION["role"] == 2)) { ?>
                                                                <div onclick="delReview(<?= $review["id"] ?>)" class="close1"></div> 
                                                            <?php } // if ?>
                                                            <ul class="media-date text-uppercase reviews list-inline">
                                                                <li class="dd"> <?= $review["created_at"] ?></li>
                                                            </ul>
                                                            <p class="media-comment" id="reviewComment">
                                                                <?= $review["comment"] ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                      <?php } // foreach ?>
                    </div>
                </div>
            </div>

            <!-- Похожие товары -->
            <div class="collection-section">
                <?php if (count($relatedProducts)) {
                    echo("<h3 class=\"title\">Похожие товары</h3>");
                } // if ?>
                <div class="main_filtered_product-info">
                    <?php 
                        foreach ($relatedProducts as $product) {
                            if ($product["percent"] != null) {
                                $promotedPrice = round($product["price"] - (($product["price"] * $product["percent"]) / 100), 2);
                            } else {
                                unset($promotedPrice);
                            } // if ?>
                            <div class="products-grd" id="responsiveProductsDiv">
                                <div class="p-one">
                                    <a href="single.php?pid=<?= $product["id"]; ?>">
                                        <img src="<?= $product["image_url"] ?>" alt="Product Image" class="img-responsive"/>
                                    </a>
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
                                            <i class="glyphicon glyphicon-shopping-cart"></i>&nbspДобавить
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
                  <?php } // foreach ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    // Подвал @codingStandardsIgnoreEnd
    require_once "../elements/footer.php";
?>