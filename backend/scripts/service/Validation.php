<?php

namespace Palmo\Core\service;

require __DIR__ . '/../../vendor/autoload.php';

use Palmo\Core\service\Validation\ValidateLogin;
use Palmo\Core\service\Validation\ValidateEmail;
use Palmo\Core\service\Validation\ValidateAvatar;
use Palmo\Core\service\Validation\ValidatePassword;
use Palmo\Core\service\Validation\ComparePassword;

class Validation
{
    public static function valid($data, $type)
    {
        switch ($type) {
            case 'login':
                $error = ValidateLogin::validate($data);
                break;
            case 'email':
                $error = ValidateEmail::validate($data);
                break;
            case 'avatar':
                $error = ValidateAvatar::validate($data);
                break;
            case 'password':
                $error = ValidatePassword::validate($data);
                break;
            case 'comparePass':
                $error = ComparePassword::validate($data);
                break;
            default:
                $error = null;
                break;
        }
        return $error;
    }
}