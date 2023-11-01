<?php
	require_once('conn.php');

	$conn = new mysqli($servername, $db_username, $db_password);

	$crypt_pwd = md5('password');
	$email_1 = "spagnolivalerio";
	$email_2 = "sicilianodaniele";

	$create_db = "CREATE DATABASE IF NOT EXISTS $db_name;";

	$create_utente = "CREATE TABLE IF NOT EXISTS utente(
					  id INT AUTO_INCREMENT PRIMARY KEY,
					  nome VARCHAR(32) NOT NULL,
					  cognome VARCHAR(32) NOT NULL, 
					  username VARCHAR(32) NOT NULL UNIQUE, 
					  password VARCHAR(128) NOT NULL,
					  email VARCHAR(128) NOT NULL UNIQUE,
					  punti_reputazione DECIMAL NOT NULL DEFAULT 0, 
					  livello INT NOT NULL DEFAULT 0,
					  clearance INT NOT NULL DEFAULT 1,
					  tipo ENUM ('standard', 'moderatore', 'amministratore') NOT NULL
					  );";

	$insert_utente = "INSERT INTO utente (nome, cognome, username, password, email, tipo)
					  VALUES ('Valerio', 'Spagnoli', 'utente1', '$crypt_pwd', '$email_1', 'amministratore'),
					  	     ('Daniele', 'Siciliano', 'utente2', '$crypt_pwd', '$email_2', 'amministratore');";
	
	$queries = array($create_db, $create_utente, $insert_utente);

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

	header("Location: web/login.php");

	$conn->close;
?>