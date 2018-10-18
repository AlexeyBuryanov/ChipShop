<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use models\Favourites;
use PDO;

/**
 * Класс содержит в себе всю работу с избранными товарами.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class FavouritesDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql ------------------------------------------------------------------------------------
    // Добавить товар в избранное
    const ADD_PRODUCT_TO_FAVOURITES = "INSERT INTO favourites (user_id, product_id) VALUES (?, ?)";
    // Удалить товар из избранного
    const REMOVE_PRODUCT_FROM_FAVOURITES = "DELETE 
                                            FROM favourites 
                                            WHERE user_id = ? 
                                               AND product_id = ?";
    // Для проверки находится ли товар в избранном
    const CHECK_IF_IN_FAVOURITES = "SELECT id 
                                    FROM favourites 
                                    WHERE user_id = ? 
                                       AND product_id = ?";
    // Выборка всех избранных товаров для конкретного пользователя по Id.
    // Цена вычисляется учитывая скидку на товар, если она есть
    const ALL_FAVOURITES_BY_USER_ID = "SELECT p.id, p.title, p.description, 
                                          ROUND(IF(MAX(pr.percent) IS NOT NULL, 
                                          p.price - MAX(pr.percent)/100*p.price, p.price), 2) 
                                          price, MIN(i.image_url) image_url, f.user_id, p.visible, p.subcategory_id 
                                       FROM products p 
                                       JOIN favourites f ON p.id = f.product_id 
                                       JOIN images i ON p.id = i.product_id 
                                       LEFT JOIN promotions pr ON p.id = pr.product_id 
                                       GROUP BY f.id 
                                       HAVING f.user_id = ? 
                                          AND p.visible = 1 
                                          AND p.subcategory_id IS NOT NULL";
    // Подписанные пользователи на продукт
    const SUBSCRIBED_USERS_BY_PRODUCT_ID = "SELECT u.email 
                                            FROM users u 
                                            LEFT JOIN favourites f ON u.id = f.user_id 
                                            WHERE f.product_id = ?";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new FavouritesDao();
        } // if
        return self::$_instance;
    } // getInstance

    /**
     * Добавление продукта в избранное пользователя.
     * @param Favourites $favourite - айди юзера, айди товара.
     */
    function addFavourite(Favourites $favourite) {
        $statement = $this->_pdo->prepare(self::ADD_PRODUCT_TO_FAVOURITES);
        $statement->execute(array($favourite->getUserId(),
                                  $favourite->getProductId())
                            );
    } // addFavourite

    /**
     * Удаление из избранного.
     * @param Favourites $favourite - айди юзера, айди товара.
     */
    function removeFavourite(Favourites $favourite) {
        $statement = $this->_pdo->prepare(self::REMOVE_PRODUCT_FROM_FAVOURITES);
        $statement->execute(array(
                $favourite->getUserId(),
                $favourite->getProductId()
            )
        );
    } // removeFavourite

    /**
     * Для проверки, находится ли продукт в избранном.
     * @param Favourites $favourite - айди юзера, айди товара.
     * @return int - Возвращает 1, если продукт находится в избранном, а 2 - нет.
     */
    function checkFavourites(Favourites $favourite) {
        $statement = $this->_pdo->prepare(self::CHECK_IF_IN_FAVOURITES);
        $statement->execute(array(
                $favourite->getUserId(),
                $favourite->getProductId()
            )
        );

        if ($statement->rowCount()) {
            return 1;
        } else {
            return 2;
        } // if
    } // checkFavourites

    /**
     * Для получения всех продуктов пользователей из избранного.
     * @param Favourites $favourites - id's пользователей.
     * @return array - возвращает все избранные продукты в ассоциативном массиве.
     */
    function getAllFavourites(Favourites $favourites) {
        $statement = $this->_pdo->prepare(self::ALL_FAVOURITES_BY_USER_ID);
        $statement->execute(array(
                $favourites->getUserId()
            )
        );

        $favouritesUser = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $favouritesUser;
    } // getAllFavourites

    /**
     * Для подписки пользователей на продукт.
     * @param $productId - идентификатор товара.
     * @return array - возвращает все избранные продукты в ассоциативном массиве.
     */
    function subscribedUsersForProduct($proudctId) {
        $statement = $this->_pdo->prepare(self::SUBSCRIBED_USERS_BY_PRODUCT_ID);
        $statement->execute(array($proudctId));

        $subscribedUsers = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $subscribedUsers;
    } // subscribedUsersForProduct
} // FavouritesDao @codingStandardsIgnoreEnd