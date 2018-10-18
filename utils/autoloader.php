<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Автозагрузчик моделей

spl_autoload_register(
    function ($className) {
        $className = "..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);