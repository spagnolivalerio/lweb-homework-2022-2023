<?php 
    session_start();
    require_once("../../lib/get_nodes.php");
    require_once("../../lib/functions.php");
    include('../../conn.php');
    $root="../../";
    $mod = "moderatore";
    $path = "index.php"; 
    addressing($_SESSION['Tipo_utente'], $mod, $path); 
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

    $id_utente = $_SESSION['id_utente'];

    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);
    $query = "SELECT * FROM utente";
    $result = $conn->query($query);


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/discussioni.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/prova.css" />

  </head>

  <body>

        <div class="homepage">
          <div class="homepage-sidebar">
            <div class="intestazione">
              <div class="logo">TPS</div>
            </div>
            <div class="homepage-sidebar-list">
              <a class="elem">Homepage</a>
              <a class="elem">Bacheca</a>
              <a class="elem">Progetti</a>
              <a class="elem">Bozze</a>
              <a class="elem">Storico</a>
              <div class="divisore"></div>
              <a class="elem">Logout</a>
            </div>
          </div>
          <div class="dashboard">
            <div class="toolbar"></div>


            
        <div class="container">
            <!-- Parte Sinistra - Informazioni Utente -->
            <div class="users-section">
                <div class="filtro">
                    <input type="text" id="searchInput" placeholder="&#x1F50D; Cerca per nome">
                </div>

                <?php

                while ($row = mysqli_fetch_assoc($result)){
                    
                echo "          <div class=\"user-info\" onclick=\"redirectToUserPage('view_storico.php?id_utente=" . $row['id'] . "')\">\n";
                echo "              <div class=\"details\">\n";
                echo "                  <img src=\"../../img/avatar/" . $row['avatar'] . "\" alt=\"\">\n";
                echo "                  <p>" . $row['username'] . "</p>\n";
                echo "              </div>\n";
                echo "              <p class=\"user-type\">" . $row['tipo'] . "</p>\n";
                echo "          </div>\n";                   
                }  
                ?>
            </div>  

            <!-- Parte Destra - Lista Attività Utente -->
            <div class="activities">

            <?php

            $utente_id = $id_utente;

            if(isset($_GET['id_utente'])){
                
                $utente_id = $_GET['id_utente'];
            }

            $tabella = 1;

            if(isset($_GET['tipo_tabella'])){
                
                $tabella = $_GET['tipo_tabella'];
            }

            $conn = connect_to_db($servername, $db_username, $db_password, $db_name);
            $query = "SELECT * FROM utente WHERE id = " . $utente_id;
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            $progetti = getStoricoProgetti($root, $utente_id);

            echo "                <div class=\"profile\">\n";
            echo "                    <div class=\"profile-info\">\n";
            echo "                        <img src=\"../../img/avatar/" . $row['avatar'] . "\" alt=\"\">\n";
            echo "                        <p>" . $row['username'] . "</p>\n";
            echo "                    </div>\n";
            echo "                    <div class=\"table-ref\">\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&tipo_tabella=1\">PROGETTI PUBBLICATI</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&tipo_tabella=2\">COMMENTI PUBBLICATI</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&tipo_tabella=3\">DISCUSSIONI APERTE</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&tipo_tabella=4\">VALUTAZIONI PROGETTI</a>\n";
            echo "                            <a href=\"view_storico.php?id_utente=" . $utente_id . "&tipo_tabella=5\">VALUTAZIONI COMMENTI</a>\n";
            echo "                    </div>\n";
            echo "                </div>\n";

            echo "                <div class=\"activity-type\">\n";
            echo "                    <h2>Pubblicazione Progetti</h2>\n";
            echo "                    <table class=\"activity-list\">\n";

            if($tabella == 1){

                echo "                        <tr>\n";
                echo "                            <th>ID progetto</th>\n";
                echo "                            <th>Titolo del Progetto</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

            
                foreach($progetti as $progetto){

                    $id_progetto = $progetto->getAttribute('id_progetto');
                    $titolo = $progetto->getAttribute('titolo');

                    echo "                        <tr>\n";
                    echo "                            <td>" . $id_progetto . "</td>\n";
                    echo "                            <td>" . $titolo . "</td>\n";
                    echo "                            <td>2023-01-01</td>\n";
                    echo "                        </tr>\n";
                }
            }elseif($tabella == 2){

                echo "                        <tr>\n";
                echo "                            <th>ID commento</th>\n";
                echo "                            <th>Testo del commento</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

            
                foreach($commenti as $commento){


                    echo "                        <tr>\n";
                    echo "                            <td></td>\n";
                    echo "                            <td></td>\n";
                    echo "                            <td>2023-01-01</td>\n";
                    echo "                        </tr>\n";
                }
            }elseif($tabella == 3){

                echo "                        <tr>\n";
                echo "                            <th>ID discussione</th>\n";
                echo "                            <th>Titolo del commento</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

            
                foreach($discussioni as $discussioni){


                    echo "                        <tr>\n";
                    echo "                            <td></td>\n";
                    echo "                            <td></td>\n";
                    echo "                            <td>2023-01-01</td>\n";
                    echo "                        </tr>\n";
                }
            }elseif($tabella == 4){

                echo "                        <tr>\n";
                echo "                            <th>ID commento</th>\n";
                echo "                            <th>Titolo del commento</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

            
                foreach($valprogetti as $valprogetto){


                    echo "                        <tr>\n";
                    echo "                            <td></td>\n";
                    echo "                            <td></td>\n";
                    echo "                            <td>2023-01-01</td>\n";
                    echo "                        </tr>\n";
                }
            }elseif($tabella == 5){

                echo "                        <tr>\n";
                echo "                            <th>ID commento</th>\n";
                echo "                            <th>Titolo del commento</th>\n";
                echo "                            <th>Data di Pubblicazione</th>\n";
                echo "                        </tr>\n";

            
                foreach($valcommenti as $valcommento){


                    echo "                        <tr>\n";
                    echo "                            <td></td>\n";
                    echo "                            <td></td>\n";
                    echo "                            <td>2023-01-01</td>\n";
                    echo "                        </tr>\n";
                }
            }


            echo "                    </table>\n";
            echo "                </div>\n";
        
?>


                </div>
            </div>
        </div>



        <script>
            function redirectToUserPage(url) {
                window.location.href = url;
            }
        </script>

        
          </div>
        </div>
    </div>
  </body>

</html>

</html>