<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use models\Order;
use PDO;

/**
 * Класс содержит в себе всю работу с заказами.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class OrdersDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql ------------------------------------------------------------------------------------
    // Добавить новый заказ
    const ADD_NEW_ORDER = "INSERT INTO orders (user_id, created_at, status) VALUES (?, ?, ?)";
    // Добавить новый заказ в таблицу заказанных товаров
    const ADD_ORDER_PRODUCT = "INSERT INTO order_products (order_id, product_id, quantity) VALUES (?, ?, ?)";
    // Получить все заказы для админа
    const GET_ALL_ORDERS_ADMIN = "SELECT o.id, u.email AS email, o.created_at, o.status 
                                  FROM orders o 
                                  INNER JOIN users u ON o.user_id = u.id 
                                  ORDER BY o.created_at DESC";
    // Изменить статус заказа
    const CHANGE_ORDER_STATUS = "UPDATE orders 
                                 SET status = ? 
                                 WHERE id = ?";
    // Получить email пользователя по заказу
    const GET_USER_EMAIL_BY_ORDER = "SELECT u.email 
                                     FROM users u 
                                     JOIN orders o ON u.id = o.user_id 
                                     WHERE o.id = ?";
    // Получить подробности/детали о заказе
    const GET_ORDER_DETAILS = "SELECT o.id, u.email AS email, o.created_at, o.status, p.title AS product, op.quantity 
                                  AS quantity, p.id AS product_id, u.id AS user_id 
                               FROM orders o
                               INNER JOIN users u ON o.user_id = u.id
                               INNER JOIN order_products op ON op.order_id = o.id
                               INNER JOIN products p ON op.product_id = p.id
                               WHERE o.id = ?";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new OrdersDao();
        } // if

        return self::$_instance;
    } // getInstance

    function newOrder(Order $order, $cart) {
        $this->_pdo->beginTransaction();

        try {
            // Создаём новый заказ и получаем идентификатор
            $statement = $this->_pdo->prepare(self::ADD_NEW_ORDER);
            $statement->execute(array($order->getUserId(), $order->getCreatedAt(), $order->getStatus()));
            $orderId = $this->_pdo->lastInsertId();

            // Заполняем заказ товарами и возвращаем идентификатор, общую стоимость 
            // и количество заказа в виде массива
            $totalPrice = 0;
            $quantity = 0;
            foreach ($cart as $cartProduct) {
                $totalPrice += $cartProduct->getPrice() * $cartProduct->getQuantity();
                $quantity += $cartProduct->getQuantity();

                $statement = $this->_pdo->prepare(self::ADD_ORDER_PRODUCT);
                $statement->execute(array($orderId, $cartProduct->getId(), $cartProduct->getQuantity()));
            } // foreach

            $statement = $this->_pdo->prepare(self::GET_USER_EMAIL_BY_ORDER);
            $statement->execute(array($orderId));

            $email = $statement->fetch();

            $result = [$orderId, $totalPrice, $quantity, $email[0]];
            $this->_pdo->commit();

            return $result;
        } catch (\PDOException $e) {
            $this->_pdo->rollBack();
            $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
            error_log($message, 3, "../../errors.log");
            header("location: ../../views/error/error_500.php");
            die();
        } // try-catch
    } // newOrder

    function getAllOrdersAdmin() {
        $statement = $this->_pdo->prepare(self::GET_ALL_ORDERS_ADMIN);
        $statement->execute();

        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    } // getAllOrdersAdmin

    function changeOrderStatus($orderId, $newStatus) {
        $statement = $this->_pdo->prepare(self::CHANGE_ORDER_STATUS);
        $statement->execute(array($newStatus, $orderId));

        $statement = $this->_pdo->prepare(self::GET_USER_EMAIL_BY_ORDER);
        $statement->execute(array($orderId));

        $email = $statement->fetch();

        return $email[0];
    } // changeOrderStatus

    function getOrderDetails($orderId) {
        $statement = $this->_pdo->prepare(self::GET_ORDER_DETAILS);
        $statement->execute(array($orderId));

        $order = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $order;
    } // getOrderDetails
} // OrdersDao @codingStandardsIgnoreEnd