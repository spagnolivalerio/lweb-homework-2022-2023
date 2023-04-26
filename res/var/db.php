<?php 

    $servername='127.0.0.1';
    $db_username='root';
    $db_password='password';
    $db_name='sands';

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
                        prezzo_tot DECIMAL NOT NULL
                        );";

    $queries = array($create_utente, $create_auto, $create_noleggio);

    
?>
