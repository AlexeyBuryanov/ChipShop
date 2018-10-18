<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Спецификация подкатегории.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class SubcatSpecification {

    private $_id;
    private $_name;
    private $_subcategory_id;

    public function setId($id) {
        $this->_id = $id;
    } // setId
    public function getId() {
        return $this->_id;
    } // getId

    public function getName() {
        return $this->_name;
    } // getName
    public function setName($name) {
        $this->_name = $name;
    } // setName

    public function getSubcategoryId() {
        return $this->_subcategory_id;
    } // getSubcategoryId
    public function setSubcategoryId($subcategory_id) {
        $this->_subcategory_id = $subcategory_id;
    } // setSubcategoryId
} // SubcatSpecification @codingStandardsIgnoreEnd