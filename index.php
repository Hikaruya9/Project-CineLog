<?php

session_start();

require 'protect.php';
require 'functions.php';
require 'Model/Movie.php';
require 'Model/User.php';
$config = require 'config.php';
require 'Model/Database.php';
require 'routes.php';

?>