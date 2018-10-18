<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Контроллит редактирование товара

// Автозагрузка требуемых файлов моделей
spl_autoload_register(
    function ($className) {
        $className = "..\\..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);

// Стартуем сессию
session_start();

// Подключаем обработчик ошибок
require_once "../../../utils/error_handler_dir_back.php";
// Подключаем проверку Admin/Mod
require_once "../../../utils/admin_mod_session.php";
// Подключаем функцию обрезки изображения
require_once "../../../utils/imageCrop.php";

// Если действие подтверждено
if (isset($_POST["submit"])) {
    $product = new \models\Product();

    // Валидация | @codingStandardsIgnoreStart
    if (empty($_POST["pid"]) || 
        strlen($_POST["title"]) > 50 || 
        strlen($_POST["description"]) > 150000 || 
        $_POST["price"] < 0 || 
        $_POST["price"] > 100000000 || 
        $_POST["quantity"] < 0 || 
        $_POST["quantity"] > 1000000000) {
        header("location: ../../../views/error/error_400.php");
        die();
    } // @codingStandardsIgnoreEnd

    // Информация о продукте
    $product->setId($_POST["pid"]);
    $product->setTitle(htmlentities($_POST["title"]));
    $product->setDescription($_POST["description"]);
    $product->setPrice(htmlentities($_POST["price"]));
    $product->setQuantity(htmlentities($_POST["quantity"]));

    // Обработка изображений
    $images = array();
    $pictureFlag = false;

    // @codingStandardsIgnoreStart
    if (!empty($_FILES["pic1"]["tmp_name"]) &&
        !empty($_FILES["pic2"]["tmp_name"]) &&
        !empty($_FILES["pic3"]["tmp_name"])) {
        // @codingStandardsIgnoreEnd
        $pictureFlag = true;

        for ($i = 1; $i < 4; $i++) {
            $imagesDirectoryMove = null;
            $imagesDirectoryView = null;
            $imageInput = "pic$i";
            $tmpName = null;
            $userId = $_SESSION["loggedUser"];

            if (!empty($_FILES[$imageInput]["tmp_name"])) {
                $tmpName = $_FILES[$imageInput]["tmp_name"];
                if (!is_uploaded_file($tmpName)) {
                    // Перенаправление на страницу с ошибкой
                    header("location: ../../../views/error/error_400.php");
                    die();
                } // if

                // Получить тип, расширение и размер загруженного файла
                $fileFormat = mime_content_type($tmpName);
                $type = explode("/", $fileFormat)[0];
                $extension = explode("/", $fileFormat)[1];
                $fileSize = filesize($tmpName);

                // Проверить файл изображения - файл не больше 5 МБ
                if ($type == "image" && $fileSize < 5048576) {
                    $uploadTime = microtime();
                    $fileName = $userId . $uploadTime . "." . $extension;

                    $imagesDirectoryView = "../../web/uploads/productImages/$fileName";
                    $imagesDirectoryMove = "../../../web/uploads/productImages/$fileName";

                    move_uploaded_file($tmpName, $imagesDirectoryMove);
                    cropImage($imagesDirectoryMove, 1000);
                    $imagesCatch[] = $imagesDirectoryMove;
                    $images[] = $imagesDirectoryView;
                } else {
                    // Перенаправление на страницу с ошибкой
                    header("location: ../../../views/error/error_400.php");
                    die();
                } // if
            } else {
                // Перенаправление на страницу с ошибкой
                header("location: ../../../views/error/error_400.php");
                die();
            } // if
        } // for i
    } // if

    // Подкатегория продукта и спецификации
    $subcatId = $_POST["subcategory_id"];
    $product->setSubcategoryId(htmlentities($subcatId));
    $oldSubcatId = $_POST["scid"];
    $specs = array();
    $specsCount = $_POST["specsCount"];
    for ($i = 0; $i < $specsCount; $i++) {
        $specValue = $_POST["specValue-" . $i];
        $specId = $_POST["specValueId-" . $i];
        $specObj = new \models\ProductSpecification();
        $specObj->setValue($specValue);
        // Если категория такая же, как и раньше, задаём идентификатор спецификации, 
        // иначе задаём новый идентификатор спецификации подкатегории
        if ($subcatId === $oldSubcatId) {
            $specObj->setId($specId);
            $specs[0]["newSubcat"] = 0;
        } else {
            $specObj->setSubcatSpecId($specId);
            $specs[0]["newSubcat"] = 1;
        } // if
        $specs[1][] = $specObj;
    } // for i

    // Попытка выполнить соединение с базой данных
    try {
        // DAO товаров
        $productDao = \models\database\ProductsDao::getInstance();
        // DAO изображений
        $productImagesDao = \models\database\ProductImagesDao::getInstance();
        // Получаем старые изображения
        $oldImgArr = $productImagesDao->getAllProductImages($_POST["pid"]);
        // Редактируем
        $id = $productDao->editProduct($product, $images, $specs);
        // Если редактирование не прошло - удаляем изображения
        if ($id === false) {
            foreach ($imagesCatch as $dir) {
                unlink($dir);
            } // foreach
            header("location: ../../../views/error/error_500.php");
            die();
        } // if

        // Удаление старых изображений
        if ($pictureFlag) {
            foreach ($oldImgArr as $img) {
                unlink("../".$img["image_url"]);
            } // foreach
        } // if

        header("location: ../../../views/admin/products_promotions_reviews/products_view.php");
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("location: ../../../views/error/error_500.php");
        die();
    } // try-catch
} else {
    try {
        $subcatDao = \models\database\SubCategoriesDao::getInstance();
        $subcategories = $subcatDao->getAllSubCategories();
        $productDao = \models\database\ProductsDao::getInstance();
        $product = $productDao->getProductByIDAdmin($_GET["pid"]);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
        error_log($message, 3, "../../../errors.log");
        header("location: ../../../views/error/error_500.php");
        die();
    } // try-catch
} // if