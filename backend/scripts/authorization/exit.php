<?php

session_start();

require_once __DIR__ . '/../service/helpers.php';
setcookie('token', '', time() - 3600, '/');

unset($_SESSION['user']);

redirect('/');
