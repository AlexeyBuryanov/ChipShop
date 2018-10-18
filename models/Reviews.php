<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Отзыв.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class Reviews {

    private $_title;
    private $_comment;
    private $_rating;
    private $_user_id;
    private $_product_id;
    private $_created_at;

    public function __construct() {
        $this->_user_id = $_SESSION["loggedUser"];
        $this->_created_at = date("Y-m-d H:i:s");
    }

    public function getTitle() {
        return $this->_title;
    } // getTitle
    public function setTitle($title) {
        $this->_title = $title;
    } // setTitle

    public function getComment() {
        return $this->_comment;
    } // getComment
    public function setComment($comment) {
        $this->_comment = $comment;
    } // setComment

    public function getRating() {
        return $this->_rating;
    } // getRating
    public function setRating($rating) {
        $this->_rating = $rating;
    } // setRating

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

    public function getCreatedAt() {
        return $this->_created_at;
    } // getCreatedAt
    public function setCreatedAt($created_at) {
        $this->_created_at = $created_at;
    } // setCreatedAt
} // Reviews @codingStandardsIgnoreEnd