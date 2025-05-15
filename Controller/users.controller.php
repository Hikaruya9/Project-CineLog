<?php

$search = $_REQUEST['user-search'] ?? '';

$users = $database->query(
    query: "SELECT id,username,email,avatar FROM users WHERE id = :id OR username LIKE :username OR email LIKE :email",
    class: User::class,
    params: ['id' => $search, 'username' => "%$search%", 'email' => "%$search%"]
)->fetchAll();

view('users', compact('users'));

?>