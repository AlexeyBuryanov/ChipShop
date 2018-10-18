<?php // @codingStandardsIgnoreStart

namespace models\database;

use models\database\Connect\Connection;
use models\User;
use PDO;
use PDOException;

/**
 * Класс содержит в себе всю работу с пользователями.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class UserDao {

    private static $_instance;
    private $_pdo;

    // Константы с выражениями sql --------------------------------------------------------------------
    // Проверить вход
    const CHECK_LOGIN = "SELECT id, email, password 
                         FROM users 
                         WHERE email = ? 
                            AND password = ?";
    // Проверить существует ли пользовать
    const CHECK_USER_EXIST = "SELECT id 
                              FROM users 
                              WHERE email = ?";
    // Регистрация
    const REGISTER_USER = "INSERT INTO users (email, enabled, first_name, last_name, mobile_phone,
                           image_url, password, last_login, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    // Регистрация адреса (куда отправлять товар)
    const REGISTER_USER_ADDRESS = "INSERT INTO adresses (full_adress, is_personal, user_id) VALUES (?, ?, ?)";
    // Редактировать юзера
    const EDIT_USER = "UPDATE users 
                       SET email = ?, enabled = ?, first_name = ?, last_name = ?, mobile_phone = ?,
                          image_url = ?, password = ?, role = ? 
                       WHERE id = ?";
    // Обновить адрес
    const UPDATE_ADDRESS = "UPDATE adresses 
                            SET full_adress = ?, is_personal = ? 
                            WHERE user_id = ?";
    // Проверка адреса
    const CHECK_ADDRESS_SET = "SELECT id 
                               FROM adresses 
                               WHERE NOT full_adress = '0' 
                                  AND user_id = ?";
    // Информация о пользователе
    const GET_USER_INFO = "SELECT u.id, u.email, u.enabled, u.first_name, u.last_name, u.mobile_phone, u.image_url, 
                              u.password, u.last_login, u.role, a.full_adress, a.is_personal 
                           FROM users AS u 
                           JOIN adresses AS a ON u.id = a.user_id 
                           WHERE a.user_id = ?";
    // Установить последний вход
    const SET_LAST_LOGIN = "UPDATE users 
                            SET last_login = ? 
                            WHERE email = ?";
    // Если пользователь первый
    const IS_FIRST_USER = "SELECT id FROM users";
    // Роль
    const ROLE = "SELECT role 
                  FROM users 
                  WHERE email = ? 
                     AND password = ?";
    // Сбросить пароль
    const RESET_PASS = "UPDATE users 
                        SET password = ? 
                        WHERE email = ?";
    // Получить всех пользователей, админ
    const GET_ALL_USERS_ADMIN = "SELECT * 
                                 FROM users";
    // Получить подробности о пользователе, админ
    const GET_USER_DETAILS_ADMIN = "SELECT u.id, u.email, u.first_name, u.last_name, u.mobile_phone, u.image_url, 
                                       u.last_login, a.full_adress, a.is_personal 
                                    FROM users u JOIN adresses a ON a.user_id = u.id 
                                    WHERE u.id = ?";
    // Получить заказы пользователя, админ
    const GET_USER_ORDERS_ADMIN = "SELECT * 
                                   FROM orders 
                                   WHERE user_id = ?";
    // Забанить/разбанить пользователя
    const BAN_UNBAN_USER = "UPDATE users 
                            SET enabled = ? 
                            WHERE id = ?";
    // Дать/отнять модератора
    const MAKE_UNMAKE_MODERATOR_USER = "UPDATE users 
                                        SET role = ? 
                                        WHERE id = ?";
    // Проверить пользователя на блок
    const CHECK_ENABLED = "SELECT id 
                           FROM users 
                           WHERE id = ? 
                              AND enabled = 1";

    private function __construct() {
        // Получаем соединение
        $this->_pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new UserDao();
        } // if

        return self::$_instance;
    } // getInstance


    /**
     * Проверка правильности входа.
     * @param User $user - пользователь.
     * @return bool|int - возвращает ID юзера.
     */
    function checkLogin(User $user) {
        $statement = $this->_pdo->prepare(self::CHECK_LOGIN);
        $statement->execute(array(
            $user->getEmail(),
            $user->getPassword()));

        if ($statement->rowCount()) {
            $userId = $statement->fetch();
            return (int)$userId["id"];
        } else {
            return false;
        } // if
    } // checkLogin

    /**
     * Проверка включен ли пользователь.
     * @param $id - id юзера.
     * @return bool - если пользователь включен.
     */
    function checkEnabled($id) {
        $statement = $this->_pdo->prepare(self::CHECK_ENABLED);
        $statement->execute(array($id));

        if ($statement->rowCount()) {
            return true;
        } else {
            return false;
        } // if
    } // checkEnabled

    /**
     * Проверка наличия пользователя.
     * @param User $user - пользователь.
     * @return bool - если пользователь существует.
     */
    function checkUserExist(User $user) {
        $statement = $this->_pdo->prepare(self::CHECK_USER_EXIST);
        $statement->execute(array($user->getEmail()));

        // Проверяем, если база возвращает пользователя (1 или 0 столбцов)
        if ($statement->rowCount()) {
            // Пользователь существует
            return true;
        } else {
            return false;
        } // if
    } // checkUserExist

    /**
     * Регистрация пользователя.
     * @param User $user - пользователь.
     * @return string - возвращает зарегистрированный айди пользователя.
     */
    function registerUser(User $user) {
        // Используем try-catch, чтобы вести транзакцию
        try {
            $this->_pdo->beginTransaction();

            $statement = $this->_pdo->prepare(self::REGISTER_USER);
            $statement->execute(array(
                    $user->getEmail(),
                    $user->getEnabled(),
                    $user->getFirstName(),
                    $user->getLastName(),
                    $user->getMobilePhone(),
                    $user->getImageUrl(),
                    $user->getPassword(),
                    $user->getLastLogin(),
                    $user->getRole()
                )
            );

            $lastInsertId = $this->_pdo->lastInsertId();

            $statement = $this->_pdo->prepare(self::REGISTER_USER_ADDRESS);
            $statement->execute(array(
                    $user->getAddress(),
                    $user->getPersonal(),
                    $lastInsertId
                )
            );

            $this->_pdo->commit();

            return $lastInsertId;
        } catch (PDOException $e) {
            $this->_pdo->rollBack();
            $message = date("Y-m-d H:i:s")." ".$_SERVER["SCRIPT_NAME"]." $e\n";
            error_log($message, 3, "errors.log");
            header("location: ../../views/error/error_500.php");
            die();
        } // try-catch
    } // registerUser

    /**
     * Изменение пользователя.
     * @param User $user - юзер с новой информацией.
     */
    function editUser(User $user) {
        // Используем try-catch, чтобы вести транзакцию
        try {
            $this->_pdo->beginTransaction();

            $statement = $this->_pdo->prepare(self::EDIT_USER);
            $statement->execute(array(
                    $user->getEmail(),
                    $user->getEnabled(),
                    $user->getFirstName(),
                    $user->getLastName(),
                    $user->getMobilePhone(),
                    $user->getImageUrl(),
                    $user->getPassword(),
                    $user->getRole(),
                    $user->getId()
                )
            );

            $statement = $this->_pdo->prepare(self::UPDATE_ADDRESS);
            $statement->execute(array(
                    $user->getAddress(),
                    $user->getPersonal(),
                    $user->getId()
                )
            );

            $this->_pdo->commit();
        } catch (PDOException $e) {
            $this->_pdo->rollBack();
            header("location: ../../views/error/error_500.php");
        } // try-catch
    } // editUser

    /**
     * Проверка существующего адреса.
     * @param User $user - пользователь.
     * @return bool - возвращает true или false, если существует.
     */
    function checkAddressSet(User $user) {
        $statement = $this->_pdo->prepare(self::CHECK_ADDRESS_SET);
        $statement->execute(array(
                $user->getId()
            )
        );

        if ($statement->rowCount()) {
            return true;
        } else {
            return false;
        } // if
    } // checkAddressSet

    /**
     * Информация о пользователе.
     * @param User $user - пользователь.
     * @return mixed - возвращает информацию пользователя в виде массива.
     */
    function getUserInfo(User $user) {
        $statement = $this->_pdo->prepare(self::GET_USER_INFO);
        $statement->execute(array(
                $user->getId()
            )
        );

        $userInfo = $statement->fetch();
        return $userInfo;
    } // getUserInfo

    /**
     * Для установки последнего входа.
     * @param User $user - юзер.
     */
    function setLastLogin(User $user) {
        $statement = $this->_pdo->prepare(self::SET_LAST_LOGIN);
        $user->setLastLogin();
        $statement->execute(array(
                $user->getLastLogin(),
                $user->getEmail()
            )
        );
    } // setLastLogin

    /**
     * Возвращает true, если пользователь первый.
     */
    function checkIfUserFirst() {
        $statement = $this->_pdo->prepare(self::IS_FIRST_USER);
        $statement->execute();

        if ($statement->rowCount()) {
            // Существуют пользователи
            return false;
        } else {
            // Первый пользователь
            return true;
        } // if
    } // checkIfUserFirst

    function checkIfLoggedUserIsAdmin(User $user) {
        $statement = $this->_pdo->prepare(self::ROLE);
        $statement->execute(array(
                $user->getEmail(),
                $user->getPassword()
            )
        );

        $userRole = $statement->fetch();
        return (int)$userRole["role"];
    } // checkIfLoggedUserIsAdmin

    function resetPassword(User $user) {
        $statement = $this->_pdo->prepare(self::RESET_PASS);
        $statement->execute(array(
                $user->getPassword(),
                $user->getEmail()
            )
        );
    } // resetPassword

    function getAllUsersAdmin() {
        $statement = $this->_pdo->prepare(self::GET_ALL_USERS_ADMIN);
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    } // getAllUsersAdmin

    function getUserDetailsAdmin($userId) {
        $statement = $this->_pdo->prepare(self::GET_USER_DETAILS_ADMIN);
        $statement->execute(array($userId));
        $user = $statement->fetch();

        return $user;
    } // getUserDetailsAdmin

    function getUserOrdersAdmin($userId) {
        $statement = $this->_pdo->prepare(self::GET_USER_ORDERS_ADMIN);
        $statement->execute(array($userId));
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $orders;
    } // getUserOrdersAdmin

    function banUnbanUser($userId, $newStatus) {
        $statement = $this->_pdo->prepare(self::BAN_UNBAN_USER);
        $statement->execute(array($newStatus, $userId));

        return true;
    } // banUnbanUser

    function makeUnmakeModUser($userId, $newRole) {
        $statement = $this->_pdo->prepare(self::MAKE_UNMAKE_MODERATOR_USER);
        $statement->execute(array($newRole, $userId));

        return true;
    } // makeUnmakeModUser
} // UserDao @codingStandardsIgnoreEnd