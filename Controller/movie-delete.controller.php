<?php

if (isset($_REQUEST['movie-id'])) {

    $id = $_REQUEST['movie-id'];

    $movie = $database->query(
        query: "SELECT title,poster FROM movies WHERE id = :id",
        class: Movie::class,
        params: ["id" => $id]
    )->fetch();

    if ($movie->poster !== ('uploads/posters/poster_default.jpg')) {
        @unlink($movie->poster);
    }

    $database->query(
        query: "DELETE FROM movies WHERE id = :id",
        params: ['id' => $id]
    );

    header('Location: /movies?message=success');
    exit();
}