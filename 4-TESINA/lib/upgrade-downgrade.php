<?php

session_start();

include('../conn.php');
include('functions.php');
$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

$radice = "../";

if (!isset($_POST['id_profilo']) || empty($_POST['id_profilo'])) {
    exit;
} else {
    $id_profilo = $_POST['id_profilo'];
}

if (!isset($_POST['Tipo_utente']) || empty($_POST['Tipo_utente'])) {
    exit;
} else {
    $Tipo_utente = $_POST['Tipo_utente'];
}


if (isset($_POST['upgrade'])) {  #L'idea è quella di stampare il bottone upgrade solo per i profili con Tipoutente=standard

     $Tipo_utente = "moderatore";  
    
    $query = "UPDATE utente
                SET tipo = '$Tipo_utente'
                WHERE id  = '$id_profilo'";

    $result = $conn->query($query);

    if (!$result) {
        echo "Errore nella query: " . $conn->error;
        exit;
    }

    $update_query = "UPDATE utente SET livello = 100, punti_reputazione = 0, peso_valutazione = 10 WHERE id = $id_profilo";
    $res = $conn->query($update_query);

    $url = "../web/" . $_SESSION['Tipo_utente'] . "/listautenti.php";
    header("Location: $url");
    exit;
} 
  
if (isset($_POST['downgrade'])) { #L'idea è quella di stampare il bottone downgrade solo per i profili con Tipoutente=moderatore
    
    $Tipo_utente = "standard";

    $query = "UPDATE utente
                SET tipo = '$Tipo_utente'
                WHERE id  = '$id_profilo'";

    
    $result = $conn->query($query);

 
    if (!$result) {
        echo "Errore nella query: " . $conn->error;
        exit(1);
    }


    updateAllUsers($radice, $conn);

    $url = "../web/" . $_SESSION['Tipo_utente'] . "/listautenti.php";
    header("Location: $url");
    exit;
}

?>