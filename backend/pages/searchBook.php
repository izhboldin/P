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
        <div class="container pt-3">
            <div v-if="true" class="mx-auto" style="width: 50%;">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Введите текст">
                    <div class="input-group-append">
                        <button class="btn btn-primary" @click="searchBooks()" type="button">Поиск</button>
                    </div>
                </div>
            </div>

            <div v-if="true" class="row mx-auto " style="width: 50%;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="select1" v-colorWhite class=" fw-bold">Категория:</label>
                        <select class="form-control" id="select1">
                            <option value="">Все</option>
                            <option value="art">Искусство</option>
                            <option value="biography">Биография</option>
                            <option value="computers">Компьютеры</option>
                            <option value="history">История</option>
                            <option value="medical">Медицинский</option>
                            <option value="poetry">Поэзия</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="select2" v-colorWhite class=" fw-bold">Сортировать:</label>
                        <select class="form-control" id="select2">
                            <option value="relevance" default>Релевантность поисковым запросам</option>
                            <option value="newest">Самый последний из опубликованных</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="container card mt-4 book-dody pt-3">
            <p class="p-5" v-if="myBooks == ''">По такому запросу ничего не найдено</p>
            <div v-if="myBooks !== ''" class="row">
                <div v-for="book in myBooks" :key="book.id" class="col-md-3">
                    <div class="card mb-4 book-dody-inside">
                        <img v-if="book.volumeInfo.imageLinks" style="height: 280px;" :src="book.volumeInfo.imageLinks.thumbnail" class="border border-secondary m-5" alt="Book Cover">
                        <img v-else style="height: 280px;" src="../assets/book.jpg" class="border border-secondary m-5" alt="Book Cover">
                        <div class="card-body">
                            <h5 class="card-title">{{ truncateString(book.volumeInfo.title) }}</h5>
                            <p class="card-text">{{ book.volumeInfo.authors ? truncateString(book.volumeInfo.authors[0]) : 'Неизвестный автор' }}</p>
                            <p class="card-text">{{ book.saleInfo.listPrice ? (book.saleInfo.listPrice.amount + '' + book.saleInfo.listPrice.currencyCode) : 'НЕ ПРОДАЕТСЯ' }}.</p>
                            <button @click="addFavoriteBook(book)" class="btn btn-success">В избранные</button>⠀
                            <button @click="detailedInfo(book.id)" class="btn btn-info">Подробнее</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.min.js"></script>
</body>

</html>