<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['sign-in'])) {

        $user = $database->query(
            query: "SELECT id,username,email,avatar FROM users WHERE email = :email AND password = :password",
            class: User::class,
            params: [
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ]
        )->fetch();

        $_SESSION['id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        $_SESSION['avatar'] = $user->avatar;

        // if (password_verify($_POST['password'], $user['password'])) {
        //     $_SESSION['id'] = $user['id'];
        //     $_SESSION['name'] = $user['name'];
        //     $_SESSION['password'] = $user['password'];
        //     header('Location: /profile');
        // } else {
        //     $_SESSION['message'] = "Email ou senha inválidos!";
        //     header('Location: /sign-in');
        // }

        header('Location: /');
        
    }

    if (isset($_POST['sign-up'])) {

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
}
