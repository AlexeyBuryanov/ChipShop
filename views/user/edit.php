<!-- Редактирование профиля -->

<?php // @codingStandardsIgnoreStart
// Запрашиваем информацию пользователя и проверяем сессию (проверяется в контроллере)
require_once "../../controllers/user/get_users_info_controller.php";
// Проверка на бан
require_once "../../utils/blocked_user.php";
?>

<!DOCTYPE html>
<html lang="ru-RU">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Алексей Бурьянов"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Chip :: Редактирование профиля</title>
        <!-- CSS для входа/регистрации/формы редактирования -->
        <link rel="stylesheet" href="../../web/assets/css/user.css" type="text/css">
        <!-- Favicon -->
        <link rel="shortcut icon" href="../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    </head>
    <body>
        <div class="login-page">
            <div id="logo"><a href="../main/index.php"><img src="../../web/assets/images/logo.png"></a></div>
            <div class="form">
                <form enctype="multipart/form-data" class="login-form" action="../../controllers/user/edit_controller.php<?php if (isset($_GET["addAddress"])) { echo("?addAddress"); } ?>" method="post">
                    <input type="email" name="email" placeholder="E-mail" value="<?= $userArr["email"] ?>" required/>
                    <p class="wrongInput" <?= (!isset($_GET["errorEmail"])) ? : "style='display: block;'"?>>
                        Эл. адрес уже существует!
                    </p>

                    <input type="password" name="passwordOld" placeholder="Ваш текущий пароль" pattern=".{4,20}" required title="Пароль от 4 до 20 символов"/>
                    <p class="wrongInput" <?= (!isset($_GET["errorPassMatch"])) ? : "style='display: block;'"?>>
                        Неправильный пароль!
                    </p>

                    <input type="password" name="password" placeholder="Новый пароль (необязательно)" pattern=".{4,20}" title="Пароль от 4 до 20 символов"/>
                    <p class="wrongInput" <?= (!isset($_GET["errorPassSyntax"])) ? : "style='display: block;'"?>>
                        Пароли должны быть от 4 до 20 символов!
                    </p>

                    <input type="text" name="firstName" placeholder="Имя" value="<?= $userArr["first_name"] ?>" pattern=".{4,20}" required title="Имя от 4 до 20 символов"/>
                    <p class="wrongInput" <?= (!isset($_GET["errorFN"])) ? : "style='display: block;'"?>>
                        Имя должно быть от 4 до 20 символов!
                    </p>

                    <input type="text" name="lastName" placeholder="Фамилия" value="<?= $userArr["last_name"] ?>" pattern=".{4,20}" required title="Фамилия от 4 до 20 символов"/>
                    <p class="wrongInput" <?= (!isset($_GET["errorLN"])) ? : "style='display: block;'"?>>
                        Фамилия должна быть от 4 до 20 символов!
                    </p>

                    <input type="tel" name="mobilePhone" placeholder="Мобильный телефон" value="<?= $userArr["mobile_phone"] ?>" pattern="[0-9]{10}" required title="Номер должен быть 10 цифр"/>
                    <p class="wrongInput" <?= (!isset($_GET["errorMN"])) ? : "style='display: block;'"?>>
                        Мобильный номер должен быть 10 цифр!
                    </p>

                    <input type="text" name="address" 
                        <?php if ($userArr["full_adress"]) {
                            echo("value=\"".$userArr["full_adress"]."\"");
                        } else {
                            echo "placeholder=\"Адрес доставки\"";
                        } // if ?> pattern=".{4,200}" title="Адрес от 4 до 200 символов">
                    <p class="wrongInput" <?= (!isset($_GET["errorAR"])) ? : "style='display: block;'"?>>
                        Адрес должен быть от 4 до 200 символов!
                    </p>
                    <p id="address" class="wrongInput" <?= (!isset($_GET["addAddress"])) ? : "style='display: block;'"?>>
                        Введите адрес доставки!
                    </p>
                    
                    <div id="fileupload">
                        <input class="radio" type="radio" name="personal" value="1" 
                            <?php if ($userArr["is_personal"] == 1) {
                                echo("checked");
                            } // if ?>>&nbspЛичный&nbsp&nbsp&nbsp

                        <input class="radio" type="radio" name="personal" value="2" 
                            <?php if ($userArr["is_personal"] == 2) {
                                echo("checked");
                            } // if ?>>&nbspБизнес
                    </div>

                    <div id="fileupload">
                        <p id="fileuploadMessage">Изображение профиля</p>
                        <input type="file" name="image"/>
                    </div>
                    <p class="wrongInput" <?= (!isset($_GET["errorUL"])) ? : "style='display: block;'"?>>
                        Загрузите файл изображения не более, чем 5 МБ (jpg / jpeg / png / gif)
                    </p>

                    <input id="login" type="submit" value="ОБНОВИТЬ">

                    <p class="message"><a href="../main/index.php">Вернуться к предложениям?</a></p>
                </form>
            </div>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>