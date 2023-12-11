<?php



require_once __DIR__ . '/../scripts/service/config.php';
require_once __DIR__ . '/../scripts/service/helpers.php';

if (!isset($_SESSION['user'])) {
  redirect('/warning');
}

$pdo = getPDO();

if(!isset($_SESSION['user']['id'])){
  $email = $_SESSION['user']['email'];
  $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
  $params = ['email' => $email];
  $stmt->execute($params);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $_SESSION['user']['id'] = $result['id'];
}

$userId = $_SESSION['user']['id'];
$page = null;
$books;
$sort = null;
$countBook = 4;

if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 0;
}

$stmt = $pdo->prepare("SELECT COUNT(*) FROM favorites_books WHERE user_id = :user_id");
$params = ['user_id' => $userId];
$stmt->execute($params);
$countFavorite = $stmt->fetchColumn();
$pageCount = ceil($countFavorite / $countBook);

if ($page < 0 || $page > $pageCount || !is_numeric($page)) {
  redirect('notFound');
}

$stmt = $pdo->prepare("SELECT book_id as id FROM favorites_books WHERE user_id = :user_id");
$params = ['user_id' => $userId];
$stmt->execute($params);
$booksId = $stmt->fetchAll(\PDO::FETCH_ASSOC);

// var_dump($booksId);
$offset = $countBook * $page;

for ($i = $offset; $i < ($countBook * ($page + 1)); $i++) {
  if (empty($booksId[$i]['id'])) {
    break;
  }
  $id = $booksId[$i]['id'];
  $sql = "SELECT * FROM books WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $params = ['id' => $id];
  $stmt->execute($params);
  $books[] = $stmt->fetch(\PDO::FETCH_ASSOC);
}
// echo "<pre>";
// var_dump($books);
// echo "</pre>";

$countLike = function ($bookId) use ($pdo) {
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM favorites_books WHERE book_id = :book_id");
  $params = ['book_id' => $bookId];
  $stmt->execute($params);
  return $stmt->fetchColumn();
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
    <!-- <div class="container mt-4">
      <div class="row">
        <div v-for="book in group" :key="book.id" class="col-md-3">
          <div class="card mb-4 book-dody-inside">
            <img v-if="book.volumeInfo.imageLinks" style="height: 280px;" :src="book.volumeInfo.imageLinks.thumbnail" class="border border-secondary m-5" alt="Book Cover">
            <img v-if="!book.volumeInfo.imageLinks" style="height: 280px;" src="../assets/book.jpg" class="border border-secondary m-5" alt="Book Cover">
            <div class="card-body">
              <h5 class="card-title">{{ truncateString(book.volumeInfo.title) }}</h5>
              <p class="card-text">{{ book.volumeInfo.authors ? truncateString(book.volumeInfo.authors[0]) : 'Неизвестный автор' }}</p>
              <p class="card-text">{{ book.saleInfo.listPrice ? (book.saleInfo.listPrice.amount + ' ' +
                book.saleInfo.listPrice.currencyCode) : 'НЕ ПРОДАЕТСЯ' }}.</p>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="setCurrentId(book.id)">Удалить</button>⠀
              <button @click="detailedInfo(book.id)" class="btn btn-info">Подробнее</button>
            </div>
          </div>
        </div>
      </div>
    </div> -->

    <div class="container card mt-4 book-dody pt-3">
      <p>Найдено: <?php echo $countFavorite ?></p>
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
                                        <button type="submit" class="btn btn-">
         
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="#FF0000" stroke-width="2">
    <line x1="18" y1="6" x2="6" y2="18"></line>
    <line x1="6" y1="6" x2="18" y2="18"></line>
</svg>
                                            </button>
                                    </form>
                                    <a class="btn btn-info" href="/aboutBook?id=' . $books[$i]['id'] . '">Подробнее</a>
                                </div>
                                </div>
                                
                                </div>
                                </div>';
        }
        echo   '</div>';
      } else {
        echo '<p class="p-4 text-center">У вас нет любимых книг</p>';
      }
      ?>
      <div class="row justify-content-evenly mb-3">
        <a class="col-2 btn btn-warning <?php echo $page == 0 ? 'disabled' : '' ?>" href="/favorites?page=<?php echo $page - 1 ?>">Назад</a>
        <p class="col-2 text-center">Страница: <?php echo $page + 1  ?></p>
        <a class="col-2 btn btn-warning <?php echo $pageCount - 1  <= $page ? 'disabled' : '' ?>" href="/favorites?page=<?php echo $page + 1 ?>">Далее</a>
      </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-content modal-dialog book-dody">
        <div class="modal-header">
          <h2 class="modal-title fs-5" id="exampleModalLabel">Уверены что хотите удалить книгу из избранного?</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="removeBook(currentId)">Удалить</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Выход</button>
        </div>
      </div>
    </div>

  </div>

  <script src="../js/bootstrap.min.js"></script>
</body>

</html>