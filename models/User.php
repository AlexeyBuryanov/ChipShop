<?php // @codingStandardsIgnoreStart

namespace models;

/**
 * Модель пользователя.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class User {

    private $_id;
    private $_email;
    private $_enabled;
    private $_firstName;
    private $_lastName;
    private $_mobilePhone;
    private $_imageUrl;
    private $_password;
    private $_lastLogin;
    private $_role;
    private $_address;
    private $_personal;

    public function __construct() {
        $this->_enabled = 1;
        $this->_imageUrl = "../../web/assets/images/default.jpg";
        $this->_lastLogin = date("Y-m-d H:i:s");
        $this->_address = 0;
        $this->_personal = 1;
        $this->_firstName = "User";
    }

    public function getId() {
        return $this->_id;
    } // getId
    public function setId($id) {
        $this->_id = $id;
    } // setId

    public function getEmail() {
        return $this->_email;
    } // getEmail
    public function setEmail($email) {
        $this->_email = $email;
    } // setEmail

    public function getEnabled() {
        return $this->_enabled;
    } // getEnabled
    public function setEnabled($enabled) {
        $this->_enabled = $enabled;
    } // setEnabled

    public function getFirstName() {
        return $this->_firstName;
    } // getFirstName
    public function setFirstName($firstName) {
        $this->_firstName = $firstName;
    } // setFirstName

    public function getLastName() {
        return $this->_lastName;
    } // getLastName
    public function setLastName($lastName) {
        $this->_lastName = $lastName;
    } // setLastName

    public function getMobilePhone() {
        return $this->_mobilePhone;
    } // getMobilePhone
    public function setMobilePhone($mobilePhone) {
        $this->_mobilePhone = $mobilePhone;
    } // setMobilePhone

    public function getImageUrl() {
        return $this->_imageUrl;
    } // getImageUrl
    public function setImageUrl($imageUrl) {
        $this->_imageUrl = $imageUrl;
    } // setImageUrl

    public function getPassword() {
        return $this->_password;
    } // getPassword
    public function setPassword($password) {
        $this->_password = $password;
    } // setPassword

    public function getLastLogin() {
        return $this->_lastLogin;
    } // getLastLogin
    public function setLastLogin() {
        $this->_lastLogin = date("Y-m-d H:i:s");
    } // setLastLogin

    public function getRole() {
        return $this->_role;
    } // getRole
    public function setRole($role) {
        $this->_role = $role;
    } // setRole

    public function getAddress() {
        return $this->_address;
    } // getAddress
    public function setAddress($address) {
        $this->_address = $address;
    } // setAddress

    public function getPersonal() {
        return $this->_personal;
    } // getPersonal
    public function setPersonal($personal) {
        $this->_personal = $personal;
    } // setPersonal
} // User @codingStandardsIgnoreEnd