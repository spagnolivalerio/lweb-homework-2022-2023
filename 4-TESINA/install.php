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
					  indirizzo VARCHAR(128) NOT NULL,
					  avatar VARCHAR(32) NOT NULL,
					  data DATE NOT NULL,
					  livello INT NOT NULL DEFAULT 1,
					  peso_valutazione DECIMAL NOT NULL DEFAULT 1,
					  punti_reputazione DECIMAL NOT NULL DEFAULT 0, 
					  clearance INT NOT NULL DEFAULT 1,
					  tipo ENUM ('standard', 'moderatore', 'admin') NOT NULL DEFAULT 'standard',
					  ban BOOLEAN DEFAULT FALSE
					  );";

	$insert_utente = "INSERT INTO utente (nome, cognome, username, password, email, livello, tipo, peso_valutazione, indirizzo,avatar,data)
					  VALUES ('Valerio', 'Spagnoli', 'adm1', '$crypt_pwd', '$email_1', '100', 'admin', '10', 'via della gaurdia','avatar1.png','2023-10-23'),
					  	     ('Daniele', 'Siciliano', 'adm2', '$crypt_pwd', '$email_2', '100', 'admin', '10', 'via saturno', 'avatar2.png','2023-10-23'),
							 ('MODERATORE', 'mod', 'moderatore1', '$crypt_pwd', 'moderatore@gmail.com', '100', 'moderatore', '10', 'via saturno', 'avatar2.png','2023-10-23'),
							 ('Mario', 'Rossi', 'utentestd1', '$crypt_pwd', 'utente@gmail.com', '1', 'standard', '10', 'via saturno', 'avatar1.png','2023-10-23');";
	
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

	header("Location: web/visitatore.php");

	$conn->close;
?>