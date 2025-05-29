<?php

$search = $_REQUEST['movie-search'] ?? '';

$movies = $database->query(
    query: "SELECT id,title,director,year,genre,synopsis,poster FROM movies WHERE title LIKE :title OR director LIKE :director OR year LIKE :year OR genre LIKE :genre",
    class: Movie::class,
    params: ['title' => "%$search%", 'director' => "%$search%", 'year' => $search, 'genre' => "%$search%"]
)->fetchAll();

view('movies', compact('movies'));
