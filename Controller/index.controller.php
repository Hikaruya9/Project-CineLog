<?php

$search = $_REQUEST['movie-search'] ?? '';

$movies = $database->query(
    query: "SELECT id,title,poster FROM movies WHERE title LIKE :search OR director LIKE :search",
    class: Movie::class,
    params: ['search' => "%$search%"]
)->fetchAll();

view('index', compact('movies'));

?>