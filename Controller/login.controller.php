<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['sign-up'])) {

        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $database->query(
            query: "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)",
            params: [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $pass
            ]
        );

        header('Location: /?message=success');
    }

    if (isset($_POST['sign-in'])) {

        $user = $database->query(
            query: "SELECT id,username,email,password,avatar FROM users WHERE email = :email",
            class: User::class,
            params: [
                'email' => $_POST['email']
            ]
        )->fetch();

        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
            $_SESSION['avatar'] = $user->avatar;
            header('Location: /profile?user=' . $user->id);
        } else {
            $_SESSION['message'] = "Email ou senha inválidos!";
            header('Location: /sign-in');
        }
    }
}
