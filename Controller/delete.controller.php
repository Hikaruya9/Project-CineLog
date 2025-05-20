<?php

if (isset($_REQUEST['user-id'])) {

    $id = $_REQUEST['user-id'];

    $database->query(
        query: "DELETE FROM users WHERE id = :id",
        params: ['id' => $id]
    );

    header('Location: /users?message=success');
}

if (isset($_REQUEST['movie-delete'])) {

    $id = $_REQUEST['movie'] ?? '';

    $database->query(
        query: "DELETE FROM movies WHERE id = :id",
        params: ['id' => $id]
    );

    header('Location: /users?message=success');
}
