<?php
session_start();
include('../../conn.php');
require_once('../../lib/functions.php');
$path = "index.php"; 
$mod = "moderatore";     
$tps_root = "../../";
addressing($_SESSION['Tipo_utente'], $mod, $path); 
$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

$logout = $tps_root . "lib/logout.php?ban=true";
addressing($_SESSION['ban'], 0, $logout);

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}


if (!isset($_POST['id_utente']) && (isset($_GET['id_utente']) ) ) {
    $id_utente = $_GET['id_utente'];
  } elseif(!empty($_POST['id_utente'])) {
    $id_utente = $_POST['id_utente'];
  }elseif(!isset($_POST['id_utente']) && !isset($_GET['id_utente'])){
    header("Location: ../index.php" );
  }
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

        <div class="title">MODIFICA DATI PROFILO</div>
             <div id="error">
                <?php 
                    if(isset($_SESSION['empty_form']) && $_SESSION['empty_form'] === "true" ){
                        echo "Compila tutti i campi";
                        unset($_SESSION['empty_form']);
                    }elseif(isset($_SESSION['username_esistente']) && $_SESSION['username_esistente'] === "true"){
                      echo "Username già utilizzato!";
                      unset($_SESSION['username_esistente']);
                    }elseif(isset($_SESSION['email_esistente']) && $_SESSION['email_esistente'] === "true"){
                      echo "E-mail non utilizzabile!";
                      unset($_SESSION['email_esistente']);
                    }elseif(isset($_SESSION['email_invalid']) && $_SESSION['email_invalid'] === "true"){
                      echo "E-mail non rispetta il formato richiesto!";
                      unset($_SESSION['email_invalid']);
                    } 
                ?>
            </div>
            <script type="text/javascript">
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
                        echo "Dati modificati con successo";
                        unset($_SESSION['esito']);
                    } 
                ?>
            </div>
            <script type="text/javascript">
                function scomparsa() {
                    var error = document.getElementById('success');
                    if (error) {
                        error.style.display = "none";
                    }
                }
                setTimeout(scomparsa, 4000);
            </script>
    


        <?php



        $query = "SELECT * FROM utente WHERE id = " . $id_utente;
        $result = $conn->query($query);
        $row = $result->fetch_assoc();

        echo " <form class=\"form-container\" action=\"../../lib/modifica_profilo_utente.php\" method=\"post\">\n";
        echo "    <div class=\"nascondi\"><input type=\"hidden\" name=\"id_utente\" value=\"" . $id_utente . "\"></input></div>\n";
        echo "    <p class=\"form-label\">Nome <br />\n";
        echo "    <input class=\"form-input\" type=\"text\" name=\"nome\" value=\"" . $row['nome'] . "\"></input></p>\n";
        echo "    <p class=\"form-label\">Cognome<br />\n";
        echo "    <input class=\"form-input\" type=\"text\" name=\"cognome\" value=\"" . $row['cognome'] . "\"></input></p>\n";
        echo "    <p class=\"form-label\">E-mail<br />\n";
        echo "    <input class=\"form-input\" type=\"text\" name=\"email\" value=\"" . $row['email'] . "\"></input></p>\n";
        echo "    <div class=\"nascondi\"><input type=\"hidden\" name=\"old_email\" value=\"" . $row['email'] . "\"></input></div>\n";
        echo "    <p class=\"form-label\">Username<br />\n";
        echo "    <input class=\"form-input\" type=\"text\" name=\"username\" value=\"" . $row['username'] . "\"></input></p>\n";
        echo "    <div class=\"nascondi\"><input type=\"hidden\" name=\"old_username\" value=\"" . $row['username'] . "\"></input></div>\n";
        echo "    <p class=\"form-label\" >Indirizzo<br />\n";
        echo "    <input class=\"form-input\" type=\"text\" name=\"indirizzo\" value=\"" . $row['indirizzo'] . "\"></input></p>\n";
        echo "    <div><button class=\"form-button\" type=\"submit\">Modifica</button></div>\n";
        echo " </form>\n";

?>

       </div>
      </div>
    </body>
</html>
