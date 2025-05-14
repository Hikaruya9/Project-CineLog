<?php

$movie = $database->query(
query: "SELECT * FROM movies WHERE id = :id",
class: Movie::class,
params: ['id' => $_REQUEST['id']]
)->fetch();

view('movie', compact('movie'));

?>