<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/config.php';


use Faker\Factory;

$faker = Factory::create();
$pdo = getPDO();

for ($i = 0; $i < 1000; $i++) {
    $name = $faker->name(10);
    $email = $faker->email();
    $password = $faker->password(15);

    //    $sql = "INSERT INTO songs (song_name, artist, duration) VALUES (?, ?, ?)";
    $sql = "INSERT INTO users (name, email, avatar, password) VALUE (:name, :email, :avatar, :password)";
    $params = [
        'name' => $name,
        'email' => $email,
        'avatar' => 'assets/avatars/avatar_1701976827.jpg',
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}
echo 'все';
