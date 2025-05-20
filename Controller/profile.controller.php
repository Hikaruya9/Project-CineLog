<?php

$id = $_REQUEST['user-id'] ?? '';

$user = $database->query(
    query: "SELECT id,username,email,avatar FROM users WHERE id = :id",
    class: User::class,
    params: ['id' => $id]
)->fetch();

view('profile', compact('user'));

?>