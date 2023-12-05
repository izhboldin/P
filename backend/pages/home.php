<?php
session_start();

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
        <button class="btn them-btn toggle-button" @click="toggleTheme()">Сменить тему</button>

        <header class="header p-2">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-4">
                        <a v-if="route.name !== 'book'" class="btn btn-outline-primary btn-sm" href="/search">Поиск</a>⠀
                        <a v-if="myUser && route.name !== 'favorites'" class="btn btn-outline-primary btn-sm" href="/favorites">Избранные
                            <span v-if="myFavorCoun != 0" class="badge text-bg-danger">{{ myFavorCoun }}</span>
                        </a>
                    </div>
                    <?php  if(!isset($_SESSION['user']))
                    echo '
                    <div v-if="!myUser" class="col-4">
                        <a class="btn btn-outline-primary btn-sm" href="/regist">Зарегистрироваться</a>⠀
                        <a class="btn btn-outline-primary btn-sm" href="/authorization">Авторизоваться</a>
                    </div> '
                        ?>
                    <?php  if(isset($_SESSION['user']))
                    {
                    echo '
                    <div v-else class="col-4">
                        <span class="fw-bold user-name">Привет, ' .$_SESSION['user']['name'] . '</span>
                        <img src=" '.$_SESSION['user']['avatar'] .'" alt="user-photo" style="width: 32px; border-radius: 50%;" class="me-2">
                        <a class="btn btn-outline-danger btn-sm" href="../scripts/authorization/exit.php">выйти</a>
                    </div> ';
                    }
                        ?>
                </div>
            </div>
        </header>

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