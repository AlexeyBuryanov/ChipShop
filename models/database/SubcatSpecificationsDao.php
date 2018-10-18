<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use models\SubcatSpecification;
use PDO;

/**
 * Класс содержит в себе всю работу со спецификациями подкатегории.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class SubcatSpecificationsDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql ------------------------------------------------------------------------------
    // Создать спецификацию
    const CREATE_SPEC = "INSERT INTO subcat_specifications (name, subcategory_id) VALUES (?, ?)";
    // Получить все спецификации для подкатегории
    const GET_ALL_SPEC_FOR_SUBCAT = "SELECT * 
                                     FROM subcat_specifications 
                                     WHERE subcategory_id = ?";
    // Получить все спецификации, админ
    const GET_ALL_SPECS_ADMIN = "SELECT scs.id, scs.name, sc.name AS subcat_name 
                                 FROM subcat_specifications scs
                                 LEFT JOIN subcategories sc ON scs.subcategory_id = sc.id";
    // Получить спецификацию
    const GET_SPEC_BY_ID = "SELECT * 
                            FROM subcat_specifications 
                            WHERE id = ?";
    // Редактировать спецификацию
    const EDIT_SPEC = "UPDATE subcat_specifications 
                       SET name = ?, subcategory_id = ? 
                       WHERE id = ?";
    // Удалить спецификацию
    const DELETE_SPEC = "DELETE 
                         FROM subcat_specifications 
                         WHERE id = ?";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new SubcatSpecificationsDao();
        } // if

        return self::$_instance;
    } // getInstance

    /**
     * Создание спецификаций.
     * @param SubcatSpecification $specification - спецификация подкатегории.
     * @return string - айди созданной спецификации.
     */
    function createSpecification(SubcatSpecification $specification) {
        $statement = $this->_pdo->prepare(self::CREATE_SPEC);
        $statement->execute(array(
            $specification->getName(),
            $specification->getSubcategoryId()));

        return $this->_pdo->lastInsertId();
    } // createSpecification

    /**
     * Получение спецификаций для подкатегории.
     * @param $subcatId - айди подкатегории.
     * @return array - ассоциативный массив спецификаций.
     */
    function getAllSpecificationsForSubcategory($subcatId) {
        $statement = $this->_pdo->prepare(self::GET_ALL_SPEC_FOR_SUBCAT);
        $statement->execute(array($subcatId));
        $specs = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $specs;
    } // getAllSpecificationsForSubcategory

    function getAllSubcategorySpecificationsAdmin() {
        $statement = $this->_pdo->prepare(self::GET_ALL_SPECS_ADMIN);
        $statement->execute();
        $specs = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $specs;
    } // getAllSubcategorySpecificationsAdmin

    function getSubcatSpecById($specId) {
        $statement = $this->_pdo->prepare(self::GET_SPEC_BY_ID);
        $statement->execute(array($specId));
        $category = $statement->fetch();

        return $category;
    } // getSubcatSpecById

    function editSubcatSpec(SubcatSpecification $spec) {
        $statement = $this->_pdo->prepare(self::EDIT_SPEC);
        $statement->execute(array($spec->getName(), $spec->getSubcategoryId(), $spec->getId()));

        return true;
    } // editSubcatSpec

    function deleteSubcatSpec($specId) {
        $statement = $this->_pdo->prepare(self::DELETE_SPEC);
        $statement->execute(array($specId));

        return true;
    } // deleteSubcatSpec
} // SubcatSpecificationsDao @codingStandardsIgnoreEnd