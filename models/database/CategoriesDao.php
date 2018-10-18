<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\Category;
use models\database\Connect\Connection;
use PDO;

/**
 * Класс содержит в себе всю работу с категориями.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class CategoriesDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql --------------------------------------------------------------
    // Создание категории
    const CREATE_CAT = "INSERT INTO categories (name, supercategory_id) VALUES (?, ?)";
    // Получить все категории
    const GET_ALL_CATS = "SELECT * 
                          FROM categories";
    // Получить все категории для админа
    const GET_ALL_CATS_ADMIN = "SELECT c.id, c.name, sc.name AS supercatname 
                                FROM categories c 
                                LEFT JOIN supercategories sc ON c.supercategory_id = sc.id";
    // Получить конкретную категорию
    const GET_CAT_BY_ID = "SELECT * 
                           FROM categories 
                           WHERE id = ?";
    // Редактировать категорию
    const EDIT_CAT = "UPDATE categories 
                      SET name = ?, supercategory_id = ? 
                      WHERE id = ?";
    // Удалить категорию
    const DELETE_CAT = "DELETE 
                        FROM categories 
                        WHERE id = ?";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance(){
        if (self::$_instance === null) {
            self::$_instance = new CategoriesDao();
        } // if
        return self::$_instance;
    } // getInstance

    /**
     * Создание категории.
     * @param Category $category - получает новое название категории и это айди супер категории.
     * @return string - возвращает идентификатор новой категории.
     */
    function createCategory(Category $category) {
        $statement = $this->_pdo->prepare(self::CREATE_CAT);
        $statement->execute(array(
            $category->getName(),
            $category->getSupercategoryId())
        );
        return $this->_pdo->lastInsertId();
    } // createCategory

    /**
     * Для получения категорий.
     * @return array - возвращает все категории как ассоциативный массив.
     */
    function getAllCategories() {
        $statement = $this->_pdo->prepare(self::GET_ALL_CATS);
        $statement->execute();
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    } // getAllCategories

    function getAllCategoriesAdmin() {
        $statement = $this->_pdo->prepare(self::GET_ALL_CATS_ADMIN);
        $statement->execute();
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    } // getAllCategoriesAdmin

    function getCategoryById($catId) {
        $statement = $this->_pdo->prepare(self::GET_CAT_BY_ID);
        $statement->execute(array($catId));
        $category = $statement->fetch();
        return $category;
    } // getCategoryById

    function editCategory(Category $cat) {
        $statement = $this->_pdo->prepare(self::EDIT_CAT);
        $statement->execute(array($cat->getName(), $cat->getSupercategoryId(), $cat->getId()));
        return true;
    } // editCategory

    function deleteCategory($catId) {
        $statement = $this->_pdo->prepare(self::DELETE_CAT);
        $statement->execute(array($catId));
        return true;
    } // deleteCategory
} // CategoriesDao @codingStandardsIgnoreEnd