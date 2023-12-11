<?php
session_start();

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/scripts/service/config.php';
require_once "router.php";

$token = isset($_COOKIE['token']) ? $_COOKIE['token'] : null;

if (!isset($_SESSION['user']) && isset($token)) {
    $pdo = getPDO();

    $sql = "SELECT * FROM token WHERE token = :token";
    $params = ['token' => $token];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $userToken = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!empty($userToken)) {
        $user_id = $userToken['user_id'];
        $sql = "SELECT * FROM users WHERE id = :user_id";
        $params = ['user_id' => $user_id];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    $_SESSION['user']['id'] = $user['id'];
    $_SESSION['user']['name'] = $user['name'];
    $_SESSION['user']['email'] = $user['email'];
    $_SESSION['user']['avatar'] = $user['avatar'];

}
    

route('/', function ($params, $query) {
    require "./pages/home.php";
});

route('/search', function ($params, $query) {
    require "./pages/searchBook.php";
});

route('/favorites', function ($params, $query) {
    require "./pages/favorites.php";
});

route('/regist', function ($params, $query) {
    require "./pages/regist.php";
});

route('/authorization', function ($params, $query) {
    require "./pages/authorization.php";
});

route('/aboutBook', function ($params, $query) {
    require "./pages/aboutBook.php";
});

route('/warning', function ($params, $query) {
    require "./pages/warning.php";
});

route('/personalArea', function ($params, $query) {
    require "./pages/personalArea.php";
});

route('/changeProfile', function ($params, $query) {
    require "./pages/changeProfile.php";
});



$action = $_SERVER['REQUEST_URI'];

dispatch($action);
