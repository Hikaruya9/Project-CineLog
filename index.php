<?php

session_start();

require 'functions.php';
require 'protect.php';
require 'Model/Movie.php';
require 'Model/User.php';
require 'Model/Review.php';
$config = require 'config.php';
require 'Model/Database.php';
require 'routes.php';

?>