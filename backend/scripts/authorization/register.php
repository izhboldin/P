<?php

session_start();

require_once __DIR__ . '/../service/helpers.php';
require_once __DIR__ . '/../service/config.php';

$_SESSION['validation'] = [];

$login = $_POST['login'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$secondPassword = $_POST['secondPassword'] ?? null;
$avatar = $_FILES['avatar'] ?? null;

addOldValue('login', $login);
addOldValue('email', $email);

if (empty($login)) {
    addValidError('login', 'Неверное имя');
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    addValidError('email', 'Неверное поле email');
}
if (empty($avatar['size'])) {
    addValidError('avatar', 'Загрузите фотографию');
}
if (empty($password)) {
    addValidError('password', 'Неверное поле password');
}
if (empty($secondPassword)) {
    addValidError('secondPassword', 'Неверное поле secondPassword');
} else if ($password !== $secondPassword) {
    addValidError('password', ' ');
    addValidError('secondPassword', 'Разные пароли');
}
if (!empty($avatar['size'])) {
    if (($avatar['size'] / 1048576) > 1) {
        addValidError('avatar', 'Размер фото не должен превышать один мегабайт');
    }
}

if (!empty($_SESSION['validation'])) {
    redirect('/regist');
}

$avatarPath = null;
if (!empty($avatar['size'])) {
    if (!is_dir('../../assets/avatars')) {
        mkdir('../../assets/avatars');
    }

    $ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);
    $fileName = 'avatar_' . time() . ".{$ext}";

    if (!move_uploaded_file($avatar['tmp_name'], "../../assets/avatars/$fileName")) {
        die('error add avatar');
    }
    $avatarPath = "assets/avatars/$fileName";
}

$pdo = getPDO();

// echo $pdo . "<bd>";

$query = "INSERT INTO users (name, email, avatar, password) VALUE (:name, :email, :avatar, :password)";
$params = [
    'name' => $login,
    'email' => $email,
    'avatar' => $avatarPath,
    'password' => password_hash($password, PASSWORD_DEFAULT)
];
$stmt = $pdo->prepare($query);

try {
    $stmt->execute($params);
} catch (\Exception $e) {
    die('Ошибка данніх' . $e->getMessage());
}

$_SESSION['user']['name'] = $login;
$_SESSION['user']['email'] = $email;
$_SESSION['user']['avatar'] = $avatarPath;

redirect('/');

