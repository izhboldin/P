<?php
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
                <h2>Личный кабинет</h2>
                <div class="card p-4">
                    <img src="<?php echo $_SESSION['user']['avatar'] ?>" style="width: 300px; height: 300px; border-radius: 50%;" class="mx-auto card-img-top" alt="Аватар пользователя">
                    <div class="card-body">
                        <h5 class="card-title">Имя: <?php echo $_SESSION['user']['name'] ?></h5>
                        <p class="card-text">Email: <?php echo $_SESSION['user']['email'] ?></p>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-outline-dark btn-sm" href="javascript:history.back()">Назад</a>
                            <a class="btn btn-outline-primary btn-sm" href="/changeProfile  ">Изменить профиль</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>