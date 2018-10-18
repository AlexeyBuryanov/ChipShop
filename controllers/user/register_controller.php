<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует регистрацию юзера

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";
// Проверяем выполнил ли юзер вход
require_once "../../utils/session_main.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Валидация @codingStandardsIgnoreStart
if (!empty($_POST["email"]) &&
    !empty($_POST["password"]) &&
    !empty($_POST["password2"]) &&
    !empty($_POST["firstName"]) &&
    !empty($_POST["lastName"]) &&
    !empty($_POST["mobilePhone"])) { // @codingStandardsIgnoreEnd

    $email = $_POST["email"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $mobilePhone = $_POST["mobilePhone"];

    if (!(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 3 && strlen($email) < 254)) {
        // Направляем по ошибке страницы регистрации
        header("location: ../../views/error/error_400.php");
        die();
    } // if

    if (!(ctype_digit($mobilePhone) && strlen($mobilePhone) == 10)) {
        // Направляем на страницу ошибки - плохой номер телефона
        header("location: ../../views/user/register.php?errorMN");
        die();
    } // if

    if (!(strlen($password) >= 4 && strlen($password) < 20 && strlen($password2) >= 4 && strlen($password2) < 20)) {
        // Направляем на страницу ошибки - плохой пароль по синтаксису
        header("location: ../../views/user/register.php?errorPassSyntax");
        die();
    } // if

    if (!($password == $password2)) {
        // Направляем на страницу ошибки - плохой пароль, не совпадает
        header("location: ../../views/user/register.php?errorPassMatch");
        die();
    } // if

    if (!(strlen($firstName) >= 4 && strlen($firstName) < 20)) {
        // Направляем на страницу ошибки - длина имени
        header("location: ../../views/user/register.php?errorFN");
        die();
    } // if

    if (!(strlen($lastName) >= 4 && strlen($lastName) < 20)) {
        // Направляем на страницу ошибки - длина фамилии
        header("location: ../../views/user/register.php?errorLN");
        die();
    } // if

    // Объект пользователя
    $user = new \models\User();

    // Попытка выполнить соединение с базой данных
    try {
        // DAO юзера
        $userDao = \models\database\UserDao::getInstance();

        // Устанавливаем данные по юзеру
        $user->setEmail(htmlentities($email));
        $user->setPassword(hash('sha256', $password));
        $user->setFirstName(htmlentities($firstName));
        $user->setLastName(htmlentities($lastName));
        $user->setMobilePhone(htmlentities($mobilePhone));

        // Если это первый юзер, делаем его админом (role = 3)
        if ($userDao->checkIfUserFirst()) {
            $user->setRole(3);
            $_SESSION["role"] = 3;
        } else {
            $user->setRole(1);
            $_SESSION["role"] = 1;
        } // if

        // Включаем роль
        $_SESSION["enabled"] = 1;

        // Проверяем существует ли пользователь
        if ($userDao->checkUserExist($user)) {
            // Направляем на страницу с ошибкой связанной с регистрацией.
            // Нельзя зарегистрировать уже существующего пользователя
            header("location: ../../views/user/register.php?errorEmail");
            die();
        } else {
            // Регистрация
            $id = $userDao->registerUser($user);
            // Сразу выполняем сессионный вход
            $_SESSION["loggedUser"] = $id;
            header("location: ../../views/main/index.php");
            die();
        } // if
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../errors.log");
        header("location: ../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    // Ошибка регистрации
    header("location: ../../views/error/error_400.php");
    die();
} // if