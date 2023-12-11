<?php
session_start();
require __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../service/helpers.php';
require_once __DIR__ . '/../service/config.php';

use Palmo\Core\service\Validation;

$login = $_POST['login'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$secondPassword = $_POST['secondPassword'] ?? null;
$avatar = $_FILES['avatar'] ?? null;
$rememberMe = $_POST['rememberMe'] ?? null;

addOldValue('login', $login);
addOldValue('email', $email);


$_SESSION['validation']['login'] = Validation::valid($login, 'login');
$_SESSION['validation']['email'] = Validation::valid($email, 'email');
$_SESSION['validation']['avatar'] = Validation::valid($avatar, 'avatar');
$_SESSION['validation']['password'] = Validation::valid($password, 'password');
$_SESSION['validation']['secondPassword'] = Validation::valid($secondPassword, 'password');
if (!$_SESSION['validation']['password'] && !$_SESSION['validation']['secondPassword']) {
    $_SESSION['validation']['password'] = Validation::valid([$secondPassword, $password], 'comparePass');
    $_SESSION['validation']['secondPassword'] = Validation::valid([$secondPassword, $password], 'comparePass');
}

foreach ($_SESSION['validation'] as $sessionEl) {
    if (!empty($sessionEl)) {
        redirect('/regist');
    }
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
    $_SESSION['validation']['email'] = 'Такой email уже используеться';
    redirect('/regist');
    // die('Ошибка данніх' . $e->getMessage());
}



if ($rememberMe == 'on') {
    $token = bin2hex(random_bytes(32));
    $expiry = time() + 3600 * 24 * 7; // 7 дней
    setcookie('token', $token, $expiry, '/', '', false, true);

    $sql = "SELECT id FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $params = ['email' => $email];
    $stmt->execute($params);
    $id = $stmt->fetch(\PDO::FETCH_ASSOC);

    $query = "INSERT INTO token (user_id, token) VALUE (:user_id, :token)";
    $params = [
        'user_id' => $id['id'],
        'token' => $token,
    ];
    $stmt = $pdo->prepare($query);

    try {
        $stmt->execute($params);
    } catch (\Exception $e) {
        die('Ошибка данных токена' . $e->getMessage());
    }
    $_SESSION['user']['id'] = $id['id'];
}

$_SESSION['user']['name'] = $login;
$_SESSION['user']['email'] = $email;
$_SESSION['user']['avatar'] = $avatarPath;


unset($_SESSION['validation']);
redirect('/');
