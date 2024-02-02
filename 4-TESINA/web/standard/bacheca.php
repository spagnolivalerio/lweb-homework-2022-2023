<?php
    session_start();   
    include('../../conn.php');
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    $id_utente = $_SESSION['id_utente'];
    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);

    $path = "index.php"; 
    $std = "standard";     

    addressing($_SESSION['Tipo_utente'], $std, $path);

    $logout = $root . "lib/logout.php?ban=true";
    addressing($_SESSION['ban'], 0, $logout);



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

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/profilo.css" />

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
          <a class="elem" href="view_bozze.php">Bozze</a>
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

          echo "<div class=\"reputazione\">\n";
          echo "  <p class=\"testo\">Sei al livello ". $row['livello'] ." con ". $row['punti_reputazione'] ." punti reputazione. Continua così!</p>\n";
          echo "</div>\n";

          echo "<div class=\"container\">\n";

          // Parte Sinistra
          echo "  <div class=\"users-card\">\n";
          echo "    <div class=\"profile-img\">\n";
          echo "      <img src=\"../../img/avatar/" . $row['avatar'] . "\" alt=\"\">\n";
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
          echo "      <input type=\"hidden\" name=\"id_utente\" value=" . $id_utente . "></input>\n";
          echo "      <button class=\"button-stile\" type=\"submit\">Edit Generalità</button>\n";
          echo "    </form>\n";
          echo "    <form class=\"form\" action=\"modifica_password_utente.php\" method=\"post\">\n";
          echo "      <input type=\"hidden\" name=\"id_utente\" value=" . $id_utente . "></input>\n";
          echo "      <button class=\"button-stile\" type=\"submit\">Cambia Password</button>\n";
          echo "    </form>\n";
          echo "      <form class=\"form\" action=\"form_progetto.php\" method=\"post\">\n";
          echo "        <button class=\"button-stile\" type=\"submit\">Aggiungi un Progetto</button>\n";
          echo "      </form>\n";

          echo "  </div>\n";

          echo "</div>\n";

          echo "    <div class=\"progetti\">\n";
          echo "      <p class=\"testo\">PROGETTI PUBBLICATI</p>\n";
          echo "    </div>\n";

         
          
          $progetti = getProgetti($root);

          echo "<div class=\"cards\">\n";

          foreach($progetti as $progetto){

            $id_creator = $progetto->getAttribute('id_creator'); 
            
            if($id_creator == $id_utente){

              $titolo = $progetto->getElementsByTagName('titolo')->item(0)->nodeValue;
              $categorie = $progetto->getElementsByTagName('categorie')->item(0); 
              $descrizione = $progetto->getElementsByTagName('descrizione')->item(0)->nodeValue;
              $username = $progetto->getAttribute('username_creator');
              $img_path = $root . $progetto->getAttribute('nome_file_img');
              $id_progetto = $progetto->getAttribute('id'); 
              $avatar = $row['avatar'];  
              $rating = valutazioneProgetto($root, $id_progetto, $conn);
              $durata = $progetto->getAttribute('tempo_medio');
              $difficoltà = $progetto->getAttribute('difficolta');
            
            echo " <div class=\"card-container\">\n";
            echo "  <div class=\"card-header\" style=\"background-image: url('$img_path'); background-size: cover; background-position: center;\">\n";
            echo "   <div class=\"top-card\">\n";
            echo "      <div class=\"intestazione-card\">\n";
            echo "        <img src=\"$root/img/avatar/$avatar\" alt=\"&#x1F464;\" style=\"width: 20px; height: 20px;\"></img>\n";
            echo "        <div class=\"card-user\">$username</div>\n";
            echo "      </div>\n";
            echo "     <form class=\"elimina-progetto\" action=\"../../lib/rimuovere_progetto.php\" method=\"post\">\n";
            echo "       <input class=\"cestino\" type=\"submit\" value=\"&#10005;\">\n";
            echo "       <input class=\"\" name=\"id_progetto\" type=\"hidden\" value=\"$id_progetto\">\n";
            echo "     </form>\n";
            echo "   </div>\n";
            echo "    <div class=\"details\">\n";
            echo "      <div class=\"time\">&#128337;: $durata min</div>\n";
            echo "      <div class=\"difficulty\">Difficolt&agrave;: $difficoltà</div>\n";
            echo "    </div>\n";
            echo "  </div>\n"; 
            echo "  <div class=\"card-footer\">\n";
            echo "    <div class=\"flexbox1\">\n";
            echo "      <div class=\"card-titolo\">$titolo</div>\n";
            echo "      <div class=\"card-rating\">$rating</div>\n";
            
            echo "    </div>\n";
            echo "    <div class=\"flexbox2\">\n";
            echo "      <div class=\"card-descrizione\">$descrizione</div>\n";
            echo "      <form class=\"card-commenta\" action=\"view.php\" method=\"post\">\n";
            echo "        <div class=\"animation\"></div>\n";
            echo "        <button class=\"submit\" type=\"submit\">Dettagli</button>\n";
            echo "        <input class=\"hidden\" name=\"id_progetto\" type=\"hidden\" value=\"$id_progetto\">\n";
            echo "      </form>\n";
            echo "      </div>\n";
            echo "   </div>\n";
            echo "</div>\n";


            }
          }
          echo "</div>\n";


            ?>
         
          

              
      









         </div>
      </div>
    </div>
    
  </body>


</html>