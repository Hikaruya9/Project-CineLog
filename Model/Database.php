<?php

class DB{

    private $db;

    function __construct()
    {
        $this->db = new PDO('sqlite:database.sqlite');
    }
    
}

?>