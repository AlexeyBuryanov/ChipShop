<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use PDO;

/**
 * Класс содержит в себе всю работу над изображениями товаров.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class ProductImagesDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql -------------------------------------------------------------
    // Добавить изображение для товара
    const ADD_PRODUCT_IMAGE = "INSERT INTO images (image_url, product_id) VALUES (?, ?)";
    // Получить все изображения для товара
    const GET_PRODUCT_IMAGES = "SELECT image_url 
                                FROM images 
                                WHERE product_id = ?";
    // Получить первое изображение
    const GET_FIRST_IMAGE = "SELECT image_url 
                             FROM images 
                             WHERE product_id = ? 
                             LIMIT 1";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new ProductImagesDao();
        } // if

        return self::$_instance;
    } // getInstance

    /**
     * Добавление пути картинки в базу данных.
     * @param ProductImage $image - содержит путь изображения товара и идентификатор товара.
     */
    function addProductImage(ProductImage $image) {
        $statement = $this->_pdo->prepare(self::ADD_PRODUCT_IMAGE);
        $statement->execute(array(
                $image->getImageUrl(),
                $image->getProductId()
            )
        );
    } // addProductImage

    /**
     * Возвращает все изображения товара.
     * @param $productId - айди товара.
     * @return array - возвращает картинки продукта в виде ассоциативного массива.
     */
    function getAllProductImages($productId) {
        $statement = $this->_pdo->prepare(self::GET_PRODUCT_IMAGES);
        $statement->execute(array($productId));
        $images = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $images;
    } // getAllProductImages

    /**
     * Возвращает изображение первого продукта.
     * @param $productId - айди товара.
     * @return mixed - возвращает путь к изображению.
     */
    function getFirstProductImage($productId) {
        $statement = $this->_pdo->prepare(self::GET_FIRST_IMAGE);
        $statement->execute(array($productId));
        $image = $statement->fetch();

        return $image["image_url"];
    } // getFirstProductImage
} // ProductImagesDao @codingStandardsIgnoreEnd