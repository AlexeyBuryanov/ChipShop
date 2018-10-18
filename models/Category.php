<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Категория.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class Category {

    private $_id;
    private $_name;
    private $_supercategory_id;

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

    public function getSupercategoryId() {
        return $this->_supercategory_id;
    } // getSupercategoryId
    public function setSupercategoryId($supercategory_id) {
        $this->_supercategory_id = $supercategory_id;
    } // setSupercategoryId
} // Category @codingStandardsIgnoreEnd