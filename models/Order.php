<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Заказ.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class Order {

    private $_id;
    private $_user_id;
    private $_created_at;
    // Статус коды - 1 обрабатывается, 2 ошибка, 3 отправлено, 4 завершено
    private $_status;
    private $_products;

    public function __construct($user_id, $products) {
        $this->_id = microtime();
        $this->_user_id = $user_id;
        $this->_created_at = date("Y-m-d H:i:s");
        $this->_status = 1;
        $this->_products = $products;
    }

    public function getId() {
        return $this->_id;
    } // getId
    public function setId($id) {
        $this->_id = $id;
    } // setId

    public function getUserId() {
        return $this->_user_id;
    } // getUserId
    public function setUserId($user_id) {
        $this->_user_id = $user_id;
    } // setUserId

    public function getCreatedAt() {
        return $this->_created_at;
    } // getCreatedAt
    public function setCreatedAt($created_at) {
        $this->_created_at = $created_at;
    } // setCreatedAt

    public function getStatus() {
        return $this->_status;
    } // getStatus
    public function setStatus($status) {
        $this->_status = $status;
    } // setStatus

    public function getProducts() {
        return $this->_products;
    } // getProducts
    public function setProducts($products) {
        $this->_products = $products;
    } // setProducts
} // Order @codingStandardsIgnoreEnd