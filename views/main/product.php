<!-- Товары по категории -->

<?php // @codingStandardsIgnoreStart
require_once "../../controllers/products/products_by_category_controller.php";
// Подключаем основные заголовки
require_once "../elements/headers.php";
?>

<title>Chip :: <?= $subcatName ?></title>
<link rel="stylesheet" href="../../web/assets/css/jquery-ui.css">
<script src="../../web/assets/js/jquery-ui.js"></script>
<!-- Загрузчик продуктов -->
<script src="../../web/assets/js/products/products.by.category.js"></script>

<?php
// Шапка
require_once "../elements/header.php";
// Навигация
require_once "../elements/navigation.php";
?>

<!-- Продукты по категориям -->
<div class="products">
    <div class="container">
        <div class="products-grids">
            <div class="col-md-4 products-grid-right">
                <div class="w_sidebar">
                    <div class="w_nav1">
                        <h4>Фильтры</h4>
                        Сортировать по:
                        <select class="form-control" id="filter" onchange="filteredProducts()">
                            <option value="1" selected>Новинки</option>
                            <option value="2">Самые продаваемые</option>
                            <option value="3">Самые просматриваемые</option>
                            <option value="4">Наивысший рейтинг</option>
                        </select>
                    </div>
                    <section class="sky-form">
                        <h4>Ценовой фильтр</h4>
                        <p>
                            <label for="amount">Ценовой диапазон:</label>
                            <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                        </p>

                        <div id="slider-range"></div>
                    </section>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12 products-grid-left" id="productsWindow">
            </div>
            <div id="loader" style="display: block" class="center-block"></div>
        </div>
    </div>
</div>

<?php
    // Подвал @codingStandardsIgnoreEnd
    require_once "../elements/footer.php";
?>