<?php

session_start();
include('../conn.php');
require_once('get_nodes.php');
$radice = "../";

$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

if (!isset($_POST['id_utente']) || empty($_POST['id_utente'])) {
    exit;
} else {
    $id_utente = $_POST['id_utente'];
}

if (!isset($_POST['username']) || empty($_POST['username'])) {
    exit;
} else {
    $username = $_POST['username'];
}

if (!isset($_POST['vecchia_password']) || empty($_POST['vecchia_password'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_password_utente.php?id_utente=' . $id_utente);
    exit;
} else {
    $vecchia_password = mysqli_real_escape_string($conn, $_POST['vecchia_password']);
}

if (!isset($_POST['nuova_password']) || empty($_POST['nuova_password'])) {
    $_SESSION['empty_form'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_password_utente.php?id_utente=' . $id_utente);
    exit;
} else {
    $nuova_password = mysqli_real_escape_string($conn, $_POST['nuova_password']);
}


$vecchia_password = md5($vecchia_password);


$query = "SELECT *
			  FROM utente
			  WHERE username = '$username'
			  AND password = '$vecchia_password'"; //in sql i valori delle stringhe vanno in apici, le variabili sono intepretate dalle virgolette "";

$rows = mysqli_query($conn, $query);

if (mysqli_num_rows($rows) == 0) {
    $_SESSION['errore_vecchia_password'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_password_utente.php?id_utente=' . $id_utente);
    exit();
}

if (!preg_match('~^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9]).{8,}$~', $nuova_password)){
    $_SESSION['nuova_password_unmatch'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_password_utente.php?id_utente=' . $id_utente);
    exit;
}

$nuova_password = md5($nuova_password);

if ($vecchia_password === $nuova_password) {
    $_SESSION['same_pass'] = "true";
    header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_password_utente.php?id_utente=' . $id_utente);
    exit;
}

//AGGIORNAMENTO TABELLA UTENTE

$query = "UPDATE utente SET 
              password = '$nuova_password'
          WHERE id = $id_utente";

$result = $conn->query($query);

$_SESSION['esito'] = "true";

header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/modifica_password_utente.php?id_utente=' . $id_utente);

exit;

?>