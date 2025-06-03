<?php

if (isset($_REQUEST['user-id']) || isset($_SESSION['user-id'])) {

    $id = $_REQUEST['user-id'] ?? $_SESSION['user-id'];

    $user = $database->query(
        query: "SELECT id, username, avatar FROM users WHERE id = :id",
        class: User::class,
        params: ['id' => $id]
    )->fetch();

    if ($user) {
        $user->rated_movies = $database->query(
            query: "SELECT m.id, m.title, m.poster, r.rate as user_rating
                    FROM movies m
                    JOIN reviews r ON m.id = r.movie_id
                    WHERE r.user_id = :user_id AND r.rate IS NOT NULL
                    ORDER BY r.date DESC",
            class: Movie::class,
            params: ['user_id' => $id]
        )->fetchAll();

        $user->reviews_with_comments = $database->query(
            query: "SELECT r.movie_id, m.title as movie_title, r.rate, r.review, r.date
                    FROM reviews r
                    JOIN movies m ON r.movie_id = m.id
                    WHERE r.user_id = :user_id AND r.review IS NOT NULL AND r.review != ''
                    ORDER BY r.date DESC",
            class: Review::class,
            params: ['user_id' => $id]
        )->fetchAll();
    }

    view('profile', compact('user'));
}
