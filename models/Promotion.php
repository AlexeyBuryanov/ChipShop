<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Акция/скидка.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class Promotion {

    private $_id;
    private $_percent;
    private $_start_date;
    private $_end_date;
    private $_product_id;

    public function __construct($percent, $start_date, $end_date, $product_id) {
        $this->_percent = $percent;
        $this->_start_date = $start_date;
        $this->_end_date = $end_date;
        $this->_product_id = $product_id;
    }

    public function getId() {
        return $this->_id;
    } // getId
    public function setId($id) {
        $this->_id = $id;
    } // setId

    public function getPercent() {
        return $this->_percent;
    } // getPercent
    public function setPercent($percent) {
        $this->_percent = $percent;
    } // setPercent

    public function getStartDate() {
        return $this->_start_date;
    } // getStartDate
    public function setStartDate($start_date) {
        $this->_start_date = $start_date;
    } // setStartDate

    public function getEndDate() {
        return $this->_end_date;
    } // getEndDate
    public function setEndDate($end_date) {
        $this->_end_date = $end_date;
    } // setEndDate

    public function getProductId() {
        return $this->_product_id;
    } // getProductId
    public function setProductId($product_id) {
        $this->_product_id = $product_id;
    } // setProductId
} // Promotion @codingStandardsIgnoreEnd