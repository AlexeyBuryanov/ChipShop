<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use models\SuperCategory;
use PDO;

/**
 * Класс содержит в себе всю работу с супер-категорией.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class SuperCategoriesDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql -------------------------------------------
    // Создать суперкатегорию
    const CREATE_SUPERCAT = "INSERT INTO supercategories (name) VALUES (?)";
    // Получить все суперкатегории
    const GET_ALL_SUPERCATS = "SELECT * 
                               FROM supercategories";
    // Получить суперкатегорию
    const GET_SUPERCAT_BY_ID = "SELECT * 
                                FROM supercategories 
                                WHERE id = ?";
    // Редактировать суперкатегорию
    const EDIT_SUPERCAT = "UPDATE supercategories 
                           SET name = ? 
                           WHERE id = ?";
    // Удалить суперкатегорию
    const DELETE_SUPERCAT = "DELETE 
                             FROM supercategories 
                             WHERE id = ?";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new SuperCategoriesDao();
        } // if

        return self::$_instance;
    } // getInstance

    /**
     * Для создания супер-категории.
     * @param SuperCategory $superCategory - суперкатегория
     * @return string - айди суперкатегории.
     */
    function createSuperCategory(SuperCategory $superCategory) {
        $statement = $this->_pdo->prepare(self::CREATE_SUPERCAT);
        $statement->execute(array(
            $superCategory->getName()));

        return $this->_pdo->lastInsertId();
    } // createSuperCategory

    /**
     * Возвращает все супер категории.
     * @return array - массив супер категорий.
     */
    function getAllSuperCategories() {
        $statement = $this->_pdo->prepare(self::GET_ALL_SUPERCATS);
        $statement->execute();
        $supercategories = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $supercategories;
    } // getAllSuperCategories

    function getSuperCategoryById($superCatId) {
        $statement = $this->_pdo->prepare(self::GET_SUPERCAT_BY_ID);
        $statement->execute(array($superCatId));
        $supercategory = $statement->fetch();

        return $supercategory;
    } // getSuperCategoryById

    function editSuperCategory(SuperCategory $superCat) {
        $statement = $this->_pdo->prepare(self::EDIT_SUPERCAT);
        $statement->execute(array($superCat->getName(), $superCat->getId()));

        return true;
    } // editSuperCategory

    function deleteSuperCategory($superCatId) {
        $statement = $this->_pdo->prepare(self::DELETE_SUPERCAT);
        $statement->execute(array($superCatId));

        return true;
    } // deleteSuperCategory
} // SuperCategoriesDao @codingStandardsIgnoreEnd