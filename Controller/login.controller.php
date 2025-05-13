<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $database->query(
        query: "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)",
        params: [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ]
    );
    
    header('Location: /index');
}
