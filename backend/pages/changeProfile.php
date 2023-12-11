<?php
require_once __DIR__ . '/../scripts/service/helpers.php';

if (!isset($_SESSION['user'])) {
    redirect('/warning');
}
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
        <div class="container mt-5 ">
            <div class="row col-md-6 mx-auto ">
                <h2>Редактирование профиля</h2>
                <div class="card p-4">

                    <form action="../scripts/authorization/update_profile.php" method="post" class="mb-3">
                        <div class="form-group">
                            <label for="newName">Новое имя:</label>
                            <input type="text" class="form-control" name="newName" placeholder="Введите новое имя">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Изменить имя</button>
                    </form>
                    <form action="../scripts/authorization/update_profile.php" method="post" class="mb-3" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="newAvatar">Новый аватар (URL):</label>
                            <input type="file" class="form-control" name="newAvatar" placeholder="Введите URL нового аватара">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Изменить аватар</button>
                    </form>
<?php if(isset($_SESSION['validation']['error'])){

    echo  '<div class="alert alert-danger p-2" role="alert">
            <p class="m-0">' . $_SESSION['validation']['error']. '</p>
                </div>';
}
?>
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-outline-dark btn-sm" href="/personalArea">Страница с кабинетом</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['validation']['error']);?>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>