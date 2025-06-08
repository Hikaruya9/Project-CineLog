<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Nova review
    if (isset($_POST['review-movie'])) {

        $fields = "movie_id,user_id,rate";
        $fieldsValues = ":movie_id, :user_id, :rate";
        $params = [
            'movie_id' => $_POST['movie-id'],
            'user_id' => $_SESSION['user-id'],
            'rate' => $_POST['rate']
        ];

        if (!empty($_POST['review'])) {
            $review = trim($_POST['review']);
            $fields .= ",review";
            $fieldsValues .= ", :review";
            $params['review'] = $review;
        }

        $database->query(
            query: "INSERT INTO reviews($fields) VALUES ($fieldsValues)",
            params: $params
        );

        header("Location: /movie?movie-id={$_POST['movie-id']}");
        exit;
    }

    // Atualizar review
    if (isset($_POST['edit-review'])) {

        $fields = "rate = :rate";
        $params = [
            'rate' => $_POST['rate'],
            'id' => $_POST['review-id']
        ];

        if (!empty($_POST['review'])) {
            $review = trim($_POST['review']);
            $fields .= ", review = :review";
            $params['review'] = $review;
        }

        $database->query(
            query: "UPDATE reviews SET $fields WHERE id = :id",
            params: $params
        );

        header("Location: /movie?movie-id={$_POST['movie-id']}");
        exit;
    }

    // Deletar review
    if (isset($_POST['delete-review'])) {

        $id = $_REQUEST['review-id'];

        $review = $database->query(
            query: "SELECT user_id, movie_id FROM reviews WHERE id = :id",
            class: Review::class,
            params: ['id' => $id]
        )->fetch();

        if ($review && ($_SESSION['user-id'] == $review->user_id || $_SESSION['permission_level'] == '1')) {

            $database->query(
                query: "DELETE FROM reviews WHERE id = :id",
                params: ['id' => $id]
            );

            header("Location: /movie?movie-id=" . $review->movie_id);
            exit;
        }

        header('Location: /movie?movie-id=' . $review->movie_id);
        exit;
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Página de envio de review
    if (isset($_REQUEST['movie-id'])) {

        $id = $_REQUEST['movie-id'];

        $movie = $database->query(
            query: "SELECT id,title,year,poster FROM movies WHERE id = :id",
            class: Movie::class,
            params: ['id' => $id]
        )->fetch();

        view('review', compact('movie'));
    }

    // Página de atualização de review
    if (isset($_GET['review-id'])) {

        $id = $_GET['review-id'];

        $review = $database->query(
            query: "SELECT r.id, r.movie_id, r.rate, r.review, m.title AS movie_title 
         FROM reviews r
         JOIN movies m ON r.movie_id = m.id
         WHERE r.id = :id",
            class: Review::class,
            params: ['id' => $id]
        )->fetch();

        $movie = $database->query(
            query: "SELECT id,title,year,poster FROM movies WHERE id = :id",
            class: Movie::class,
            params: ['id' => $review->movie_id]
        )->fetch();

        view('review', compact('review', 'movie'));
    }
} else {
    header('Location: /');
    exit();
}
