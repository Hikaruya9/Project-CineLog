<?php

$controller = str_replace('/', '', parse_url($_SERVER['REQUEST_URI'])['path']);

if(!$controller) $controller = 'index';

if(!file_exists("Controller/{$controller}.controller.php")){
    abort(404);
}

require "Controller/{$controller}.controller.php";

?>