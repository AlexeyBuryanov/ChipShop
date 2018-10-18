<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Проверка сессии на действительность

// Стартуем сессию
session_start();

// Проверяем есть ли у пользователя сессия (если пользователь зарегистрирован)
if (!isset($_SESSION["loggedUser"])) {
    // Перенаправление на главную
    header("location: ../main/index.php");
    die();
} // if