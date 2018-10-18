<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Проверка сессии для админа и модера

// Старт сессии
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Проверяем есть ли у пользователя сессия (если пользователь зарегистрирован)
if (!isset($_SESSION["role"])) {
    // Перенаправление на ошибку
    header("location: ../../../views/error/error_400.php");
    die();
} // if

if (isset($_SESSION["role"]) && $_SESSION["role"] != 3 && $_SESSION["role"] != 2) {
    // Перенаправление на ошибку
    header("location: ../../../views/error/error_400.php");
    die();
} // if