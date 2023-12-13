<?php

namespace Palmo\Core\service\Validation;

require __DIR__ . '/../../../vendor/autoload.php';

use Palmo\Core\service\Validation\CommonValidation;
use Palmo\Core\service\Validation\ValidInterface;

class ValidateEmail implements ValidInterface
{
    public static function  validate($data)
    {
        $result = match (true) {
            CommonValidation::isEmpty(trim($data)) => "Поле 'Email' не должно быть пустым",
            CommonValidation::searchTeg(trim($data)) => "Поле 'Email' не должно иметь HTML теги",
            self::isEmail($data) => "Проверьте поле 'Email'",
            default => null
        };
        return $result;
    }

    private static  function isEmail($email)
    {
        return (filter_var($email, FILTER_VALIDATE_EMAIL)) === false;
    }
}