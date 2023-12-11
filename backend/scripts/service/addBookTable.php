<?php

require_once __DIR__ . '/config.php';


$pdo = getPDO();

$bookQueries = [
    "Экспериментальная_проза",
    "Антиутопия",
    "Фанфик",
    "Киберпанк",
    "Попаданец",
    "Российская_литература",
    "Новелла",
    "Детская_поэзия",
    "Мифический_реализм",
    "Сюрреализм",
];
foreach ($bookQueries as $BOOK) {
    // $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $BOOK . '+subject:&maxResults=40&&orderBy=relevance&key=AIzaSyD_JUf6Lz0dvjlTANO6yoD3318LCHIemdc';

    // $options = [
    //     'http' => [
    //         'method' => 'GET',
    //     ],
    // ];

    // $context = stream_context_create($options);
    // $response = file_get_contents($url, false, $context);
    // $responseArr = json_decode($response, true);

    // $arrId[] = [];

    // $query = "INSERT INTO books (title, about_book, author, price, image, categories, lang) VALUE (:title, :about_book, :author, :price, :image, :categories, :lang)";

    // for ($i = 0; $i < 40; $i++) {
    //     $title = null;
    //     $about_book = null;
    //     $author = null;
    //     $price = null;
    //     $imageUrl = null;
    //     $imagePath = null;
    //     $categories = null;
    //     $lang = null;


    //     if (!isset($responseArr['items'][$i]['volumeInfo']['title']) || !isset($responseArr['items'][$i]['volumeInfo']['description']) || !isset($responseArr['items'][$i]['volumeInfo']['authors']) || !isset($responseArr['items'][$i]['saleInfo']['listPrice']) || !isset($responseArr['items'][$i]['volumeInfo']['categories']) || !isset($responseArr['items'][$i]['volumeInfo']['language'])) {
    //         continue;
    //     }

    //     $title = $responseArr['items'][$i]['volumeInfo']['title'];
    //     $about_book = $responseArr['items'][$i]['volumeInfo']['description'];
    //     $lang = $responseArr['items'][$i]['volumeInfo']['language'];

    //     if (isset($responseArr['items'][$i]['volumeInfo']['authors'][1])) {
    //         $author = (implode(", ", $responseArr['items'][$i]['volumeInfo']['authors']));
    //     } else {
    //         $author = $responseArr['items'][$i]['volumeInfo']['authors'][0];
    //     }

    //     $price = $responseArr['items'][$i]['saleInfo']['listPrice']['amount'];
    //     $imageUrl = $responseArr['items'][$i]['volumeInfo']['imageLinks']['thumbnail'] ?? null;

    //     if (isset($responseArr['items'][$i]['volumeInfo']['categories'][1])) {
    //         $categories = (implode(" & ", $responseArr['items'][$i]['volumeInfo']['categories']));
    //     } else {
    //         $categories = $responseArr['items'][$i]['volumeInfo']['categories'][0];
    //     }

    //     if (empty(trim($title)) || empty(trim($about_book)) || empty(trim($author)) || empty(trim($price)) || empty(trim($categories)) || empty(trim($lang))) {
    //         continue;
    //     }



    //     if (in_array($responseArr['items'][$i]['id'], $arrId, true)) {
    //         continue;
    //     }

    //     echo '<br>********<br>';
    //     echo $BOOK;
    //     echo '<br>';
    //     echo $responseArr['items'][$i]['volumeInfo']['title'];

    //     $arrId[] = $responseArr['items'][$i]['id'];

    //     if (isset($imageUrl)) {
    //         $imageContent = file_get_contents($imageUrl);

    //         if ($imageContent !== false) {
    //             if (!is_dir('../../assets/book_images')) {
    //                 mkdir('../../assets/book_images');
    //             }
    //             // Путь для сохранения изображения на сервере
    //             $fileName = abs((time() - rand())) . '.jpg';
    //             $localPath = "../../assets/book_images/book_img_{$fileName}";

    //             // Сохраняем изображение на сервере
    //             $saveResult = file_put_contents(''.$localPath, $imageContent);

    //             if ($saveResult !== false) {
    //                 $imagePath = "book_images/book_img_{$fileName}";
    //                 echo "<br>".'Изображение успешно сохранено по пути: ' . $localPath;
    //             } else {
    //                 echo 'Ошибка при сохранении изображения.';
    //             }
    //         } else {
    //             echo 'Ошибка при получении содержимого изображения по URL.';
    //         }
    //     }

    //     $params = [
    //         'title' => $title,
    //         'about_book' => $about_book,
    //         'author' => $author,
    //         'price' => $price,
    //         'image' => $imagePath ?? null,
    //         'categories' => $categories,
    //         'lang' => $lang
    //     ];
    //     $stmt = $pdo->prepare($query);

    //     try {
    //         $stmt->execute($params);
    //     } catch (\Exception $e) {
    //         die('Ошибка загрузки данных в таблицу' . $e->getMessage());
    //     }
    // }
}
// var_dump($arrId);




// foreach($responseArr['item'] as $book){
//     echo "<pre>";
//     // var_dump($response);
//     echo "<br>**********************************************************************<br>";
//     var_dump($book);
//     // echo $gettype($response);
//     echo "</pre>";
// }


// echo "<pre>";
// // var_dump($response);
// echo "<br>**********************************************************************<br>";
// var_dump($responseArr['items']);
// // echo $gettype($response);
// echo "</pre>";
