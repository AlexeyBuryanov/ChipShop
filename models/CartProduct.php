<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Товар в корзине.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class CartProduct {

    private $_id;
    private $_title;
    private $_price;
    private $_quantity;
    private $_image;

    public function getImage() {
        return $this->_image;
    } // getImage
    public function setImage($image) {
        $this->_image = $image;
    } // setImage

    public function getId() {
        return $this->_id;
    } // getId
    public function setId($id) {
        $this->_id = $id;
    } // setId

    public function getTitle() {
        return $this->_title;
    } // getTitle
    public function setTitle($title) {
        $this->_title = $title;
    } // setTitle

    public function getPrice() {
        return $this->_price;
    } // getPrice
    public function setPrice($price) {
        $this->_price = $price;
    } // setPrice

    public function getQuantity() {
        return $this->_quantity;
    } // getQuantity
    public function setQuantity($quantity) {
        $this->_quantity = $quantity;
    } // setQuantity
} // CartProduct @codingStandardsIgnoreEnd