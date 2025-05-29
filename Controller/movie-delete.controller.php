<?php

if (isset($_REQUEST['movie-delete'])) {

    $id = $_REQUEST['movie-id'];

    $movie = $database->query(
        query: "SELECT poster FROM movies WHERE id = :id",
        params: ["id" => $id]
    )->fetch();

    if ($movie->poster !== ('uploads/posters/poster_default.jpg')) {
        @unlink($movie->poster);
    }

    $database->query(
        query: "DELETE FROM movies WHERE id = :id",
        params: ['id' => $id]
    );

    header('Location: /?message=success');
    exit();
}