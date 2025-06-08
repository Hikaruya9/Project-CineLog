<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add-movie'])) {

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
        'poster' => ['image']
    ];

    $validationResult = $validator->validate($rules, $data);

    if ($validationResult->hasErrors()) {
        $_SESSION['auth'] = $validationResult->getErrors();
        header('Location: /movie-add');
        exit();
    }

    if (!empty($_FILES['poster']['name'])) {
        $uploadDir = 'uploads/posters/';
        $filename = uniqid() . '_' . basename($_FILES['poster']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetPath)) {
            
            $posterPath = $targetPath;
        }
    }

    $database->query(
        query: "INSERT INTO movies (title, director, year, genre, synopsis, poster) VALUES (:title, :director, :year, :genre, :synopsis, :poster)",
        params: [
            'title' => $_POST['title'],
            'director' => $_POST['director'],
            'year' => $_POST['year'],
            'genre' => $_POST['genre'],
            'synopsis' => $_POST['synopsis'],
            'poster' => $posterPath
        ]
    );

    header('Location: /movies');
    exit();
} else {
    view('movie-add');
}
