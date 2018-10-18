<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Выход

// Стартуем сессию, если её нет
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // if

// Стираем куки
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), "", time() - 42000, "/");
} // if

// Убираем роль
unset($_SESSION["role"]);

// Рушим сессию
session_destroy();

// На главную
header("location: ../views/main/index.php");