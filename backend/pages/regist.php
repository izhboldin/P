<?php
session_start();

require_once __DIR__ . '/../scripts/service/helpers.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <div class="background">
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="card book-dody">
                        <div class="card-header">Регистрация</div>
                        <div class="card-body">
                            <form action="../scripts/authorization/register.php" method="post" enctype="multipart/form-data">
                                <div class="form-group pb-1">
                                    <label for="login">Имя пользователя (Логин)</label>
                                    <input 
                                    type="text" 
                                    name="login" 
                                    class="form-control<?php validDangerBorder('login')  ?>"
                                    value="<?php echo getOldValue('login') ?>"
                                    >
                                    <small class="text-danger p-0 m-0"><?php validMessage('login') ?></small>
                                </div>
                                <div class="form-group pb-1">
                                    <label for="email">Email</label>
                                    <input 
                                    type="email" 
                                    name="email" 
                                    class="form-control<?php validDangerBorder('email') ?>"
                                    value="<?php echo getOldValue('email') ?>"
                                    >
                                    <small class="text-danger text-center p-0 m-0"><?php validMessage('email') ?></small>
                                </div>
                                <div class="form-group pb-1">
                                    <label for="avatar">Изображение профиля</label>
                                    <input 
                                    type="file" 
                                    name="avatar" 
                                    class="form-control <?php validDangerBorder('avatar') ?>"
                                    >
                                    <small class="text-danger text-center p-0 m-0"><?php validMessage('avatar') ?></small>
                                </div>
                                <div class="form-group pb-1">
                                    <label for="password">Пароль</label>
                                    <input 
                                    type="password" 
                                    name="password" 
                                    class="form-control <?php validDangerBorder('password') ?>" 
                                    maxlength="255"
                                    >
                                    <small class="text-danger text-center p-0 m-0"><?php validMessage('password') ?></small>
                                </div>
                                <div class="form-group pb-1">
                                    <label for="secondPassword">Повторите пароль</label>
                                    <input 
                                    type="password" 
                                    name="secondPassword" 
                                    class="form-control <?php validDangerBorder('secondPassword') ?>" 
                                    maxlength="255"
                                    >
                                    <small class="text-danger text-center p-0 m-0"><?php validMessage('secondPassword') ?></small>
                                </div>
                                <br>
                                <a class="btn btn-secondary" href="/">Главная</a>⠀
                                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>⠀
                                <!-- <button type="submit" class="btn btn-primary">войти с помощью <img style="width: 22px;" src="../assets/Google-logo.png" alt=""></button> -->
                                <br>

                                если у вас уже есть аккаунт, <a href="/authorization">войти </a>
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