<?php

const DB_HOST = 'db';
const DB_NAME = 'project_php';
const DB_USERNAME = 'root';
const DB_PASS = 'php_course';

function getPDO(): PDO
{
    try {
        return new \PDO('mysql:host=' . DB_HOST . ';charset=utf8;dbname=' . DB_NAME . '', DB_USERNAME, DB_PASS);
    } catch (\PDOException $e) {
        echo 123;
        die('Помилка підключення' . $e->getMessage());
    }
}


