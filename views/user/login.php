<!-- Вход в аккаунт -->

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
        <title>Chip :: Вход</title>
        <!-- CSS для входа/регистрации/форм редактирования -->
        <link rel="stylesheet" href="../../web/assets/css/user.css" type="text/css">
        <!-- Favicon -->
        <link rel="shortcut icon" href="../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    </head>
    <body>
        <div class="login-page">
            <div id="logo"><a href="../main/index.php"><img src="../../web/assets/images/logo.png"></a></div>
            <div class="form">
                <form class="login-form" action="../../controllers/user/login_controller.php" method="post">
                    <input type="email" name="email" placeholder="E-mail" required/>
                    <input type="password" name="password" placeholder="Пароль" pattern=".{4,20}" required title="Пароль от 4 до 20 символов"/>

                    <input id="login" type="submit" value="ВОЙТИ">

                    <?php 
                    if (isset($_GET["error"])) { 
                        echo("<p id=\"wrongLogin\">Неверно введённые данные!</p>"); 
                    } // if ?>
                    <?php 
                    if (isset($_GET["blocked"])) { 
                        echo("<p id=\"wrongLogin\">Пользователь заблокирован!</p>"); 
                    } // if ?>
                    <p class="message">Забыли пароль?&nbsp;<br><a href="forgotten.php">Сбросить пароль</a></p>
                    <p class="message">Не зарегистрированы?&nbsp;<br><a href="register.php">Создать аккаунт</a></p>
                </form>
            </div>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>