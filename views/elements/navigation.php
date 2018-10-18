<?php // @codingStandardsIgnoreStart
// Подключааем контроллер навигации
require_once "../../controllers/navigation/navigation_controller.php";
// Подключааем контроллер корзины для поля корзины
require_once "../../controllers/cart/cart_navi_controller.php"
?>

<!-- Шапка -->
<div id="header_bg">
    <div class="container">
        <div class="head-t">

            <!-- Лого -->
            <div class="logo">
                <a href="index.php"><h1>Chip<span>Shop</span></h1></a>
            </div>

            <!-- Кнопка избранного -->
            <div class="header_right">
                <?php 
                    if (isset($_SESSION["loggedUser"])) { ?>
                        <a href="../main/favourites.php">
                            <button class="btn btn-primary btn-info" id="favouritesButton"><span class="glyphicon glyphicon-heart"></span> Избранное</button>
                        </a>&nbsp&nbsp&nbsp&nbsp
              <?php } else { ?>
                         <div class="btn btn-primary btn-info" id="invisible"><span class="glyphicon glyphicon-heart"></span></div>&nbsp&nbsp&nbsp&nbsp
              <?php } // if ?>

                <!-- Кнопка корзины -->
                <div id="cartToHover" class="cart box_1">
                    <a href="checkout.php">
                        <div class="total">
                            ₴<div id="cartTotalPrice"><?= round($cartTotalPrice) ?></div>
                            <br/>(<div id="cartItems"><?= $cartItems ?></div> товаров)
                        </div>
                        <i class="glyphicon glyphicon-shopping-cart"></i></a>
                    <div class="clearfix"></div>
                </div>
                <div id="cartDivHover"></div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Навигационная панель -->
        <ul class="megamenu deeporange">
            <li class="grid"><a class="color1" href="index.php">Главная</a></li>
            <?php 
                foreach ($supercategories as $supercategory) { ?>
                    <li class="grid"><a class="color2" href="#"><?= $supercategory["name"] ?></a>
                        <div class="megapanel">
                            <div class="row">
                                <?php 
                                    foreach ($categories as $category) {
                                        if ($category["supercategory_id"] == $supercategory["id"]) { ?>
                                            <div class="col1">
                                                <div class="h_nav">
                                                    <h4><?= $category["name"] ?></h4>
                                                    <ul>
                                                        <?php 
                                                            foreach ($subcategories as $subcategory) {
                                                                if ($subcategory["category_id"] == $category["id"]) { ?>
                                                                    <li>
                                                                        <a href="product.php?subcid=<?= $subcategory["id"] ?>"><?= $subcategory["name"] ?></a>
                                                                    </li>
                                                          <?php } // if
                                                            } // foreach ?>
                                                    </ul>
                                                </div>
                                            </div>
                                  <?php } // if
                                    } // foreach ?>
                            </div>
                            <div class="row">
                                <div class="col2"></div>
                                <div class="col1"></div>
                                <div class="col1"></div>
                                <div class="col1"></div>
                                <div class="col1"></div>
                            </div>
                        </div>
                    </li>
          <?php } // foreach ?>
        </ul>
    </div>
</div>
<?php // @codingStandardsIgnoreEnd ?>