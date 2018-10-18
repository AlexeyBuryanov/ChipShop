<!-- Восстановление пароля -->

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
        <title>Chip :: Восстановление пароля</title>
        <!-- CSS для входа/регистрации/форм редактирования -->
        <link rel="stylesheet" href="../../web/assets/css/user.css" type="text/css">
        <!-- Favicon -->
        <link rel="shortcut icon" href="../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    </head>
    <body>
        <div class="login-page">
            <div id="logo"><a href="../main/index.php"><img src="../../web/assets/images/logo.png"></a></div>
            <div class="form">
                <form class="login-form" action="../../controllers/user/create_tokken_controller.php" method="post">
                    <?php 
                    if (isset($_GET["tokken"])) {
                        echo("<p id=\"resetPasswordMessage\">Проверьте адрес электронной почты для сброса пароля. Срок действия истекает через 10 минут.</p>
                              <input type=\"text\" name=\"tokken\" placeholder=\"Введите токкен\"/><input type=\"hidden\" name=\"emailHidden\" value='".$_GET['tokken']."'>
                              <input id=\"login\" type=\"submit\" value=\"СБРОСИТЬ ПАРОЛЬ\">"); 
                    } else if (!(isset($_GET["errorTokken"]))) { 
                        echo("<input type=\"email\" name=\"email\" placeholder=\"Введите адрес электронной почты\">
                              <input id=\"login\" type=\"submit\" value=\"СБРОСИТЬ ПАРОЛЬ\">");
                    } // if ?>

                    <?php 
                    if (isset($_GET["errorTokken"])) { 
                        echo("<p id=\"wrongTokken\">Неверный токкен! Попробуйте еще раз.</p>
                              <p class=\"message\"><a href=\"forgotten.php\">Попробовать снова</a></p>"); 
                    } // if ?>

                    <?php 
                    if (isset($_GET["error"])) { 
                        echo("<p id=\"wrongLogin\">Пользователь не найден!</p>"); 
                    } // if ?>

                    <p class="message">Не зарегистрированы?<br><a href="register.php">Создать аккаунт</a></p>
                </form>
            </div>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>