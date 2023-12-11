<?php
session_start();
require __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../service/helpers.php';
require_once __DIR__ . '/../service/config.php';

use Palmo\Core\service\Validation;

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$rememberMe = $_POST['rememberMe'] ?? null;

addOldValue('email', $email);

$_SESSION['validation']['email'] = Validation::valid($email, 'email');
$_SESSION['validation']['password'] = Validation::valid($password, 'password');

foreach ($_SESSION['validation'] as $sessionEl) {
    if (!empty($sessionEl)) {
        redirect('/authorization');
    }
}

$pdo = getPDO();

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
try {
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(\PDO::FETCH_ASSOC);
} catch (\Exception $e) {
    $_SESSION['validation']['email'] = 'Неверный email';
    redirect('/authorization');
}

if (empty($user['password']) || !password_verify($password, $user['password'])) {
    $_SESSION['validation']['email'] = 'Проверьте поле email';
    $_SESSION['validation']['password'] = 'Проверьте пароль';
    redirect('/authorization');
}

$_SESSION['user']['id'] = $user['id'];
$_SESSION['user']['name'] = $user['name'];
$_SESSION['user']['email'] = $user['email'];
$_SESSION['user']['avatar'] = $user['avatar'];

if ($rememberMe == 'on') {
    $token = bin2hex(random_bytes(32));
    $expiry = time() + 3600 * 24 * 7; // 7 дней
    setcookie('token', $token, $expiry, '/', '', false, true);

    $query = "INSERT INTO token (user_id, token) VALUE (:user_id, :token)";
    $params = [
        'user_id' => $user['id'],
        'token' => $token,
    ];
    $stmt = $pdo->prepare($query);

    try {
        $stmt->execute($params);
    } catch (\Exception $e) {
        die('Ошибка данных токена' . $e->getMessage());
    }
}

unset($_SESSION['validation']);
redirect('/');
