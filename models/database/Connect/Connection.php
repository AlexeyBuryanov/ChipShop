<?php // @codingStandardsIgnoreStart

namespace models\database\Connect;

use \PDO;

/**
 * Соединение с базой.
 * 
 * @author     Алексей Бурьянов
 * @copyright  (c) 2018, Alexey Bur'yanov
 */
class Connection {

    private static $_instance;
    private $_pdo;

    /** 
     * Соединение между сервером и базой данных.
     * */
    private function __construct() {
        $this->_pdo = new PDO("mysql:host=".Database::DB_IP.":".Database::DB_PORT.";dbname=".
                            Database::DB_NAME, Database::DB_USER, Database::DB_PASS);

        // Устанавливаем режим ловли ошибок
        $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Настраиваем базу для работы с UTF-8
        $this->_pdo->query("USE ".Database::DB_NAME);
        $this->_pdo->query("SET NAMES 'utf8';");
        $this->_pdo->query("SET CHARACTER SET 'utf8';");
        $this->_pdo->query("SET SESSION collation_connection = 'utf8_general_ci';");
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new Connection();
        } // if
        return self::$_instance;
    } // getInstance

    public function getConnection() {
        return $this->_pdo;
    } // getConnection
} // Connection @codingStandardsIgnoreEnd