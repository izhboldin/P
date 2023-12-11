<?php
unset($_SESSION['oldValue']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="fon">

        <?php require __DIR__ . "/../blocks/header.php" ?>
        <?php unset($_SESSION['validation']); ?>

        <div class="container-fluid d-flex align-items-center" style="height: 90vh">
            <div class="container my-4 card about-me py-4">
                <p class="text-center">Добро пожаловать на сайт для поиска интересующих вас книг! 📚 <br><br>

                    🔍 Поиск Книг: Используйте наш умный поиск, чтобы найти книги по названиям или интересующим вас
                    темам.
                    Погрузитесь в океан знаний. <br><br>

                    📖 Для вас: Откройте для себя новые миры и найдите те книги, которые точно вас заинтересуют.
                    <br><br>

                    📚 Личная библиотека: Сохраняйте свои любимые книги в личной библиотеке. <br><br>

                    Присоединяйтесь к нам и дайте миру книг вашу историю! 📚
                </p>
            </div>
        </div>
    </div>


    <script src="js/bootstrap.min.js"></script>
</body>

</html>