<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['review-movie'])) {

    require 'validator.php';
    $validator = new Validator();

    $data = $_POST;
    settype($data['rate'], "integer");

    $rules = [
        'rate' => ['required', 'min:1', 'max:5']
    ];

    $validationResult = $validator->validate($rules, $data);

    if ($validationResult->hasErrors()) {
        $_SESSION['auth'] = $validationResult->getErrors();
        header('Location: /review?movie-id=' . $_POST['movie-id']);
        exit();
    }

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

} elseif (isset($_REQUEST['movie-id'])) {

    $id = $_REQUEST['movie-id'] ?? '';

    $movie = $database->query(
        query: "SELECT id,title,year,poster FROM movies WHERE id = :id",
        class: Movie::class,
        params: ['id' => $id]
    )->fetch();

    view('review', compact('movie'));
}
