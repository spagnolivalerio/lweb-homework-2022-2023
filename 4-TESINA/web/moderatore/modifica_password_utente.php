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
          <a class="elem" href="view_bozze.php">Bozze</a>
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
                    if(isset($_SESSION['errore_vecchia_password']) && $_SESSION['errore_vecchia_password'] === "true" ){
                        echo "Vecchia password errata";
                        unset($_SESSION['errore_vecchia_password']);
                    } elseif (isset($_SESSION['nuova_password_unmatch']) && $_SESSION['nuova_password_unmatch'] === "true") {
                        echo "La nuova password non rispetta i requisiti di sicurezza";
                        unset($_SESSION['nuova_password_unmatch']);
                    }elseif (isset($_SESSION['empty_form']) && $_SESSION['empty_form'] === "true") {
                        echo "Compila tutti i campi";
                        unset($_SESSION['empty_form']);
                    }elseif (isset($_SESSION['same_pass']) && $_SESSION['same_pass'] === "true") {
                        echo "Cerca di apportare delle modifiche alla nuova password!";
                        unset($_SESSION['same_pass']);
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
                        echo "Password modificata con successo";
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

        $query = "SELECT * FROM utente WHERE id = " . $id_utente;
        $result = $conn->query($query);
        $row = $result->fetch_assoc();

        echo "          <form class=\"\" action=\"../../lib/modifica_password_utente.php\" method=\"post\">\n";
        echo "                   <input type=\"hidden\" name=\"id_utente\" value=\"" . $id_utente . "\"></input>\n";
        echo "                   <input type=\"hidden\" name=\"username\" value=\"" . $row['username'] . "\"></input>\n";
        echo "                   <label for=\"vecchia_password\">Vecchia Password</label>\n"; 
        echo "                   <input type=\"password\" name=\"vecchia_password\"></input>\n";
        echo "                   <label for=\"nuova_password\">Nuova Password</label>\n";     
        echo "                   <input type=\"password\" name=\"nuova_password\"></input>\n";    
        echo "                   <button type=\"submit\">Modifica</button>\n";
        echo "          </form>\n";

        ?>

       
    </div>
    </div>
    
  </body>

</html>




