<?php
// @codingStandardsIgnoreStart

/**
 * Для обрезки по центру изображения с использованием соотношения сторон.
 * @param $imagePath - путь изображения с расширением
 * @param $cropPX - пиксели для ширины и высоты
 */
function cropImage($imagePath, $cropPX) {
    // Получение размеров изображения
    list($width, $height) = getimagesize($imagePath);

    // Создание изображения для любого формата
    if (!function_exists("imageCreateFromAny")) {
        function imageCreateFromAny($filepath) {
            $im = null;

            $type = exif_imagetype($filepath); // вместо exif_imagetype() можно использовать getImageSize()
            $allowedTypes = array(
                1,  // [] gif
                2,  // [] jpg
                3,  // [] png
                6   // [] bmp
            );
            if (!in_array($type, $allowedTypes)) {
                return false;
            } // if
            switch ($type) {
                case 1:
                    $im = imageCreateFromGif($filepath);
                    break;
                case 2:
                    $im = imageCreateFromJpeg($filepath);
                    break;
                case 3:
                    $im = imageCreateFromPng($filepath);
                    break;
            } // switch
            return $im;
        } // imageCreateFromAny
    } // if @codingStandardsIgnoreEnd

    // Сохранение изображения в память (для работы с библиотекой GD)
    $myImage = imageCreateFromAny($imagePath);

    // Вычисление части изображения для эскиза
    if ($width > $height) {
        $y = 0;
        $x = ($width - $height) / 2;
        $smallestSide = $height;
    } else {
        $x = 0;
        $y = ($height - $width) / 2;
        $smallestSide = $width;
    } // if

    // Копирование части в миниатюру
    $thumbSize = $cropPX;
    $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
    imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

    // Конечный результат
    imagejpeg($thumb, $imagePath);
} // cropImage