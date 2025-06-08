<?php

if (isset($_REQUEST['user-id']) || isset($_SESSION['user-id'])) {

    $id = $_REQUEST['user-id'] ?? $_SESSION['user-id'];

    $user = $database->query(
        query: "SELECT * FROM users WHERE id = :id",
        class: User::class,
        params: ["id" => $id]
    )->fetch();

    if ($user->avatar !== 'uploads/avatars/avatar_default.jpg') {
        @unlink($user->avatar);
    }

    $database->query(
    query: "DELETE FROM reviews WHERE user_id = :id",
    params: ['id' => $id]
    );

    $database->query(
        query: "DELETE FROM users WHERE id = :id",
        params: ['id' => $id]
    );

    $route = "/users";

    if($_SESSION['user-id'] == $id){
        session_destroy();
        $route = "/";
    }

    header('Location: ' . $route);
    exit();
}
