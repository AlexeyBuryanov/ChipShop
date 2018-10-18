<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use models\Reviews;
use PDO;

/**
 * Класс содержит в себе всю работу с отзывами.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class ReviewsDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql ---------------------------------------------------------------------------------------
    // Добавить обзор
    const ADD_REVIEW = "INSERT INTO reviews (title, comment, rating, user_id, product_id, created_at) VALUES (?, ?, ?, ?, ?, ?)";
    // Получить обзоры на товар
    const GET_REVIEWS_FOR_PRODUCT = "SELECT r.id, r.title, r.comment, r.rating, r.user_id, r.product_id, r.created_at, 
                                        u.image_url, u.first_name 
                                     FROM reviews r JOIN users u ON u.id = r.user_id 
                                     WHERE product_id = ? 
                                     ORDER BY r.created_at DESC";
    // Удалить обзор
    const REMOVE_REVIEW = "DELETE 
                           FROM reviews 
                           WHERE id = ?";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new ReviewsDao();
        } // if

        return self::$_instance;
    } // getInstance

    /**
     * Добавление отзыва.
     * @param Reviews $reviews
     * @return string - возвращает айди отзыва.
     */
    function addNewReview(Reviews $reviews) {
        $statement = $this->_pdo->prepare(self::ADD_REVIEW);
        $statement->execute(array(
                $reviews->getTitle(),
                $reviews->getComment(),
                $reviews->getRating(),
                $reviews->getUserId(),
                $reviews->getProductId(),
                $reviews->getCreatedAt()
            )
        );

        return $this->_pdo->lastInsertId();
    } // addNewReview

    /**
     * Получает все отзывы для продукта.
     * @param $productId - существующий айди продукта.
     * @return array - отзывы
     */
    function getReviewsForProduct($productId) {
        $statement = $this->_pdo->prepare(self::GET_REVIEWS_FOR_PRODUCT);
        $statement->execute(array($productId));
        $reviewsReceived = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $reviewsReceived;
    } // getReviewsForProduct

    /**
     * Удаление отзыва.
     * @param $productId - существующий айди продукта.
     */
    function removeReview($productId) {
        $statement = $this->_pdo->prepare(self::REMOVE_REVIEW);
        $statement->execute(array($productId));
    } // removeReview
} // ReviewsDao @codingStandardsIgnoreEnd