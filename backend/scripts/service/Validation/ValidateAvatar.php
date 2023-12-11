<?php

namespace Palmo\Core\service\Validation;

require __DIR__ . '/../../../vendor/autoload.php';

use Palmo\Core\service\Validation\CommonValidation;
use Palmo\Core\service\Validation\ValidInterface;

class ValidateAvatar implements ValidInterface
{
    public static function  validate($data)
    {
        $result = match (true) {
            CommonValidation::isEmpty($data['size']) => "Загрузите фотографию",
            self::typeAvater($data) => "Выберите фото с таким типом: png, jpg, jpeg",
            self::bigSize($data['size']) => "Размер фото не должен превышать один мегабайт",
            default => null
        };
        return $result;
    }
    private static  function bigSize($size)
    {
        return (($size / 1048576) > 1) === true;
    }
    private static function typeAvater($avatar)
    {
        $ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);
        if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {
            return false;
        } else {
            return true;
        }
    }
}