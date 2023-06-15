<?php
	require_once('res/var/connection.php');

	$conn = new mysqli($servername, $db_username, $db_password);

	$create_db = "CREATE DATABASE IF NOT EXISTS $db_name;";

    $create_utente = "CREATE TABLE IF NOT EXISTS utente(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(32) NOT NULL UNIQUE,
                    password VARCHAR(32) NOT NULL,
                    nome VARCHAR(32) NOT NULL, 
                    cognome VARCHAR(32) NOT NULL
                    );";


    $queries = array($create_utente);


    if(!mysqli_query($conn, $create_db)){
        exit();
    } else {
        $conn = connect_to_db($servername, $db_username, $db_password, $db_name);
    }

    foreach ($queries as $query) {
        if(!$conn->query($query)){
            exit();
        }
    }

    header('Location: index.php');

    $conn->close();

?>