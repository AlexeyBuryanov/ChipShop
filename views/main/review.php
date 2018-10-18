<!-- Отзыв о товаре -->

<?php // @codingStandardsIgnoreStart
// Проверяем автозагрузчик
require_once "../../utils/autoloader.php";
// Проверяем сессию
require_once "../../utils/no_session_main.php";
// Подключаем основные заголовки
require_once "../elements/headers.php";
?>

<link rel="stylesheet" href="../../web/assets/css/addReview.css">
<title>Chip :: Добавить отзыв</title>
</head>

<?php
// Шапка
require_once "../elements/header.php";
// Навигация
require_once "../elements/navigation.php";
?>

<!-- Добавление новго отзыва -->
<div class="container">
    <form action="../../controllers/reviews/add_review_controller.php?pid=<?= $_GET["pid"] ?>" method="post">
        <div id="uppderDiv"></div>
        <label>Рейтинг</label>
        <div id="lowerDiv"></div>
        <label class="radio-inline"><input type="radio" name="rating" value="1" required>
            <img class="starRating" src="../../web/assets/images/star1.png">
        </label>
        <label class="radio-inline"><input type="radio" name="rating" value="2" required>
            <img class="starRating" src="../../web/assets/images/star2.png">
        </label>
        <label class="radio-inline"><input type="radio" name="rating" value="3" required checked>
            <img class="starRating" src="../../web/assets/images/star3.png">
        </label>
        <label class="radio-inline"><input type="radio" name="rating" value="4" required>
            <img class="starRating" src="../../web/assets/images/star4.png">
        </label>
        <label class="radio-inline"><input type="radio" name="rating" value="5" required>
            <img class="starRating" src="../../web/assets/images/star5.png">
        </label>
        <div class="clearfix"></div>

        <label id="labelTitle" for="title">Заголовок</label>
        <input class="form-control" type="text" name="title" placeholder="Заголовок" id="title" pattern=".{4,15}" required title="Заголовок от 4 до 15 символов">

        <label id="labelTextArea" for="reviewArea">Отзыв</label>
        <textarea class="form-control" rows="5" name="review" placeholder="Сообщение ..." id="reviewArea" maxlength="255" minlength="3" required></textarea><br/>

        <button id="addReviewButton" type="submit" class="btn btn-primary btn-warning">
            <span class="glyphicon glyphicon-tag"></span> Добавить отзыв
        </button>
    </form>
</div>

<?php
    // Подвал @codingStandardsIgnoreEnd
    require_once "../elements/footer.php";
?>