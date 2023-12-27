<?php

session_start();
include('../conn.php');
$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}



if (!isset($_POST['nome']) || empty($_POST['nome'])) {
    exit;
} else {
    $nome = $_POST['nome'];
}

if (!isset($_POST['cognome']) || empty($_POST['cognome'])) {
    exit;
} else {
    $cognome = $_POST['cognome'];
}

if (!isset($_POST['email']) || empty($_POST['email'])) {
    exit;
} else {
    $email = $_POST['email'];
}

if (!isset($_POST['username']) || empty($_POST['username'])) {
    exit;
} else {
    $username = $_POST['username'];
}


if (!isset($_POST['indirizzo']) || empty($_POST['indirizzo'])) {
    exit;
} else {
    $indirizzo = $_POST['indirizzo'];
}


if (!isset($_POST['id_utente']) || empty($_POST['id_utente'])) {
    exit;
} else {
    $id_utente = $_POST['id_utente'];
}


//AGGIORNAMENTO TABELLA UTENTE

$query = "UPDATE utente SET 
              nome = '$nome',
              cognome = '$cognome',
              email = '$email',
              username = '$username',
              indirizzo = '$indirizzo'
          WHERE id = $id_utente";

$result = $conn->query($query);



header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/bacheca.php');

exit;

?>