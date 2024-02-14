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

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/control/view-dashboard.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/edit-info.css"></link>


  </head>

  <body>

    <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione">
          
        </div>
        <div class="homepage-sidebar-list">
          <a class="elem" href="homepage.php">Homepage</a>
          <a class="elem" href="bacheca.php">Profilo</a>
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
            <script type="text/javascript">
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
            <script type="text/javascript">
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
echo "    <div class=\"nascondi\"><input type=\"hidden\" name=\"id_progetto\" value=\"" . $id_progetto . "\"></input></div>\n";
echo "    <p class=\"form-label\" >Clearance<br />\n"; 
echo "    <input class=\"form-input\" type=\"number\" name=\"clearance\" min=\"1\" max=\"5\" value=\"" . $clearance . "\"></input></p>\n";
echo "    <p class=\"form-label\">Durata (min)<br />\n"; 
echo "    <input class=\"form-input\" type=\"number\" name=\"durata\" value=\"" . $durata . "\"></input></p>\n";
echo "    <p class=\"form-label\">Difficoltà: <br />\n";
echo "    <select class=\"form-input\" id=\"difficoltà\" name=\"difficoltà\">\n";
echo "        <option value=\"facile\"" . ($difficoltà == 'facile' ? ' selected="selected"' : '') . ">Facile</option>\n";
echo "        <option value=\"medio\"" . ($difficoltà == 'medio' ? ' selected="selected"' : '') . ">Medio</option>\n";
echo "        <option value=\"difficile\"" . ($difficoltà == 'difficile' ? ' selected="selected"' : '') . ">Difficile</option>\n";
echo "    </select></p>\n";
echo "    <div><button class=\"form-button\" type=\"submit\">Modifica</button></div>\n";
echo " </form>\n";
echo " <form  action=\"../../lib/rimuovere_progetto.php?goto=homepage\" method=\"post\">\n";
echo "    <div class=\"nascondi\"><input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input></div>";
echo "    <div><button class=\"form-button bg-red\" type=\"submit\">Elimina</button></div>\n";
echo " </form>\n";
echo " </div>\n";

?>
        </div>
      </div>


    </body>
    </html>
