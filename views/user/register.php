<!-- Регистрация -->

<?php // @codingStandardsIgnoreStart
    // Проверка сессии
    require_once "../../utils/session_main.php";
?>

<!DOCTYPE html>
<html lang="ru-RU">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Алексей Бурьянов"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Chip :: Регистрация</title>
        <!-- CSS для входа/регистрации/форм редактирования -->
        <link rel="stylesheet" href="../../web/assets/css/user.css" type="text/css">
        <!-- Favicon -->
        <link rel="shortcut icon" href="../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    </head>
    <body>
        <div class="login-page">
            <div id="logo"><a href="../main/index.php"><img src="../../web/assets/images/logo.png"></a></div>
            <div class="form">
                <form class="login-form" action="../../controllers/user/register_controller.php" method="post">
                    <p class="wrongInput" <?= (!isset($_GET["errorField"])) ? : "style='display: block;'"?>>
                        Все поля обязательны для заполнения!
                    </p>
                    <input type="email" name="email" placeholder="E-mail" required/>
                    <p class="wrongInput" <?= (!isset($_GET["errorEmail"])) ? : "style='display: block;'"?>>
                        Эл. адрес уже существует!
                    </p>

                    <input type="password" name="password" placeholder="Пароль"
                        pattern=".{4,20}" required title="Пароль от 4 до 20 символов"/>
                    <p class="wrongInput" <?= (!isset($_GET["errorPassSyntax"])) ? : "style='display: block;'"?>>
                        Пароли должны быть от 4 до 20 символов!
                    </p>
                    <p class="wrongInput" <?= (!isset($_GET["errorPassMatch"])) ? : "style='display: block;'"?>>
                        Пароли не совпадают!
                    </p>

                    <input type="password" name="password2" placeholder="Повторите пароль"
                        pattern=".{4,20}" required title="Пароль от 4 до 20 символов"/>

                    <input type="text" name="firstName" placeholder="Имя"
                        pattern=".{4,20}" required title="Имя от 4 до 20 символов"/>
                    <p class="wrongInput" <?= (!isset($_GET["errorFN"])) ? : "style='display: block;'"?>>
                        Имя должно быть от 4 до 20 символов!
                    </p>

                    <input type="text" name="lastName" placeholder="Фамилия"
                        pattern=".{4,20}" required title="Last Name 4 to 20 characters"/>
                    <p class="wrongInput" <?= (!isset($_GET["errorLN"])) ? : "style='display: block;'"?>>
                        Фамилия должна быть от 4 до 20 символов!
                    </p>

                    <input type="tel" name="mobilePhone" placeholder="Мобильный телефон"
                        pattern="[0-9]{10}" required title="Номер должен быть 10 цифр"/>
                    <p class="wrongInput" <?= (!isset($_GET["errorMN"])) ? : "style='display: block;'"?>>
                        Мобильный номер должен быть 10 цифр!
                    </p>

                    <input id="login" type="submit" value="ЗАРЕГИСТРИРОВАТЬСЯ">
                    <p class="message">Уже зарегистрированы?&nbsp;<br><a href="login.php">Войти</a></p>
                </form>
            </div>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>