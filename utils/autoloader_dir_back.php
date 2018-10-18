<?php
// @codingStandardsIgnoreStart
// @codingStandardsIgnoreEnd

// Автозагрузчик моделей на папку ниже

spl_autoload_register(
    function ($className) {
        $className = "..\\..\\..\\".$className;
        include_once str_replace("\\", "/", $className).".php";
    }
);