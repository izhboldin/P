<?php
session_start();

require_once __DIR__ . '/../service/helpers.php';
require_once __DIR__ . '/../service/config.php';

if (!isset($_SESSION['user'])) {
    redirect('/warning');
}

$pdo = getPDO();
$userId = $_SESSION['user']['id'];
$bookId = $_POST['book_id'];

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM favorites_books WHERE user_id = :user_id AND book_id = :book_id");
    $params = ['user_id' => $userId, 'book_id' => $bookId];
    $stmt->execute($params);
    $isFavorit = ($stmt->fetchColumn()) > 0;

    if ($isFavorit) {
        $removeFavorit = $pdo->prepare("DELETE FROM favorites_books WHERE user_id = :user_id AND book_id = :book_id");
        $params = ['user_id' => $userId, 'book_id' => $bookId];
        $removeFavorit->execute($params);
    } else {
        $query = "INSERT INTO favorites_books (user_id, book_id) VALUE (:user_id, :book_id)";
        $params = ['user_id' => $userId, 'book_id' => $bookId,];
        $addFavorit = $pdo->prepare($query);
        $addFavorit->execute($params);
    }
} catch (\Exception $e) {
    die('Ошибка работы с БД' . $e->getMessage());
}

redirect(rtrim($_SERVER['HTTP_REFERER'], '/'));


// добавлять в  лайки
// убирать из лайков
// узнавать общее число лайков