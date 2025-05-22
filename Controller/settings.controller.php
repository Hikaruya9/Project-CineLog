<?php

$user = $database->query(
    query: "SELECT id,username,email,avatar FROM users WHERE id = :id",
    class: User::class,
    params: ['id' => $_SESSION['user-id']]
)->fetch();

view('settings', compact('user'));