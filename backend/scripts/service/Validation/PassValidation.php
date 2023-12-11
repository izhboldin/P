<?php

namespace Palmo\Core\service\Validation;


trait PassValidation
{
    public static function isEmpty($pass)
    {
        return empty(trim($pass));
    }
}