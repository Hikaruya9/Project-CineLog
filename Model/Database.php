<?php

class DB
{

    private $db;

    public function __construct($config)
    {
        $this->db = new PDO($this->getDns($config));
    }

    private function getDns($config)
    {
        $driver = $config['driver'];
        unset($config['driver']);

        $dsn = $driver . ':' . http_build_query($config, '', ';');

        if ($driver == 'sqlite') {
            $dsn = $driver . ':' . $config['database'];
        }
        return $dsn;
    }

    public function query($query, $class = null, $params = [])
    {
        $prepare = $this->db->prepare($query);

        if ($class) {
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
* avatar VARCHAR(255) DEFAULT ('uploads/avatars/avatar_default.jpg')
* );
**********************************************
* CREATE TABLE reviews (
* id INTEGER PRIMARY KEY AUTOINCREMENT,
* movie_id INTEGER NOT NULL,
* user_id INTEGER NOT NULL,
* rate INTEGER NOT NULL CHECK (nota BETWEEN 1 AND 5),
* review TEXT,
* date TEXT DEFAULT (strftime('%Y-%m-%d', 'now', 'localtime')),  -- Isso irá gravar a data/hora atual automaticamente
* FOREIGN KEY (movie_id) REFERENCES movies(id),
* FOREIGN KEY (user_id) REFERENCES users(id)
);
**********************************************
* CREATE TABLE movies(
* id INTEGER PRIMARY KEY AUTOINCREMENT,
* title VARCHAR NOT NULL,
* director VARCHAR NOT NULL,
* year INTEGER NOT NULL,
* genre VARCHAR NOT NULL,
* synopsis NOT NULL,
* poster VARCHAR DEFAULT ('uploads/posters/poster_default.jpg')
* );
*/