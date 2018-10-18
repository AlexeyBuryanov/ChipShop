<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use models\ProductSpecification;
use PDO;

/**
 * Класс содержит в себе всю работу со спецификациями товаров.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class ProductSpecificationsDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql -------------------------------------------------------------------------------------
    // Заполнить/вставить/создать/записать спецификацию
    const FILL_SPEC = "INSERT INTO subcat_specification_value (value, subcat_spec_id, product_id) VALUES (?, ?, ?)";
    // Получить спецификации для конкретного продукта/товара
    const GET_SPECS_FOR_PRODUCT = "SELECT v.value, s.name 
                                   FROM subcat_specification_value v
                                   INNER JOIN subcat_specifications s ON v.subcat_spec_id = s.id 
                                   WHERE v.product_id = ?";
    // Получить спецификации для конкретного товара для админа
    const GET_SPECS_FOR_PRODUCT_ADMIN = "SELECT v.id, v.value, s.name 
                                         FROM subcat_specification_value v
                                         LEFT JOIN subcat_specifications s ON v.subcat_spec_id = s.id 
                                         WHERE v.product_id = ?";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new ProductSpecificationsDao();
        } // if

        return self::$_instance;
    } // getInstance

    /**
     * Для заполнения спецификаций продукта.
     * @param ProductSpecification $specification - существующий объект со спецификацией и идентификатором продукта.
     * @return bool
     */
    function fillSpecification(ProductSpecification $specification) {
        $statement = $this->_pdo->prepare(self::FILL_SPEC);
        $statement->execute(array(
                $specification->getValue(),
                $specification->getSubcatSpecId(),
                $specification->getProductId()
            )
        );

        return true;
    } // fillSpecification

    /**
     * Получение спецификаций для продукта.
     * @param $productId - существующий айди продукта.
     * @return array - возвращает спецификации товара/продукта.
     */
    function getAllSpecificationsForProduct($productId) {
        $statement = $this->_pdo->prepare(self::GET_SPECS_FOR_PRODUCT);
        $statement->execute(array($productId));
        $specifications = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $specifications;
    } // getAllSpecificationsForProduct

    /**
     * Получение спецификаций для продукта.
     * @param $productId - существующий айди продукта.
     * @return array - возвращает спецификации товара/продукта.
     */
    function getAllSpecificationsForProductAdmin($productId) {
        $statement = $this->_pdo->prepare(self::GET_SPECS_FOR_PRODUCT_ADMIN);
        $statement->execute(array($productId));
        $specifications = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $specifications;
    } // getAllSpecificationsForProductAdmin
} // ProductSpecificationsDao @codingStandardsIgnoreEnd