<!-- Проверка товаров в корзине -->

<?php // @codingStandardsIgnoreStart
// Подключаем контроллер для отображения продуктов в корзине
require_once "../../controllers/cart/show_cart_controller.php";
// Подключаем основные заголовки
require_once "../elements/headers.php";
?>

<!-- CSS для корзины  -->
<link rel="stylesheet" href="../../web/assets/css/cart.css">
<!-- Для удаления продукта из корзины -->
<script type="text/javascript" src="../../web/assets/js/cart/remove.cart.js"></script>
<!-- Для контролля количества в корзине -->
<script type="text/javascript" src="../../web/assets/js/cart/quantity.cart.js"></script>

<title>Chip :: Корзина</title>

<?php
// Подключаем шапку
require_once "../elements/header.php";
// Подключаем навигацию
require_once "../elements/navigation.php";
?>

<div class="cart-items">
    <div class="container">
        <!-- Суммарная цена товара и оплата-->
        <h3 class="title">Моя покупка(<div id="cartItems2"><?= ($orderSuccessful === 1 ? $orderQuantity : $cartItems) ?></div>)
        </h3>
        <br/>
        <h3 class="b-tittle" id="totalPrice">Итого:
            <div id="totalPriceCurrency">₴<div id="cartTotalPrice2"><?= ($orderSuccessful === 1 ? $orderTotalPrice : $cartTotalPrice) ?> грн</div></div>
        </h3>
        <br/>

        <?php
        if ($cartIsEmpty === 0) {
            if (!empty($_SESSION["loggedUser"])) { ?>
                <a href="../../controllers/cart/new_order_controller.php">
                    <button class="btn btn-danger btn-lg btn-block" id="checkOutButton">Купить</button>
                </a>
            <?php 
            } else { ?>
                <a href="../../views/user/login.php">
                    <button class="btn btn-danger btn-lg btn-block" id="checkOutButton">ВОЙТИ, ЧТОБЫ КУПИТЬ</button>
                </a> 
            <?php 
            } // if ?>
            <!-- Показать товары в корзине -->
            <?php 
                foreach ($cart as $cartProduct) { ?>
                    <div id="product-<?= $cartProduct->getId() ?>">
                        <div class="cart-header">
                            <div id="button-<?= $cartProduct->getId() ?>" class="close1"
                                onclick="removeFromCart(<?= $cartProduct->getId().",".$cartProduct->getPrice() ?>)">
                            </div>
                            <div class="cart-sec simpleCart_shelfItem">
                                <div class="cart-item cyc">
                                    <a href="single.php?pid=<?= $cartProduct->getId() ?>">
                                        <img src="<?= $cartProduct->getImage() ?>" class="img-responsive" alt="">
                                    </a>
                                </div>
                                <div class="cart-item-info">
                                    <h3>
                                        <a href="single.php?pid=<?= $cartProduct->getId() ?>">
                                            <?= $cartProduct->getTitle() ?>
                                        </a>
                                    </h3>
                                    <p>
                                        <div id="quantityText">Количество:
                                            <span id="quantityNumber">
                                                <span id="product-<?= $cartProduct->getId() ?>-quantity">
                                                    <?= $cartProduct->getQuantity() ?>
                                                </span>
                                            </span>
                                        </div>
                                        <button class="btn btn-xs btn-info glyphicon glyphicon-minus" 
                                            onclick="removeOneQuantityFromCart(<?= $cartProduct->getId().",".$cartProduct->getPrice() ?>)">
                                        </button>

                                        <button class="btn btn-xs btn-info glyphicon glyphicon-plus" 
                                            onclick="addOneQuantityToCart(<?= $cartProduct->getId().",".$cartProduct->getPrice() ?>)">
                                        </button>
                                    </p>
                                    <div class="delivery">
                                        <p>₴
                                            <div id="product-<?= $cartProduct->getId() ?>-totalPrice">
                                                <?= $cartProduct->getPrice() * $cartProduct->getQuantity() ?>
                                            </div>
                                        </p><br/>
                                        <p>Цена за единицу: ₴<?= $cartProduct->getPrice() ?></p>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
          <?php } // foreach
        } else if ($cartIsEmpty === 1 && $orderSuccessful === 0) { ?>
            <h3 align="center">Ваша корзина пуста!</h3><br/>
        <?php
        } else if ($orderSuccessful === 1) { ?>
            <h3 align="center">Ваш заказ прошел успешно!<br>Ваш номер заказа <q><?= $orderNumber ?></q>.<br>
                Ожидайте от нас звонок в течении суток.</h3><br/>
        <?php
        } // if ?>
        <a href="index.php">
            <button class="btn btn-success btn-lg btn-block">ПРОДОЛЖИТЬ ПОКУПКИ</button>
        </a>
    </div>
</div>

<?php
    // Подключаем подвал @codingStandardsIgnoreEnd
    require_once "../elements/footer.php";
?>