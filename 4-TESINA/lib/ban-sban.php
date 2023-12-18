<?php

session_start();

require_once('../conn.php');

#L'idea è quella di prendersi il campo ban al momento del login e a seconda del risultato gestire i permessi dell'utente

$conn = connect_to_db($servername, $db_username, $db_password, $db_name);


if (!isset($_POST['id_profilo']) || empty($_POST['id_profilo'])) {
    exit;
} else {
    $id_profilo = $_POST['id_profilo'];
    echo "$id_profilo";
}

if (!isset($_POST['ban']) || empty($_POST['ban'])) {
    exit;
} else {
    $ban = $_POST['ban'];
    echo "$ban";
}

if($ban == 'sospendi'){

    $sql = "UPDATE utente
            SET ban = 1
            WHERE id  = '$id_profilo'";


    if ($conn->query($sql)) {
        header('Location:../web/moderatore/listautenti.php');
    } 

    else {
        echo "Errore nella query: " . $conn->error;
        exit(1);
    }
}

if($ban == 'riabilita'){

    $sql = "UPDATE utente
            SET ban = 0
            WHERE id  = '$id_profilo'";


    if ($conn->query($sql)) {
        header('Location: ../web/moderatore/listautenti.php');
    } 

    else {
        echo "Errore nella query: " . $conn->error;
        exit(1);
    }
}
?>