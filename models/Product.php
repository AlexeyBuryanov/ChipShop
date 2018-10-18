<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Товар/продукт.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class Product {

    private $_id;
    private $_title;
    private $_description;
    private $_price;
    private $_quantity;
    private $_visible;
    private $_createdAt;
    private $_subcategoryId;

    public function __construct() {
        $this->_visible = 1;
        $this->_createdAt = date("Y-m-d H:i:s");
    }

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

    public function getDescription() {
        return $this->_description;
    } // getDescription
    public function setDescription($description) {
        $this->_description = $description;
    } // setDescription

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

    public function getVisible() {
        return $this->_visible;
    } // getVisible
    public function setVisible($visible) {
        $this->_visible = $visible;
    } // setVisible

    public function getCreatedAt() {
        return $this->_createdAt;
    } // getCreatedAt

    public function getSubcategoryId() {
        return $this->_subcategoryId;
    } // getSubcategoryId
    public function setSubcategoryId($subcategoryId) {
        $this->_subcategoryId = $subcategoryId;
    } // setSubcategoryId
} // Product @codingStandardsIgnoreEnd