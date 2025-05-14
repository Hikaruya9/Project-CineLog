<?php

$search = $_REQUEST['movie-search'] ?? '';

$movies = $database->query(
    query: "SELECT id,title,poster FROM movies WHERE title LIKE :title",
    class: Movie::class,
    params: ['title' => "%$search%"]
)->fetchAll();

// view('index');
view('index', compact('movies'));

?>