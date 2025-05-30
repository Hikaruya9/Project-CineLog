<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-movie'])) {

    require 'validator.php';
    $validator = new Validator();

    $data = $_POST;
    settype($data['year'], "integer");
    $data['poster'] = $_FILES['poster'] ?? '';

    $rules = [
        'title' => ['required'],
        'director' => ['required'],
        'year' => ['required', 'min:1880', 'max:2100'],
        'genre' => ['required'],
        'synopsis' => ['required'],
        'poster' => ['empty', 'image']
    ];

    $validationResult = $validator->validate($rules, $data);

    if ($validationResult->hasErrors()) {
        $_SESSION['auth'] = $validationResult->getErrors();
        header('Location: /movie-update?movie-id=' . $_POST['movie-id']);
        exit();
    }

    $params = [
        'title' => $_POST['title'],
        'director' => $_POST['director'],
        'year' => $_POST['year'],
        'genre' => $_POST['genre'],
        'synopsis' => $_POST['synopsis'],
        'id' => $_POST['movie-id']
    ];

    $fields = "title = :title, director = :director, year = :year, genre = :genre, synopsis = :synopsis";

    if (!empty($_FILES['poster']['name'])) {
        $uploadDir = 'uploads/posters/';
        $filename = uniqid() . '_' . basename($_FILES['poster']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetPath)) {
            if ($movie->poster !== ($uploadDir . 'poster_default.jpg')) {
                @unlink($movie->poster);
            }
            $posterPath = $targetPath;
            $params['poster'] = $posterPath;
            $fields .= ", poster = :poster";
        }
    }

    $database->query(
        query: "UPDATE movies SET $fields WHERE id = :id",
        params: $params
    );

    $_SESSION['auth'][] = "Informações do filme atualizadas com sucesso!";
    header('Location: /movie-update?movie-id=' . $_POST['movie-id']);
    exit();
} elseif (isset($_REQUEST['movie-id'])) {

    $id = $_REQUEST['movie-id'];

    $movie = $database->query(
        query: "SELECT id,title,director,year,genre,synopsis,poster FROM movies WHERE id = :id",
        class: Movie::class,
        params: ['id' => $id]
    )->fetch();

    view('movie-update', compact('movie'));
}