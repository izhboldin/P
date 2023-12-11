<header class="bg-light p-2">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-4">
                <a v-if="route.name !== 'book'" class="btn btn-outline-primary btn-sm" href="/search">Поиск</a>⠀
                <a v-if="myUser && route.name !== 'favorites'" class="btn btn-outline-primary btn-sm" href="/favorites">Избранные
                </a>
            </div>
            <?php if (!isset($_SESSION['user']))
                echo '
                    <div v-if="!myUser" class="col-4">
                        <a class="btn btn-outline-primary btn-sm" href="/regist">Зарегистрироваться</a>⠀
                        <a class="btn btn-outline-primary btn-sm" href="/authorization">Авторизоваться</a>  
                    </div> '
            ?>
            <?php if (isset($_SESSION['user'])) {
                echo '
                    <div v-else class="col-4">
                        <span class="fw-bold user-name">Привет, ' . $_SESSION['user']['name'] . '</span>
                        <img src=" ' . $_SESSION['user']['avatar'] . '" alt="user-photo" style="width: 32px; height: 32px; border-radius: 50%;" class="me-2">
                        <a class="btn btn-outline-danger btn-sm" href="../scripts/authorization/exit.php">выйти</a>
                        <a class="btn btn-outline-primary btn-sm" href="/personalArea">Личный кабинет</a>

                    </div> ';
            }
            ?>
        </div>
    </div>
</header>