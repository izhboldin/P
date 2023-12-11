<?php

namespace Palmo\Core\service\Validation;


trait CommonValidation
{
    public static function isEmpty($data)
    {
        return empty($data);
    }
    public static function minLength($data, $minLen)
    {
        return strlen($data) < $minLen;
    }
    public static function maxLength($data, $maxLen)
    {
        return strlen($data) > $maxLen;
    }
}