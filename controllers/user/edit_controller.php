<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллирует редактирование профиля

// Подключаем обработчик ошибок
require_once "../../utils/error_handler.php";
// Проверка для сессии
require_once "../../utils/no_session_main.php";
// Подключаем кастомную функцию imageCrop
require_once "../../utils/imageCrop.php";

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Обработка изображения ------------------------------------------------------
$imagesDirectory = null;
$tmpName = null;
$userId = $_SESSION["loggedUser"];
$picture = null;

// Проверяем загружен ли файл
if (!empty($_FILES["image"]["tmp_name"])) {
    $picture = true;
    $tmpName = $_FILES["image"]["tmp_name"];

    // Успешно ли загружен файл
    if (!is_uploaded_file($tmpName)) {
        // Перенаправление на страницу с ошибкой
        header("location: ../../views/error/error_400.php");
        die();
    } // if

    // Получить тип, расширение и размер загруженного файла
    $fileFormat = mime_content_type($tmpName);
    $type = explode("/", $fileFormat)[0];
    $extension = explode("/", $fileFormat)[1];
    $fileSize = filesize($tmpName);

    if (!($extension == "jpeg" || $extension == "jpg" || $extension == "png" || $extension == "gif")) {
        // Ошибка типа или размера файла
        header("location: ../../views/user/edit.php?errorUL");
        die();
    } // if

    // Проверка файла изображения, файл не более 5 мегабайт
    if ($type == "image" && $fileSize < 5048576) {
        $uploadTime = microtime();
        $imagesDirectory = "../../web/uploads/profileImage/$userId-$uploadTime.$extension";
    } else {
        // Ошибка типа или размера файла
        header("location: ../../views/user/edit.php?errorUL");
        die();
    } // if
} else {
    $picture = false;
} // if
//-----------------------------------------------------------------------------

// Если пароль не установлен
if (empty($_POST["password"])) {
    $_POST["password"] = false;
} // if

// Проверка radio кнопок
if (!empty($_POST["personal"])) {
    if (!($_POST["personal"] == 1 || $_POST["personal"] == 2)) {
        // Перенаправление на страницу с ошибкой
        header("location: ../../views/error/error_400.php");
        die();
    } // if
} else {
    $_POST["personal"] = 0;
} // if

if (!empty($_POST["address"])) {
    if (!(strlen($_POST["address"]) > 4 && strlen($_POST["address"]) < 200)) {
        // Ошибка длины адреса
        header("location: ../../views/user/edit.php?errorAR");
        die();
    } // if
} else {
    $_POST["address"] = 0;
} // if

// Проверка обновлений | @codingStandardsIgnoreStart
if (!empty($_POST["email"]) && (!empty($_POST["password"]) || $_POST["password"] === false) && !empty($_POST["firstName"])
    && !empty($_POST["lastName"]) && !empty($_POST["mobilePhone"])) { // @codingStandardsIgnoreEnd

    $email = $_POST["email"];
    $password = $_POST["password"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $mobilePhone = $_POST["mobilePhone"];

    // Проверка введённого email
    if (!(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 3 && strlen($email) < 254)) {
        // Перенаправление на страницу с ошибкой
        header("location: ../../views/error/error_400.php");
        die();
    } // if

    // Проверка введённого пароля
    if (!((strlen($password) >= 4 && strlen($password) <= 20) || $password === false)) {
        // Перенаправление на страницу с ошибкой
        header("Location: ../../views/user/edit.php?errorPassSyntax");
        die();
    } // if

    if (!(strlen($firstName) >= 4 && strlen($firstName) < 20)) {
        // Перенаправление на ошибку ввода имени
        header("Location: ../../views/user/edit.php?errorFN");
        die();
    } // if

    if (!(strlen($lastName) >= 4 && strlen($lastName) < 20)) {
        // Перенаправление на ошибку ввода фамилии
        header("Location: ../../views/user/edit.php?errorLN");
        die();
    } // if

    if (!(ctype_digit($mobilePhone) && strlen($mobilePhone) == 10)) {
        // Перенаправление на ошибку ввода номера телефона
        header("Location: ../../views/user/edit.php?errorMN");
        die();
    } // if

    $user = new \models\User();

    // Попытка выполнить соединение с базой данных
    try {
        // DAO пользователя
        $userDao = \models\database\UserDao::getInstance();

        // Устанавливаем нужные данные по пользователю
        $user->setEmail(htmlentities($email));
        $user->setFirstName(htmlentities($firstName));
        $user->setLastName(htmlentities($lastName));
        $user->setMobilePhone(htmlentities($mobilePhone));
        $user->setId($userId);
        $user->setAddress(htmlentities($_POST["address"]));
        $user->setPersonal(htmlentities($_POST["personal"]));

        // Получаем информацию текущего пользователя
        $userArr = $userDao->getUserInfo($user);

        // Проверка правильности пароля
        if (hash('sha256', $_POST["passwordOld"]) == $userArr["password"]) {
            // Проверяем не изменился ли пароль
            if ($password === false) {
                $user->setPassword($userArr["password"]);
            } else {
                $user->setPassword(hash('sha256', $_POST["password"]));
            } // if

            // Проверяем не изменилось ли изображение
            if ($picture) {
                $user->setImageUrl($imagesDirectory);
            } else {
                $user->setImageUrl($userArr["image_url"]);
            } // if

            // Проверяем установлен ли адрес
            if (!empty($_POST["address"])) {
                $user->setAddress(htmlentities($_POST["address"]));
            } else {
                $user->setAddress(0);
            } // if

            // Проверяем установлен ли переключатель типа адреса
            if (!empty($_POST["personal"])) {
                $user->setPersonal(htmlentities($_POST["personal"]));
            } else {
                $user->setPersonal(0);
            } // if

            // Проверяем существует ли пользователь с заданным email
            if ($userDao->checkUserExist($user) && $userArr["email"] != $user->getEmail()) {
                // Ошибка электронной почты
                header("location: ../../views/user/edit.php?errorEmail");
                die();
            } else {
                $user->setRole($userArr["role"]);
                // Редактируем пользователя
                $userDao->editUser($user);

                if ($picture) {
                    // Переместить файл в постоянный каталог
                    move_uploaded_file($tmpName, $imagesDirectory);
                    // Подогнать изображение по адекватным соотношениям сторон
                    cropImage($imagesDirectory, 200);
                } // if

                // В зависимости откуда пришли, туда и перенаправляем
                if (isset($_GET["addAddress"])) {
                    header("location: ../../views/main/checkout.php");
                    die();
                } else {
                    header("location: ../../views/main/index.php");
                    die();
                } // if
            } // if
        } else {
            // Пароль не совпадает
            header("location: ../../views/user/edit.php?errorPassMatch");
            die();
        } // if
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../errors.log");
        header("location: ../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    // Перенаправление на страницу с ошибкой
    header("location: ../../views/error/error_400.php");
    die();
} // if