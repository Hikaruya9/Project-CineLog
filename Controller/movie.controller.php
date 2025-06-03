<?php

$id = $_REQUEST['movie-id'] ?? '';

if (!is_numeric($id) || $id <= 0) {
    header('Location: /');
    exit;
}

$movie = $database->query(
    query: "SELECT id,title,director,year,genre,synopsis,poster,(SELECT avg(rate) FROM reviews WHERE movie_id = :id) rating FROM movies WHERE id = :id",
    class: Movie::class,
    params: ['id' => $id]
)->fetch();

if(!$movie->rating) $movie->rating = 0;

// Busca as reviews
$reviews = $database->query(
    "SELECT r.id, r.user_id, u.username, u.avatar, r.rate, r.review, r.date 
    FROM reviews r 
    JOIN movies m ON r.movie_id = m.id 
    JOIN users u ON r.user_id = u.id 
    WHERE m.id = :id",
    Review::class,
    ['id' => $id]
)->fetchAll();

$movie->reviews = $reviews ?? [];

view('movie', compact('movie'));