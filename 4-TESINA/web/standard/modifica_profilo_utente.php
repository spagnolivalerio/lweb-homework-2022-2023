<?php
session_start();
include('../../conn.php');
require_once('../../lib/functions.php');
$path = "index.php"; 
$std = "standard";     
addressing($_SESSION['Tipo_utente'], $std, $path); 
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

$query = "SELECT * FROM utente WHERE id = " . $id_utente;
$result = $conn->query($query);
$row = $result->fetch_assoc();

echo "          <form class=\"\" action=\"../../lib/modifica_profilo_utente.php\" method=\"post\">\n";
echo "                   <input type=\"hidden\" name=\"id_utente\" value=\"" . $id_utente . "\"></input>\n";
echo "                   <input type=\"text\" name=\"nome\" value=\"" . $row['nome'] . "\"></input>\n";
echo "                   <input type=\"text\" name=\"cognome\" value=\"" . $row['cognome'] . "\"></input>\n";
echo "                   <input type=\"text\" name=\"email\" value=\"" . $row['email'] . "\"></input>\n";
echo "                   <input type=\"text\" name=\"username\" value=\"" . $row['username'] . "\"></input>\n";
echo "                   <input type=\"text\" name=\"indirizzo\" value=\"" . $row['indirizzo'] . "\"></input>\n";      
echo "                   <button type=\"submit\">Modifica</button>\n";
echo "          </form>\n";

?>

