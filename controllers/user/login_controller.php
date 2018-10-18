<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует вход

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";
// Проверяем зашёл ли пользователь
require_once "../../utils/session_main.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Валидация | @codingStandardsIgnoreStart
if (!empty($_POST["email"]) &&
    !empty($_POST["password"])) { // @codingStandardsIgnoreEnd
    $email = $_POST["email"];
    $password = $_POST["password"];

    // @codingStandardsIgnoreStart
    if (strlen($email) > 3 &&
        strlen($email) < 254 &&
        strlen($password) >= 4 &&
        strlen($password) <= 12) { // @codingStandardsIgnoreEnd

        // Получаем объект пользователя
        $user = new \models\User();

        // Попытка выполнить соединение с базой данных
        try {
            // DAO юзера
            $userDao = \models\database\UserDao::getInstance();
            $user->setEmail(htmlentities($email));
            $user->setPassword(hash('sha256', $password));
            // Проверяем вход
            $result = $userDao->checkLogin($user);

            if ($result) {
                // Проверка на "включенного" юзера
                if (!$userDao->checkEnabled($result)) {
                    header("location: ../../views/user/login.php?blocked");
                    die();
                } // if

                $_SESSION["loggedUser"] = $result;
                $_SESSION["role"] = 1;
                $userDao->setLastLogin($user);

                // Проверяем, если пользователь админ (role = 3)
                if ($userDao->checkIfLoggedUserIsAdmin($user) == 3) {
                    $_SESSION["role"] = 3;
                } else if ($userDao->checkIfLoggedUserIsAdmin($user) == 2) {
                    $_SESSION["role"] = 2;
                } else {
                    $_SESSION["role"] = 1;
                } // if

                header("location: ../../views/main/index.php");
                die();
            } else {
                // Направляем на ошибку страницы входа
                header("location: ../../views/user/login.php?error");
                die();
            } // if
        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
            error_log($message, 3, "../../errors.log");
            header("location: ../../views/error/error_500.php");
            die();
        } // try-catch
    } else {
        // Направляем на ошибку страницы входа
        header("location: ../../views/user/login.php?error");
        die();
    } // if
} else {
    // Направляем на ошибку страницы входа
    header("location: ../../views/user/login.php?error_400");
    die();
} // if