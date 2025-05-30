<?php

$movie = $database->query(
query: "SELECT id,title,director,year,genre,synopsis,poster FROM movies WHERE id = :id",
class: Movie::class,
params: ['id' => $_REQUEST['movie']]
)->fetch();

view('movie', compact('movie'));

?>