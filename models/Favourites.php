<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Избранное.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class Favourites {

    private $_user_id;
    private $_product_id;

    public function getUserId() {
        return $this->_user_id;
    } // getUserId
    public function setUserId($user_id) {
        $this->_user_id = $user_id;
    } // setUserId

    public function getProductId() {
        return $this->_product_id;
    } // getProductId
    public function setProductId($product_id) {
        $this->_product_id = $product_id;
    } // setProductId
} // Favourites @codingStandardsIgnoreEnd