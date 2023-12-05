<?php

session_start();

require_once __DIR__ . '/../service/helpers.php';

unset($_SESSION['user']);

redirect('/');
