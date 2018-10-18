<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use models\Promotion;
use PDO;

/**
 * Класс содержит в себе всю работу с акциями.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class PromotionsDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql -------------------------------------------------------------------------------------
    // Создать акцию
    const CREATE_PROMOTION = "INSERT INTO promotions (percent, start_date, end_date, product_id) VALUES (?, ?, ?, ?)";
    // Самая большая активная скидка для товара
    const BIGGEST_ACTIVE_BY_PRODUCT_ID = "SELECT percent, start_date, end_date 
                                          FROM promotions 
                                          WHERE product_id = ? 
                                             AND start_date <= now() 
                                             AND end_date >= now() 
                                          ORDER BY percent DESC 
                                          LIMIT 1";
    // Получить все акции на товар для админа
    const GET_ALL_PROMOS_FOR_PRODUCT_ADMIN = "SELECT * 
                                              FROM promotions 
                                              WHERE product_id = ?";
    // Удалить акцию
    const DELETE_PROMOTION = "DELETE 
                              FROM promotions 
                              WHERE id = ?";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new PromotionsDao();
        } // if

        return self::$_instance;
    } // getInstance

    function createPromotion(Promotion $promotion) {
        $statement = $this->_pdo->prepare(self::CREATE_PROMOTION);
        $statement->execute(array(
                $promotion->getPercent(),
                $promotion->getStartDate(),
                $promotion->getEndDate(),
                $promotion->getProductId()
            )
        );
        $promoId = $this->_pdo->lastInsertId();

        return $promoId;
    } // createPromotion

    function getBiggestActivePromotionByProductId($productId) {
        $statement = $this->_pdo->prepare(self::BIGGEST_ACTIVE_BY_PRODUCT_ID);
        $statement->execute(array($productId));
        $promotion = $statement->fetch();

        return $promotion;
    } // getBiggestActivePromotionByProductId

    function getAllPromotionsForProduct($productId) {
        $statement = $this->_pdo->prepare(self::GET_ALL_PROMOS_FOR_PRODUCT_ADMIN);
        $statement->execute(array($productId));
        $promotions = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $promotions;
    } // getAllPromotionsForProduct

    function deletePromotion($promoId) {
        $statement = $this->_pdo->prepare(self::DELETE_PROMOTION);
        $statement->execute(array($promoId));

        return true;
    } // deletePromotion
} // PromotionsDao @codingStandardsIgnoreEnd