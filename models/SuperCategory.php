<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Супер категория/главная категория товаров.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class SuperCategory {

    private $_id;
    private $_name;

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
} // SuperCategory @codingStandardsIgnoreEnd