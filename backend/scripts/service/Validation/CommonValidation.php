<?php

namespace Palmo\Core\service\Validation;


trait CommonValidation
{
    public static function isEmpty($data)
    {
        return empty($data);
    }
    public static function searchTeg($data)
    {
        return $data !== strip_tags($data);
    }
    public static function minLength($data, $minLen)
    {
        return strlen(trim($data)) < $minLen;
    }
    public static function maxLength($data, $maxLen)
    {
        return strlen(trim($data)) > $maxLen;
    }
}