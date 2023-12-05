<?php

require __DIR__.'/vendor/autoload.php';

require_once "router.php";


route('/', function ($params, $query) {
    require "./pages/home.php";
});

route('/search', function ($params, $query) {
    require "./pages/searchBook.php";
});

route('/favorites', function ($params, $query) {
    require "./pages/favorites.php";
});

route('/regist', function ($params, $query) {
    require "./pages/regist.php";
});

route('/authorization', function ($params, $query) {
    require "./pages/authorization.php";
});
route('/aboutBook/:id', function ($params, $query) {
    require "./pages/aboutBook.php";
});

route('/modalEventsMore', function ($params, $query) {
    require "./components/modalEventsMore.php";
});


$action = $_SERVER['REQUEST_URI'];

dispatch($action);
echo '123';


?>
