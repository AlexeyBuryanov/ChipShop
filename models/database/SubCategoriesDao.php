<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use models\SubCategory;

/**
 * Класс содержит в себе всю работу с подкатегориями.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class SubCategoriesDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql -----------------------------------------------------------------
    // Создать подкатегорию
    const CREATE_SUBCAT = "INSERT INTO subcategories (name, category_id) VALUES (?, ?)";
    // Получить все подкатегории
    const GET_ALL_SUBCATS = "SELECT * 
                             FROM subcategories";
    // Получить название подкатегории
    const GET_SUBCAT_NAME = "SELECT name 
                             FROM subcategories 
                             WHERE id = ?";
    // Получить все подкатегории, админ
    const GET_ALL_SUBCATS_ADMIN = "SELECT sc.id, sc.name, c.name AS catname 
                                   FROM subcategories sc 
                                   LEFT JOIN categories c ON sc.category_id = c.id";
    // Получить все подкатегории без товаров
    const GET_ALL_SUBCATS_WITHOUT_PRODUCTS = "SELECT sc.* 
                                              FROM subcategories sc 
                                              WHERE NOT EXISTS(
                                                  SELECT * 
                                                  FROM products p 
                                                  WHERE p.subcategory_id = sc.id)";
    // Получить подкатегорию по id
    const GET_SUBCAT_BY_ID = "SELECT * 
                              FROM subcategories 
                              WHERE id = ?";
    // Редактировать подкатегорию
    const EDIT_SUBCAT = "UPDATE subcategories 
                         SET name = ?, category_id = ? 
                         WHERE id = ?";
    // Удалить подкатегорию
    const DELETE_SUBCAT = "DELETE 
                           FROM subcategories 
                           WHERE id = ?";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new SubCategoriesDao();
        } // if

        return self::$_instance;
    } // getInstance

    /**
     * Создание сабкатегории.
     * @param SubCategory $subCategory - новая подкатегория.
     * @return string - айди подкатегории.
     */
    function createSubCategory(SubCategory $subCategory) {
        $statement = $this->_pdo->prepare(self::CREATE_SUBCAT);
        $statement->execute(array(
            $subCategory->getName(),
            $subCategory->getCategoryId()));

        return $this->_pdo->lastInsertId();
    } // createSubCategory

    /**
     * Получение всех подкатегорий.
     * @return array - массив подкатегорий.
     */
    function getAllSubCategories() {
        $statement = $this->_pdo->prepare(self::GET_ALL_SUBCATS);
        $statement->execute();
        $subcategories = $statement->fetchAll();

        return $subcategories;
    } // getAllSubCategories

    function getAllSubCategoriesWithoutProducts() {
        $statement = $this->_pdo->prepare(self::GET_ALL_SUBCATS_WITHOUT_PRODUCTS);
        $statement->execute();
        $subcategories = $statement->fetchAll();

        return $subcategories;
    } // getAllSubCategoriesWithoutProducts

    function getAllSubCategoriesAdmin() {
        $statement = $this->_pdo->prepare(self::GET_ALL_SUBCATS_ADMIN);
        $statement->execute();
        $subcategories = $statement->fetchAll();

        return $subcategories;
    } // getAllSubCategoriesAdmin

    function getSubCategoryName($subId) {
        $statement = $this->_pdo->prepare(self::GET_SUBCAT_NAME);
        $statement->execute(array($subId));
        $subcategory = $statement->fetch();

        return $subcategory[0];
    } // getSubCategoryName

    function getSubCategoryById($subcatId) {
        $statement = $this->_pdo->prepare(self::GET_SUBCAT_BY_ID);
        $statement->execute(array($subcatId));
        $category = $statement->fetch();

        return $category;
    } // getSubCategoryById

    function editSubCategory(SubCategory $subcat) {
        $statement = $this->_pdo->prepare(self::EDIT_SUBCAT);
        $statement->execute(array($subcat->getName(), $subcat->getCategoryId(), $subcat->getId()));

        return true;
    } // editSubCategory

    function deleteSubCategory($subcatId) {
        $statement = $this->_pdo->prepare(self::DELETE_SUBCAT);
        $statement->execute(array($subcatId));

        return true;
    } // deleteSubCategory
} // SubCategoriesDao @codingStandardsIgnoreEnd