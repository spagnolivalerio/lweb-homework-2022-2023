<?php
session_start();
include('../../conn.php');
require_once('../../lib/functions.php');
require_once('../../lib/get_nodes.php');
$path = "index.php"; 
$mod = "moderatore";     
$root = "../../";
addressing($_SESSION['Tipo_utente'], $mod, $path); 
$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

$logout = $root . "lib/logout.php?ban=true";
addressing($_SESSION['ban'], 0, $logout);

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
      <link type="text/css" rel="stylesheet" href="../../res/css/edit-info.css" />


  </head>

  <body>

    <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione">
          
        </div>
        <div class="homepage-sidebar-list">
          <a class="elem" href="homepage.php">Homepage</a>
          <a class="elem" href="bacheca.php">Bacheca</a>
          <a class="elem" href="moderator_dashboard.php">Dashboard</a>
          <a class="elem" href="view_bozze.php">Bozze</a>
          <a class="elem" href="view_storico.php">Storico</a>
          <div class="divisore"></div>
          <a class="elem" href="../../lib/logout.php">Logout</a>
        </div>
      </div>
      <div class="dashboard">
      <div class="bar"></div>
        <div class="toolbar"></div>

        <div class="title">MODIFICA SPECIFICHE PROGETTO</div>
        <div id="error">
                <?php 
                    if(isset($_SESSION['empty_form']) && $_SESSION['empty_form'] === "true" ){
                        echo "Compila tutti i campi";
                        unset($_SESSION['empty_form']);
                    } 
                ?>
            <script>
                function scomparsa() {
                    var error = document.getElementById('error');
                    if (error) {
                        error.style.display = "none";
                    }
                }
                setTimeout(scomparsa, 4000);
            </script>
            </div>
            <div id="success">
                <?php 
                    if(isset($_SESSION['esito']) && $_SESSION['esito'] === "true" ){
                        echo "Specifiche modificate con successo";
                        unset($_SESSION['esito']);
                    } 
                ?>
            <script>
                function scomparsa() {
                    var error = document.getElementById('success');
                    if (error) {
                        error.style.display = "none";
                    }
                }
                setTimeout(scomparsa, 4000);
            </script>
            </div>

<?php

echo "<div class=\"form-container\">";
echo "<form action=\"../../lib/modifica_specifiche_progetto.php\" method=\"post\">\n";
echo "    <input type=\"hidden\" name=\"id_progetto\" value=\"" . $id_progetto . "\">\n";
echo "    <label class=\"form-label\" for=\"clearance\">Clearance</label>\n"; 
echo "    <input class=\"form-input\" type=\"number\" name=\"clearance\" min=\"1\" max=\"5\" value=\"" . $clearance . "\">\n";
echo "    <label class=\"form-label\" for=\"durata\">Durata (min)</label>\n"; 
echo "    <input class=\"form-input\" type=\"number\" name=\"durata\" value=\"" . $durata . "\">\n";
echo "    <label class=\"form-label\" for=\"difficoltà\">Difficoltà: </label>\n";
echo "    <select class=\"form-input\" id=\"difficoltà\" name=\"difficoltà\" required>\n";
echo "        <option value=\"facile\"" . ($difficoltà == 'facile' ? ' selected' : '') . ">Facile</option>\n";
echo "        <option value=\"medio\"" . ($difficoltà == 'medio' ? ' selected' : '') . ">Medio</option>\n";
echo "        <option value=\"difficile\"" . ($difficoltà == 'difficile' ? ' selected' : '') . ">Difficile</option>\n";
echo "    </select>\n";
echo "    <br>\n";
echo "    <button class=\"form-button\" type=\"submit\">Modifica</button>\n";
echo " </form>\n";
echo " <form  action=\"../../lib/rimuovere_progetto.php?goto=homepage\" method=\"post\">\n";
echo "    <input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input>";
echo "    <button class=\"form-button bg-red\" type=\"submit\">Elimina</button>\n";
echo " </form>\n";
echo " </div>\n";

?>

