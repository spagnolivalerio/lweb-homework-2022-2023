<?php 

    $servername='127.0.0.1';
    $db_username='root';
    $password='password';
    $dbname='sands';

    $create_db = "CREATE DATABASE IF NOT EXISTS $dbname;";

    $create_utente = "CREATE TABLE IF NOT EXISTS utente(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(32) NOT NULL UNIQUE,
                    password VARCHAR(32) NOT NULL,
                    nome VARCHAR(32) NOT NULL, 
                    cognome VARCHAR(32) NOT NULL
                    );";

    $queries = array($create_utente);

?>