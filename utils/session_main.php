<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Проверка сессии на действительность

// Стартуем сессию
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // if

// Проверяем есть ли у пользователя сессия (если пользователь зарегистрирован)
if (isset($_SESSION["loggedUser"])) {
    // Перенаправление на главную
    header("location: ../../views/main/index.php");
    die();
} // if