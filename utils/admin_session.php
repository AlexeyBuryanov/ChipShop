<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Проверка сессии для админа

// Старт сессии
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // if

// Проверяем есть ли у пользователя сессия (если пользователь зарегистрирован)
if (!isset($_SESSION["role"])) {
    // Перенаправление на ошибку
    header("location: ../../../views/error/error_400.php");
    die();
} // if

if (isset($_SESSION["role"]) && $_SESSION["role"] != 3) {
    // Перенаправление на ошибку
    header("location: ../../../views/error/error_400.php");
    die();
} // if