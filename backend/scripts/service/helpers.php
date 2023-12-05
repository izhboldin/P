<?php

function redirect(string $path)
{
    header("Location: {$path}");
    die();
}

function addValidError(string $fieldName, string $message)
{
    $_SESSION['validation'][$fieldName] = $message;
}

function validDangerBorder(string $keyName)
{
    if (isset($_SESSION['validation'][$keyName])) {
        echo $_SESSION['validation'][$keyName] ? ' border border-danger' : '';
    }
}

function validMessage(string $fieldName)
{
    $value = $_SESSION['validation'][$fieldName] ?? '';
    unset($_SESSION['validation'][$fieldName]);
    echo $value;
}

function addOldValue(string $key, mixed $value)
{
    $_SESSION['oldValue'][$key] = $value;
}

function getOldValue(string $key)
{
    $value = $_SESSION['oldValue'][$key] ?? '';
    unset($_SESSION['oldValue'][$key]);
    return $value;    

}
