<?php

class DB{

    private $db;

    public function __construct($config)
    {
        $this->db = new PDO($this->getDns($config));
    }
    
    private function getDns($config){
        $driver = $config['driver'];
        unset($config['driver']);

        $dsn = $driver . ':' . http_build_query($config, '', ';');

        if($driver == 'sqlite'){
            $dsn = $driver . ':' . $config['database'];
        }
        return $dsn;
    }

    public function query($query, $class = null, $params = []){
        $prepare = $this->db->prepare($query);

        if($class){
            $prepare->setFetchMode(PDO::FETCH_CLASS, $class);
        }

        $prepare->execute($params);
        return $prepare;
    }
}

$database = new DB($config['database']);

/*
* CREATE TABLE users(
* id INTEGER PRIMARY KEY AUTOINCREMENT,
* username VARCHAR(64) NOT NULL,
* email VARCHAR(128) NOT NULL UNIQUE,
* password VARCHAR(64) NOT NULL,
* avatar VARCHAR(255) DEFAULT ('default')
* );
**********************************************
* CREATE TABLE users_movies(
* id_user INTEGER,
* id_movie INTEGER,
* rate INTEGER NOT NULL,
* PRIMARY KEY(id_user, id_movie)
* -- log_time DATETIME DEFAULT CURRENT_TIME
* );
**********************************************
* CREATE TABLE movies(
* id INTEGER PRIMARY KEY AUTOINCREMENT,
* title VARCHAR(255) NOT NULL,
* director VARCHAR(64) NOT NULL,
* year INTEGER NOT NULL,
* genre_id INTEGER NOT NULL,
* synopsis NOT NULL,
* poster VARCHAR(255) NOT NULL,
* FOREIGN KEY (genre_id) REFERENCES genre(id) 
* );
**********************************************
* CREATE TABLE genres(
* id INTEGER PRIMARY KEY AUTOINCREMENT,
* name VARCHAR(64) NOT NULL UNIQUE
* );
*/