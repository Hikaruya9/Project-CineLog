<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require 'validator.php';
    $validator = new Validator();

    if (isset($_POST['sign-up'])) {

        $data = $_POST;

        $usersEmails = $database->query(
            query: "SELECT email FROM users",
            class: User::class
        )->fetchAll();

        $data['users_emails'] = $usersEmails;

        //regras de negócio para cada campo e os valores recebidos do cadastro
        $rules = [
            'username' => ['required'],
            'email' => ['required', 'email', 'unique:users_emails,email'],
            'password' => ['required', 'strong', 'min:8', 'max:64']
        ];

        $validationResult = $validator->validate($rules, $data);

        if ($validationResult->hasErrors()) {
            $_SESSION['auth'] = $validationResult->getErrors();
            header('Location: /sign-up');
            exit();
        }

        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $database->query(
            query: "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)",
            params: [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $pass
            ]
        );

        $_SESSION['auth'] = "Conta criada com sucesso!";
        header('Location: /sign-in');
        exit();
    }

    if (isset($_POST['sign-in'])) {

        $user = $database->query(
            query: "SELECT id,username,email,password,avatar,permission_level FROM users WHERE email = :email",
            class: User::class,
            params: [
                'email' => $_POST['email']
            ]
        )->fetch();

        if (!isset($user->id)) {
            $_SESSION['auth'] = "Email ou senha inválidos!";
            header('Location: /sign-in');
            exit();
        }

        $rules = [
            'password' => ['required', "matches_hash:{$user->password}"],
        ];

        $validationResult = $validator->validate($rules, $_POST);

        if ($validationResult->hasErrors()) {
            $_SESSION['auth'] = "Email ou senha inválidos!";
            header('Location: /sign-in');
            exit();
        }

        $_SESSION['user-id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        $_SESSION['permission_level'] = $user->permission_level;

        header('Location: /profile');
    }
} else {
    header('Location: /sign-in');
}