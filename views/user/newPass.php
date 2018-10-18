<!-- Новый пароль -->

<?php // @codingStandardsIgnoreStart
    // Проверка сессии
    require_once "../../utils/session_main.php";

    if (!isset($_SESSION["passReset"])) {
        header("location: ../../views/user/login.php");
        die();
    } // if

    if (abs(($_SESSION["passReset"]["time"] - time())) > 600) {
        session_destroy();
        header("location: ../../views/user/login.php");
        die();
    } // if
?>

<!DOCTYPE html>
<html lang="ru-RU">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Алексей Бурьянов"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Chip :: Новый пароль</title>
        <!-- CSS для входа/регистрации/форм редактирования -->
        <link rel="stylesheet" href="../../web/assets/css/user.css" type="text/css">
        <!-- Favicon -->
        <link rel="shortcut icon" href="../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    </head>
    <body>
        <div class="login-page">
            <div id="logo"><a href="../main/index.php"><img src="../../web/assets/images/logo.png"></a></div>
            <div class="form">
                <form class="login-form" action="../../controllers/user/new_pass_controller.php" method="post">
                    <input type="password" name="pass1" placeholder="Введите новый пароль"
                        pattern=".{4,20}" required title="Пароль от 4 до 20 символов"/>
                    <input type="password" name="pass2" placeholder="Повторите новый пароль"
                        pattern=".{4,20}" required title="Пароль от 4 до 20 символов"/>

                    <p class="wrongInput" <?= (!isset($_GET["errorPassSyntax"])) ? : "style='display: block;'"?>>
                        Пароли должны быть от 4 до 20 символов!
                    </p>
                    <p class="wrongInput" <?= (!isset($_GET["errorPassMatch"])) ? : "style='display: block;'"?>>
                        Пароли не совпадают!
                    </p>

                    <input id="login" type="submit" value="ОБНОВИТЬ">
                </form>
            </div>
        </div>
    </body>
</html>
<?php // @codingStandardsIgnoreEnd ?>