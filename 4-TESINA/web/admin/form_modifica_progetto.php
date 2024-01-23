<?php
session_start();
include('../../conn.php');
require_once('../../lib/functions.php');
require_once('../../lib/get_nodes.php');
$path = "index.php"; 
$adm = "admin";  
$root = "../../"; 
addressing($_SESSION['Tipo_utente'], $adm, $path); 
$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

if (!isset($_POST['id_progetto']) && (isset($_GET['id_progetto']) ) ) {
    $id_progetto = $_GET['id_progetto'];
  } elseif(!empty($_POST['id_progetto'])) {
    $id_progetto = $_POST['id_progetto'];
  }elseif(!isset($_POST['id_progetto']) && !isset($_GET['id_progetto'])){
    header("Location: ../index.php" );
  }

  $progetto = getProgetto($root, $id_progetto);
  $clearance = $progetto->getAttribute('clearance');
  $difficoltà = $progetto->getAttribute('difficolta');
  $durata = $progetto->getAttribute('tempo_medio');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/control/view-dashboard.css" />

  </head>

  <body>

    <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione">
          <div class="logo">TPS</div>
        </div>
        <div class="homepage-sidebar-list">
          <a class="elem" href="homepage.php">Homepage</a>
          <a class="elem" href="bacheca.php">Bacheca</a>
          <a class="elem" href="moderator_dashboard.php">Dashboard</a>
          <a class="elem" href="view_storico.php">Storico</a>
          <div class="divisore"></div>
          <a class="elem" href="../../lib/logout.php">Logout</a>
        </div>
      </div>
      <div class="dashboard">
      <div class="bar"></div>
        <div class="toolbar"></div>

        <div class="title">CAMBIA PASSWORD</div>
        <div id="error">
                <?php 
                    if(isset($_SESSION['empty_form']) && $_SESSION['empty_form'] === "true" ){
                        echo "Compila tutti i campi";
                        unset($_SESSION['empty_form']);
                    } 
                ?>
            </div>
            <script>
                function scomparsa() {
                    var error = document.getElementById('error');
                    if (error) {
                        error.style.display = "none";
                    }
                }
                setTimeout(scomparsa, 4000);
            </script>
            <div id="success">
                <?php 
                    if(isset($_SESSION['esito']) && $_SESSION['esito'] === "true" ){
                        echo "Specifiche modificate con successo";
                        unset($_SESSION['esito']);
                    } 
                ?>
            </div>
            <script>
                function scomparsa() {
                    var error = document.getElementById('success');
                    if (error) {
                        error.style.display = "none";
                    }
                }
                setTimeout(scomparsa, 4000);
            </script>

<?php



echo "          <form class=\"\" action=\"../../lib/modifica_specifiche_progetto.php\" method=\"post\">\n";
echo "               <input type=\"hidden\" name=\"id_progetto\" value=\"" . $id_progetto . "\"></input>\n";
echo "               <label for=\"clearance\">Clearance</label>\n"; 
echo "               <input type=\"number\" name=\"clearance\" min=\"1\" max=\"5\" value=\"" . $clearance . "\"></input>\n";
echo "               <label for=\"durata\">Durata</label>\n"; 
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

