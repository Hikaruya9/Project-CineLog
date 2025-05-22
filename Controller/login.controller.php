<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['sign-up'])) {

        //regras de negócio para cada campo e os valores recebidos do cadastro
        $authUser = AuthUser::validate([
            'username' => ['required'],
            'email' => ['required', 'email', 'unique'],
            'password' => ['required',  'strong', 'min:8', 'max:64']
        ], $_POST);

        // Caso falhe em alguma das validações
        if ($authUser->notPassed()) {
            $_SESSION['auth'] = $auth->auths;
            header('Location: /login');
            exit();
        }

        $database->query(
            query: 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)',
            params: [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['pass']
            ]
        );

        header('Location: /login?mensagem=Registrado com sucesso!');
        exit();

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
            $_SESSION['user-id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
            header('Location: /profile');
        } else {
            $_SESSION['message'] = "Email ou senha inválidos!";
            header('Location: /sign-in');
        }
    }
}
