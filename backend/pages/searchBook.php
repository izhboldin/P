<?php

require_once __DIR__ . '/../scripts/service/config.php';
require_once __DIR__ . '/../scripts/service/helpers.php';

$page = null;
$search = null;
$categories = null;
$sort = null;
$countBook = 4;
$pagBtn = 5;
$allSort = ['Art', 'Biography', 'Business', 'Comics', 'Computers', 'Education', 'Fiction', 'Language', 'History', 'Literary', 'Medical', 'Music', 'Philosophy', 'Psychology', 'Politica', 'Religion', 'Science', 'Technology'];

$pdo = getPDO();


if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 0;
}
if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = '';
}
if (isset($_GET['categories'])) {
    $categories = $_GET['categories'];
} else {
    $categories = '';
}
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = '';
}

// echo "<pre>";
// var_dump($_GET);
// echo "</pre>";

$sql = "SELECT COUNT(DISTINCT id) AS total FROM books WHERE title LIKE :search";
$params = ['search' => '%' . $search . '%'];
if (isset($categories) && $categories !== '') {
    $sql .= " AND categories LIKE :categories";
    $params['categories'] = '%' . $categories . '%';
}
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$total = $stmt->fetchColumn();
$pageCount = ceil($total / $countBook);

if ($page < 0 || $page > $pageCount || !is_numeric($page) || (!in_array($categories, $allSort) && !empty($categories))) {
    redirect('notFound');
}

$offset = $countBook * $page;

$sql = "SELECT * FROM books WHERE title LIKE :search";
$params = ['search' => '%' . $search . '%'];
if (isset($categories) && $categories !== '') {
    $sql .= " AND categories LIKE :categories";
    $params['categories'] = '%' . $categories . '%';
}
if (isset($sort) && $sort !== '') {
    $sql .= " ORDER BY $sort";
}
$sql .= " LIMIT $countBook OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$books = $stmt->fetchAll(\PDO::FETCH_ASSOC);

$countLike = function ($bookId) use ($pdo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM favorites_books WHERE book_id = :book_id");
    $params = ['book_id' => $bookId];
    $stmt->execute($params);
    return $stmt->fetchColumn();
};

$isLike = function ($userId, $bookId) use ($pdo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM favorites_books WHERE user_id = :user_id AND book_id = :book_id");
    $params = ['user_id' => $userId, 'book_id' => $bookId];
    $stmt->execute($params);
    return ($stmt->fetchColumn()) > 0;
};

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
        <div class="container pt-3">
            <form action="" method="get">

                <div v-if="true" class="mx-auto" style="width: 50%;">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Введите текст" value="<?php echo $search ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Поиск</button>
                        </div>
                    </div>
                </div>

                <div class="row mx-auto " style="width: 50%;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="categories" class=" fw-bold">Категория:</label>
                            <select name="categories" class="form-control">
                                <!-- multiple -->
                                <option value="">Все</option>
                                <option value="Art" <?php echo $categories == 'Art' ? 'selected' : '' ?>>Искусство</option>
                                <option value="Biography" <?php echo $categories == 'Biography' ? 'selected' : '' ?>>Биография</option>
                                <option value="Business" <?php echo $categories == 'Business' ? 'selected' : '' ?>>Бизнес</option>
                                <option value="Comics" <?php echo $categories == 'Comics' ? 'selected' : '' ?>>Комиксы</option>
                                <option value="Computers" <?php echo $categories == 'Computers' ? 'selected' : '' ?>>Компьютеры</option>
                                <option value="Education" <?php echo $categories == 'Education' ? 'selected' : '' ?>>Образование</option>
                                <option value="Fiction" <?php echo $categories == 'Fiction' ? 'selected' : '' ?>>Фантастика</option>
                                <option value="Language" <?php echo $categories == 'Language' ? 'selected' : '' ?>>Язык</option>
                                <option value="History" <?php echo $categories == 'History' ? 'selected' : '' ?>>История</option>
                                <option value="Literary" <?php echo $categories == 'Literary' ? 'selected' : '' ?>>Литература</option>
                                <option value="Medical" <?php echo $categories == 'Medical' ? 'selected' : '' ?>>Медицина</option>
                                <option value="Music" <?php echo $categories == 'Music' ? 'selected' : '' ?>>Музыка</option>
                                <option value="Philosophy" <?php echo $categories == 'Philosophy' ? 'selected' : '' ?>>Философия</option>
                                <option value="Psychology" <?php echo $categories == 'Psychology' ? 'selected' : '' ?>>Психология</option>
                                <option value="Politica" <?php echo $categories == 'Politica' ? 'selected' : '' ?>>Политика</option>
                                <option value="Religion" <?php echo $categories == 'Religion' ? 'selected' : '' ?>>Религия</option>
                                <option value="Science" <?php echo $categories == 'Science' ? 'selected' : '' ?>>Наука</option>
                                <option value="Technology" <?php echo $categories == 'Technology' ? 'selected' : '' ?>>Технологии</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="select2" v-colorWhite class=" fw-bold">Сортировать:</label>
                            <select name="sort" class="form-control">
                                <option value="" default>...</option>
                                <option value="price" <?php echo $sort == 'price' ? 'selected' : '' ?>>Цена по возрастанию</option>
                                <option value="price DESC" <?php echo $sort == 'price DESC' ? 'selected' : '' ?>>Цена по убыванию</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <div class="container card mt-4 book-dody pt-3">
            <div class="d-flex justify-content-between">
                <p>Найдено: <?php echo $total ?></p>
                <p class="col-2 text-center">Страница: <?php echo $page + 1  ?></p>
            </div>
            <?php
            if (isset($books) && !empty($books)) {
                echo '
                <div class="row">';
                for ($i = 0; $i < count($books); $i++) {
                    if (!isset($books[$i])) {
                        break;
                    }
                    echo '
                    <div class="col-md-3">
                        <div class="card mb-1 book-dody-inside">';

                    if (isset($books[$i]['image'])) {
                        echo '<img style="height: 280px;" src="../assets/' . $books[$i]['image'] . '" class="border border-secondary m-5" alt="Book Cover">';
                    } else {
                        echo '<img style="height: 280px;" src="../assets/book.jpg" class="border border-secondary m-5" alt="Book Cover">';
                    }

                    echo  '<div class="card-body">
                                <h5 class="card-title">' . mySubString($books[$i]['title'], 20) . '</h5>
                                <p class="card-text">' . mySubString($books[$i]['author'], 30) . '</p>
                                <p class="card-text">' . $books[$i]['price'] . ' грн</p>
                                <div class="d-flex justify-content-between">
                                    <form method="POST" action="scripts/forLibrary/likeBook.php" class="mr-2">
                                        <input type="hidden" name="book_id" value="' . $books[$i]['id'] . '">
                                        <button type="submit" class="btn btn-">';
                    if (isset($_SESSION['user'])) {
                        echo   $isLike($_SESSION['user']['id'], $books[$i]['id']) ?
                            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="#FF0000">
                                            <path d="M12 21.35l-1.45-1.32C5.4 14.25 2 11.36 2 7.5 2 4.42 4.42 2 7.5 2 9.38 2 11.23 3.36 12 4.73 12.77 3.36 14.62 2 16.5 2 19.58 2 22 4.42 22 7.5c0 3.86-3.4 6.75-8.55 12.54L12 21.35z" />
                                            </svg>' : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="#FF0000" stroke-width="2">
                                            <path d="M12 21.35l-1.45-1.32C5.4 14.25 2 11.36 2 7.5 2 4.42 4.42 2 7.5 2 9.38 2 11.23 3.36 12 4.73 12.77 3.36 14.62 2 16.5 2 19.58 2 22 4.42 22 7.5c0 3.86-3.4 6.75-8.55 12.54L12 21.35z" />
                                            </svg>';
                    } else {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="#FF0000" stroke-width="2">
                                            <path d="M12 21.35l-1.45-1.32C5.4 14.25 2 11.36 2 7.5 2 4.42 4.42 2 7.5 2 9.38 2 11.23 3.36 12 4.73 12.77 3.36 14.62 2 16.5 2 19.58 2 22 4.42 22 7.5c0 3.86-3.4 6.75-8.55 12.54L12 21.35z" />
                                            </svg>';
                    }

                    echo '</button>
                                            <span>' . $countLike($books[$i]['id']) . '</span>
                                    </form>
                                    <a class="btn btn-info" href="/aboutBook?id=' . $books[$i]['id'] . '">Подробнее</a>
                                </div>
                                </div>
                                
                                </div>
                                </div>';
                }
                echo   '</div>';
            } else {
                echo '<p class="p-4 text-center">По такому запросу ничего не найдено</p>';
            }
            ?>
            <div class="d-flex justify-content-center mb-3">
                <?php
                if($page > 2){
                    echo '<a class="btn btn-light border mx-5" href="/search?page=0&search=' . $search . '&categories=' . $categories . '&sort=' . $sort . '">1</a>';
                }
                for ($i = 1; $i <= $pagBtn; $i++) {
                    if (($page + $i - 3) < 0) {
                        $pagBtn++;
                        continue;
                    }

                    if ($pageCount <= ($page + $i - 3)) {
                        break;
                    }
                    if (($page + $i - 3) == $page) {
                        echo '<a class="btn btn-primary border mx-2" href="/search?page=' . $page + $i - 3 . '&search=' . $search . '&categories=' . $categories . '&sort=' . $sort . '">' . $page + $i - 2 . '</a>';
                    } else {
                        echo '<a class="btn btn-light border mx-2" href="/search?page=' . $page + $i - 3 . '&search=' . $search . '&categories=' . $categories . '&sort=' . $sort . '">' . $page + $i - 2 . '</a>';
                    }
                }
                if($page < $pageCount - 3){
                    echo '<a class="btn btn-light border mx-5" href="/search?page='. $pageCount - 1 .'&search=' . $search . '&categories=' . $categories . '&sort=' . $sort . '">'. $pageCount .'</a>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.min.js"></script>
</body>

</html>