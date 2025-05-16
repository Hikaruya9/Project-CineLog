<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['user-update'])) {

        if (password_verify($_POST['password'], $user->password)) {

            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $database->query(
                query: "UPDATE users SET username = :username, email = :email, password = :password, avatar = :avatar WHERE id = :id",
                params: [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $pass,
                    'avatar' => $_POST['avatar'],
                    'id' => $_POST['id']
                ]
            );

            // if($_SESSION['id'] == $id){
            //     header('Location: /settings?message=success');
            // } else {
            header('Location: /users?message=success');
            // }
        } else {
            header('Location: /users?message=failed');
        }
    }

} else {

    $id = $_REQUEST['id'] ?? '';

    $user = $database->query(
        query: "SELECT id,username,email,avatar FROM user WHERE id = :id",
        class: User::class,
        params: ['id' => $id]
    )->fetch();

    view('settings', 'user');
}