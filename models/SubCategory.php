<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Подкатегория.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class SubCategory {

    private $_id;
    private $_name;
    private $_category_id;

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

    public function getCategoryId() {
        return $this->_category_id;
    } // getCategoryId
    public function setCategoryId($category_id) {
        $this->_category_id = $category_id;
    } // setCategoryId
} // SubCategory @codingStandardsIgnoreEnd