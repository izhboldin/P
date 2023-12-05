<?php
session_start();

require_once __DIR__ . '/../scripts/service/helpers.php';

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

    <div class="background">
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="card book-dody">
                        <div class="card-header">Авторизация</div>
                        <div class="card-body">
                            <form action="../scripts/authorization/login.php" method="post" enctype="multipart/form-data">
                                <div class="form-group pb-1">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control<?php validDangerBorder('email') ?>" value="<?php echo getOldValue('email') ?>">
                                    <small class="text-danger text-center p-0 m-0"><?php validMessage('email') ?></small>
                                </div>
                                <div class="form-group pb-1">
                                    <label for="password">Пароль</label>
                                    <input type="password" name="password" class="form-control<?php validDangerBorder('password') ?>" maxlength="25">
                                    <small class="text-danger text-center p-0 m-0 "><?php validMessage('password') ?></small>
                                </div>
                                <br>
                                <a class="btn btn-secondary" href="/">Главная</a>⠀
                                <button type="submit" class="btn btn-primary">Войти</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.min.js"></script>
</body>

</html>