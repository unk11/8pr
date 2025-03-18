<?php
session_start();
include("../settings/connect_datebase.php");

$login = $_POST['login'];
$password = $_POST['password'];

// Ищем пользователя с таким логином
$query_user = $mysqli->query("SELECT * FROM users WHERE login='".$login."'");
$id = -1;

// Проверка на существование логина
if($user_read = $query_user->fetch_row()) {
    echo $id;  // Логин занят
} else {
    // Хешируем пароль
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Вставляем нового пользователя
    if ($mysqli->query("INSERT INTO users(login, password, roll) VALUES ('".$login."', '".$hashed_password."', 0)")) {
        $query_user = $mysqli->query("SELECT * FROM users WHERE login='".$login."'");
        $user_new = $query_user->fetch_row();
        $id = $user_new[0];

        if($id != -1) {
            $_SESSION['user'] = $id; // Запоминаем пользователя
        }
        echo $id;
    } else {
        echo 0;  // Ошибка регистрации
    }
}
?>
