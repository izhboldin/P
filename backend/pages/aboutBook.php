<?php

require_once __DIR__ . '/../scripts/service/config.php';
require_once __DIR__ . '/../scripts/service/helpers.php';

$id = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die('нет айди');
}

$pdo = getPDO();

$stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
$stmt->execute(['id' => $id]);
$book = $stmt->fetch(\PDO::FETCH_ASSOC);
 if(empty($book)){
    redirect('notFound');
}

// echo "<pre>";
// var_dump($book);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <div class="fon">
    <?php require __DIR__ . "/../blocks/header.php" ?>
    <div v-if="myBookNum" class="container mt-4">
        <div class="row">
            <div class="col-md-12 position-relative">
            <a class="btn them-btn btn-dark position-absolute toggle-button" href="javascript:history.back()">Назад</a>

                <div class="card mb-4 book-dody pt-4">
                    <?php
                    if (isset($book['image'])) {
                        echo '<img style="height: 420px; width: 300px;" src="../assets/' . $book['image'] . '" class="border border-secondary m-4" alt="Book Cover">';
                    } else {
                        echo '<img style="height: 420px; width: 300px;" src="../assets/book.jpg" class="border border-secondary m-4" alt="Book Cover">';
                    }
                    echo '<div class="card-body">
                        <h3 class="card-title">'.$book['title'].'</h3>
                        <p><strong>Кратко о книге: </strong>'.$book['about_book'].'</p>
                        <p><strong>Автор: </strong>'.$book['author'].'</p>
                        <p><strong>Категория: </strong>'.$book['categories'].'</p>
                        <p> <strong>Цена: </strong>'.$book['price'].' грн</p>';
                        ?>
                        <!-- <p><strong>Дата публикации: </strong>'.$book['price'].'</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="../js/bootstrap.min.js"></script>
</body>

</html>