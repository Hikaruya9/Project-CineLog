<?php

if (isset($_REQUEST['user-id'])) {

    $id = $_REQUEST['user-id'];

    $user = $database->query(
        query: "SELECT * FROM users WHERE id = :id",
        class: User::class,
        params: ["id" => $id]
    )->fetch();

    if ($user->avatar !== 'uploads/avatars/avatar_default.jpg') {
        @unlink($user->avatar);
    }

    $database->query(
        query: "DELETE FROM users WHERE id = :id",
        params: ['id' => $id]
    );

    header('Location: /?message=success');
    exit();
}
