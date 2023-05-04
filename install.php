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

    $create_auto = "CREATE TABLE IF NOT EXISTS auto(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    marca VARCHAR(32) NOT NULL,
                    modello VARCHAR(32) NOT NULL,
                    colore VARCHAR(32) NOT NULL,
                    cambio ENUM ('Automatico', 'Manuale') NOT NULL, 
                    carburante ENUM ('Benzina', 'Diesel', 'Ibrido', 'GPL', 'Elettrico') NOT NULL,
                    categoria ENUM ('Utilitaria', 'Suv', 'Sportiva') NOT NULL,
                    prezzo_giornaliero DECIMAL NOT NULL,
                    nome_file_img VARCHAR(100) NOT NULL,
                    cavalli INT NOT NULL,
                    num_porte INT NOT NULL, 
                    num_posti INT NOT NULL
                    );";

    $create_noleggio = "CREATE TABLE IF NOT EXISTS noleggio(
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        id_auto INT NOT NULL REFERENCES auto(id),
                        id_utente INT NOT NULL REFERENCES utente(id), 
                        data_inizio DATE NOT NULL, 
                        data_fine DATE NOT NULL, 
                        prezzo_tot DECIMAL NOT NULL,
                        UNIQUE (id_auto, data_inizio, data_fine)
                        );";

   	$insert_auto = "INSERT INTO auto (id, marca, modello, colore, cambio, carburante, categoria,							prezzo_giornaliero, nome_file_img, cavalli, num_porte, num_posti)
   		 			VALUES
					(1, 'JEEP', 'RENEGADE', 'nero', 'Automatico', 'Diesel', 'Suv', 46, 'jeep_renegade.jpg', 120, 5, 5),
					(2, 'BMW', 'X3', 'bianco', 'Automatico', 'Benzina', 'Suv', 50, 'bmwX3.jpg', 161, 5, 5),
					(3, 'MERCEDES', 'CLASSE C', 'bianco', 'Manuale', 'GPL', 'Utilitaria', 32, 'mercedesclasseC.jpg', 100, 5, 5),
					(4, 'AUDI', 'A5', 'bianco', 'Automatico', 'Ibrido', 'Utilitaria', 43, 'audiA5.jpg', 140, 5, 5),
					(5, 'VOLKSWAGEN', 'T-ROC', 'grigio', 'Automatico', 'Diesel', 'Suv', 45, 'volkswagenTROC.jpg', 138, 5, 5),
					(6, 'RENAULT', 'CLIO', 'bianco', 'Manuale', 'GPL', 'Utilitaria', 29, 'renaultCLIO.jpg', 50, 5, 5),
					(7, 'CITROEN', 'C3', 'bianco', 'Automatico', 'Benzina', 'Utilitaria', 70, 'citroenC3.jpg', 48, 5, 5),
					(8, 'BMW', 'SERIE 3 ', 'blu', 'Automatico', 'Diesel', 'Utilitaria', 60, 'bmwSERIE3.jpg', 100, 5, 5);";

    $queries = array($create_utente, $create_auto, $create_noleggio, $insert_auto);


    if(!mysqli_query($conn, $create_db)){
        exit(1);
    } else {
        $conn = create_db();
    }

    foreach ($queries as $query) {
        if(!$conn->query($query)){
            exit(1);
        }
    }

    header('Location: index.php');

    $conn->close();

?>