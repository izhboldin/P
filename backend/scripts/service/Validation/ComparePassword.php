<?php

namespace Palmo\Core\service\Validation;

class ComparePassword implements ValidInterface
{
    public static function  validate($data)
    {
        if ($data[0] !== $data[1]) {
            return 'Пароли не совпадают';
        } else {
            return null;
        }
    }
}
