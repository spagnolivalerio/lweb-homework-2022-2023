<?php
session_start();
include('../../conn.php');
require_once('../../lib/functions.php');
$path = "index.php"; 
$mod = "moderatore";     
addressing($_SESSION['Tipo_utente'], $mod, $path); 
$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

if (!isset($_POST['clearance']) || empty($_POST['clearance'])) {
    exit;
} else {
    $clearance = $_POST['clearance'];
}

if (!isset($_POST['difficoltà']) || empty($_POST['difficoltà'])) {
    exit;
} else {
    $difficoltà = $_POST['difficoltà'];
}

if (!isset($_POST['durata']) || empty($_POST['durata'])) {
    exit;
} else {
    $durata = $_POST['durata'];
}

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}


echo "          <form class=\"\" action=\"../../lib/modifica_specifiche_progetto.php\" method=\"post\">\n";
echo "               <input type=\"hidden\" name=\"id_progetto\" value=\"" . $id_progetto . "\"></input>\n";
echo "               <input type=\"number\" name=\"clearance\" min=\"1\" max=\"5\" value=\"" . $clearance . "\"></input>\n";
echo "               <input type=\"number\" name=\"durata\"  value=\"" . $durata . "\"></input>\n";

if($difficoltà == 'facile') {
    echo            '<label for="difficoltà">Difficoltà: </label>';
    echo            '<select id="difficoltà" name="difficoltà" required>';
    echo            '<option value="facile">Facile</option>';
    echo            '<option value="medio">Medio</option>';
    echo            '<option value="difficile">Difficile</option>';
    echo            '</select>';
    echo            '<br>';
} elseif($difficoltà == 'medio') {
    echo            '<label for="difficoltà">Difficoltà: </label>';
    echo            '<select id="difficoltà" name="difficoltà" required>';
    echo            '<option value="facile">Medio</option>';
    echo            '<option value="medio">Facile</option>';
    echo            '<option value="difficile">Difficile</option>';
    echo            '</select>';
    echo            '<br>';
} elseif($difficoltà == 'difficile') {
    echo            '<label for="difficoltà">Difficoltà: </label>';
    echo            '<select id="difficoltà" name="difficoltà" required>';
    echo            '<option value="facile">Difficile</option>';
    echo            '<option value="medio">Facile</option>';
    echo            '<option value="difficile">Medio</option>';
    echo            '</select>';
    echo            '<br>';
}
echo "          <button type=\"submit\">Modifica</button>\n";
echo "          </form>\n";

?>

