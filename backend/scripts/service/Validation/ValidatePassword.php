<?php

namespace Palmo\Core\service\Validation;

require __DIR__ . '/../../../vendor/autoload.php';

use Palmo\Core\service\Validation\CommonValidation;
use Palmo\Core\service\Validation\PassValidation;
use Palmo\Core\service\Validation\ValidInterface;

class ValidatePassword implements ValidInterface
{
    use CommonValidation, PassValidation {
        PassValidation::isEmpty insteadof CommonValidation;
        CommonValidation::isEmpty as commonIsEmpty;
    }
    public static function  validate($data)
    {
        $result = match (true) {
            self::isEmpty($data) => "Пароль не должно быть пустым",
            self::minLength($data, 6) => "Пароль не должно быть меньше 6 символов",
            self::maxLength($data, 30) => "Пароль не должно быть больше 30 символов",
            self::validPass($data) => "Пароль должен содержать хотя бы одну цифру и букву",
            default => null
        };
        return $result;
    }
    private static function validPass($password)
    {
        if (!preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password)) {
            return true;
        }
    }
}