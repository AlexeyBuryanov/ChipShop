<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Спецификация товара.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class ProductSpecification {

    private $_id;
    private $_value;
    private $_subcatSpecId;
    private $_productId;

    public function getId() {
        return $this->_id;
    } // getId
    public function setId($id) {
        $this->_id = $id;
    } // setId

    public function getValue() {
        return $this->_value;
    } // getValue
    public function setValue($value) {
        $this->_value = $value;
    } // setValue

    public function getSubcatSpecId() {
        return $this->_subcatSpecId;
    } // getSubcatSpecId
    public function setSubcatSpecId($subcatSpecId) {
        $this->_subcatSpecId = $subcatSpecId;
    } // setSubcatSpecId

    public function getProductId() {
        return $this->_productId;
    } // getProductId
    public function setProductId($productId) {
        $this->_productId = $productId;
    } // setProductId
} // ProductSpecification @codingStandardsIgnoreEnd