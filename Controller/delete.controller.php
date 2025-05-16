<?php

if (isset($_REQUEST['user-delete'])) {

    $id = $_REQUEST['user'] ?? '';

    $database->query(
        query: "DELETE FROM users WHERE id = :id",
        params: ['id' => $id]
    );

    header('Location: /?message=success');
}

if (isset($_REQUEST['movie-delete'])) {

    $id = $_REQUEST['movie'] ?? '';

    $database->query(
        query: "DELETE FROM movies WHERE id = :id",
        params: ['id' => $id]
    );

    header('Location: /?message=success');
}
