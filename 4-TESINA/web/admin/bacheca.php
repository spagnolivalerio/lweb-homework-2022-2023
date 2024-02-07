<?php
    session_start();   
    include('../../conn.php');
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    $id_utente = $_SESSION['id_utente'];
    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);

    $path = "index.php"; 
    $adm = "admin";     

    addressing($_SESSION['Tipo_utente'], $adm, $path);

    if (isset($_GET['id_progetto'])) {
      $id_progetto = $_GET['id_progetto'];
    } 

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/profilo.css"></link>

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
          <a class="elem" href="view_storico.php">Storico</a>
          <div class="divisore"></div>
          <a class="elem" href="../../lib/logout.php">Logout</a>
        </div>
      </div>
      <div class="dashboard">
      <div class="bar"></div>
        <div class="toolbar"></div>


        <?php

          $query = "SELECT * FROM utente WHERE id = " . $id_utente;
          $result = $conn->query($query);
          $row = $result->fetch_assoc();         

          echo "<div class=\"container\">\n";

          // Parte Sinistra
          echo "  <div class=\"users-card\">\n";
          echo "    <div class=\"profile-img\">\n";
          echo "      <img src=\"../../img/avatar/" . $row['avatar'] . "\" alt=\"\"></img>\n";
          echo "    </div>\n";

          echo "    <div class=\"profile-name\">\n";
          echo "      <h3>" . $row['username'] . "</h3>\n";
          echo "    </div>\n";

          echo "    <div class=\"profile-type\">\n";
          echo "      <p>Utente " . $row['tipo'] . "</p>\n";
          echo "    </div>\n";

          echo "  </div>\n";

          // Parte Destra
          echo "  <div class=\"profile-info\">\n";

          echo "    <ul>\n";

          echo "      <li>\n";
          echo "        <span class=\"campo\">Full Name:</span>\n";
          echo "        <span class=\"contenuto\">" . $row['nome'] . " " . $row['cognome'] . "</span>\n";
          echo "      </li>\n";

          echo "      <li>\n";
          echo "        <span class=\"campo\">Indirizzo:</span>\n";
          echo "        <span class=\"contenuto\">" . $row['indirizzo'] . "</span>\n";
          echo "      </li>\n";

          echo "      <li>\n";
          echo "        <span class=\"campo\">Email:</span>\n";
          echo "        <span class=\"contenuto\">" . $row['email'] . "</span>\n";
          echo "      </li>\n";

          echo "    </ul>\n";

          
          echo "    <form class=\"form\" action=\"modifica_profilo_utente.php\" method=\"post\">\n";
          echo "    <div class=\"bacheca-box\">\n";
          echo "      <div class=\"nascondi\"><input type=\"hidden\" name=\"id_utente\" value=\"" . $id_utente . "\"></input></div>\n";
          echo "      <button class=\"button-stile\" type=\"submit\">Edit Generalità</button>\n";
          echo "    </div>\n";
          echo "    </form>\n";

          echo "    <form class=\"form\" action=\"modifica_password_utente.php\" method=\"post\">\n";
          echo "    <div class=\"bacheca-box\">\n";
          echo "      <div class=\"nascondi\"><input type=\"hidden\" name=\"id_utente\" value=\"" . $id_utente . "\"></input></div>\n";
          echo "      <button class=\"button-stile\" type=\"submit\">Cambia Password</button>\n";
          echo "    </div>\n";
          echo "    </form>\n";

          echo "  </div>\n";

          echo "</div>\n";

        ?>

         </div>
      </div>
    
  </body>


</html>