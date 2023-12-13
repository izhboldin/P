<?php
session_start();
require __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../service/helpers.php';
require_once __DIR__ . '/../service/config.php';

use Palmo\Core\service\Validation;
$pdo = getPDO();

if (!isset($_SESSION['user']['id'])) {
    $email = $_SESSION['user']['email'];
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $params = ['email' => $email];
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user']['id'] = $result['id'];
}

$name = $_POST['newName'] ?? null;
$avatar = $_FILES['newAvatar'] ?? null;

if (empty($name) && empty($avatar['size'])) {
    // redirect('/personalArea');
    $_SESSION['validation']['error'] = 'поля не должныть быть пустыми';
    redirect(rtrim($_SERVER['HTTP_REFERER'], '/'));
}
if (!empty($name)) {
    $_SESSION['validation']['error'] = Validation::valid($name, 'login');

    if (!empty($_SESSION['validation']['error'])) {
        redirect('/changeProfile');
    }
    try {
        $updateName = $pdo->prepare("UPDATE users SET name = :name WHERE id = :id");
        $params = ['name' => $name, 'id' => $_SESSION['user']['id']];
        $updateName->execute($params);
    } catch (\Throwable $e) {
        die( $e->getMessage());
    }
    $_SESSION['user']['name'] = $name;
} else if (!empty($avatar['size'])) {
    $_SESSION['validation']['error'] = Validation::valid($avatar, 'avatar');
    
    if (!empty($_SESSION['validation']['error'])) {
        redirect('/changeProfile');
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

    try {
        $updateName = $pdo->prepare("UPDATE users SET avatar = :avatar WHERE id = :id");
        $params = ['avatar' => $avatarPath, 'id' => $_SESSION['user']['id']];
        $updateName->execute($params);
    } catch (\Throwable $e) {
        die( $e->getMessage());
    }
    unlink('../../' . $_SESSION['user']['avatar']);
    $_SESSION['user']['avatar'] = $avatarPath;
}

redirect('/personalArea');

