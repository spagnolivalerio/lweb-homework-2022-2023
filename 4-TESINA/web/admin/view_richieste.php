<?php
    session_start();   
    include('../../conn.php');
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    $id_utente = $_SESSION['id_utente'];
    $path = "index.php"; 
    $adm = "admin";   
    addressing($_SESSION['Tipo_utente'], $adm, $path);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

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

        $richieste = getAllRichiesteAccesso($root);
        $counter = getWaitingRequestNumber($root, $richieste);

        if($counter > 0){
            echo "      <div class=\"title\">RICHIESTE DI ACCESSO IN ATTESA DI RISCONTRO</div>\n";
            echo "        <table class=\"tabella\">\n";
            echo "          <thead>\n";
            echo "            <tr>\n";
            echo "              <th>RICHIEDENTE</th>\n";
            echo "              <th>TITOLO DISCUSSIONE</th>\n";
            echo "              <th>RICHIESTO IN DATA</th>\n";
            echo "              <th>GESTISCI</th>\n";
            echo "            </tr>\n";
            echo "          </thead>\n";
            echo "          <tbody>\n";

            foreach($richieste as $richiesta){

                if($richiesta->getAttribute('stato') === 'in lavorazione'){

                    $id_richiesta = $richiesta->getAttribute('id');
                    $id_discussione = $richiesta->getAttribute('id_discussione');
                    $data = $richiesta->getAttribute('data_ora');

                    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);
                    $utente_id = $richiesta->getAttribute('id_utente');
                    $query = "SELECT * FROM utente WHERE id = " . $utente_id;
                    $result = $conn->query($query);
                    $row = $result->fetch_assoc();

                    $discussione = getDiscussione($root, $id_discussione);
                    $titolo = $discussione->getAttribute('titolo');

                    echo "            <tr>\n";
                    echo "              <td>". $row['username'] ."</td>\n";
                    echo "              <td>". $titolo ."</td>\n";
                    echo "              <td>". $data ."</td>\n";
                    echo "              <td>\n";
                    echo "                <form action=\"../../lib/gestisci_richiesta.php\" method=\"post\">\n";
                    echo "                  <input type=\"hidden\" name=\"id_richiesta\" value=\"" . $id_richiesta . "\">\n";
                    echo "                  <button class=\"green\" type=\"submit\" name=\"esito\" value=\"accettata\">&#10004;</button>\n";
                    echo "                  <button class=\"red\" type=\"submit\" name=\"esito\" value=\"rifiutata\">&#10008;</button>\n";
                    echo "                </form>\n";
                    echo "              </td>\n";

                    echo "            </tr>\n";
                }
            }
            echo "          </tbody>\n";
            echo "        </table>\n";                     

        }else{
            echo "      <div class=\"title\">NON CI SONO RICHIESTE IN SOSPESO</div>\n";
        }
        ?>

                  








        
      </div>
    </div>
    
  </body>

</html>
