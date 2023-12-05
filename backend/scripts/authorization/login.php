<?php

session_start();

require_once __DIR__ . '/../service/helpers.php';
require_once __DIR__ . '/../service/config.php';


$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

addOldValue('email', $email);

if (empty($password)) {
    addValidError('password', 'Неверное поле password');
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    addValidError('email', 'Неверное поле email');
}

if (!empty($_SESSION['validation'])) {
    redirect('../../pages/authorization.php');
}


$pdo = getPDO();

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(\PDO::FETCH_ASSOC);

$hash = $user['password'];

if (!password_verify($password, $hash)) {
    redirect('/authorization');
}

$_SESSION['user']['id'] = $user['id'];
$_SESSION['user']['name'] = $user['name'];
$_SESSION['user']['email'] = $user['email'];
$_SESSION['user']['avatar'] = $user['avatar'];

redirect('/');