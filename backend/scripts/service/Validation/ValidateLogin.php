<?php

namespace Palmo\Core\service\Validation;

require __DIR__ . '/../../../vendor/autoload.php';

use Palmo\Core\service\Validation\CommonValidation;
use Palmo\Core\service\Validation\ValidInterface;

class ValidateLogin implements ValidInterface
{
    public static function  validate($data)
    {
        $result = match (true) {
            CommonValidation::isEmpty(trim($data)) => "Поле 'Логин' не должно быть пустым",
            CommonValidation::minLength($data, 3) => "Поле 'Логин' не должно быть меньше 3 символов",
            CommonValidation::maxLength($data, 30) => "Поле 'Логин' не должно быть больше 30 символов",
            self::isEmail($data) => "Проверьте поле 'Логин'",
            default => null
        };
        return $result;
    }
    private static  function isEmail($login)
    {
        return (filter_var($login, FILTER_VALIDATE_EMAIL)) == true;
    }
}