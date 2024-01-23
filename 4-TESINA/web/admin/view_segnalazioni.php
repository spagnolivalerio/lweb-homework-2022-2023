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

        
        <?php

        $segnalazioni_progetti = getAllSegnalazioniProgetto($root);
        $numSegnalazioniP = $segnalazioni_progetti->length;

        $segnalazioni_commenti = getAllSegnalazioniCommento($root);
        $numSegnalazioniC = $segnalazioni_commenti->length;


        if($numSegnalazioniP > 0 || $numSegnalazioniC > 0 ){
            echo "      <div class=\"title\">SEGNALAZIONI DA GESTIRE</div>\n";
            echo "        <table class=\"tabella\">\n";
            echo "          <thead>\n";
            echo "            <tr>\n";
            echo "              <th>UTENTE SEGANALATO</th>\n";
            echo "              <th>CONTRIBUTO</th>\n";
            echo "              <th>SEGNALATO IN DATA</th>\n";
            echo "              <th>GESTISCI</th>\n";
            echo "            </tr>\n";
            echo "          </thead>\n";
            echo "          <tbody>\n";

            foreach($segnalazioni_progetti as $segnalazione_progetto){

                $id_segnalazionep = $segnalazione_progetto->getAttribute('id');
                $id_progetto = $segnalazione_progetto->getAttribute('id_progetto');
                $data = $segnalazione_progetto->getAttribute('data_ora');

                $progetto = getProgetto($root, $id_progetto);
                $reported_user = $progetto->getAttribute('username_creator');


                echo "            <tr>\n";
                echo "              <td>". $reported_user ."</td>\n";
                echo "              <td>". $data ."</td>\n";
                echo "              <td>Progetto</td>\n";
                echo "              <td>\n";
                echo "                <form action=\"view.php\" method=\"get\">\n";
                echo "                  <input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\">\n";
                echo "                  <button type=\"submit\">&#128269;</button>\n";
                echo "                </form>\n";
                echo "                <form action=\"../../lib/rimuovere_progetto.php\" method=\"post\">\n";
                echo "                  <input type=\"hidden\" name=\"id_progetto\" value=\"" . $id_progetto . "\">\n";
                echo "                  <button type=\"submit\">Rimuovi Contenuto</button>\n";
                echo "                </form>\n";
                echo "                <form action=\"../../lib/rimuovere_report_progetto.php\" method=\"post\">\n";
                echo "                  <input type=\"hidden\" name=\"id_progetto\" value=\"" . $id_progetto . "\">\n";
                echo "                  <input type=\"hidden\" name=\"id_report\" value=\"" . $id_segnalazionep . "\">\n";
                echo "                  <button type=\"submit\">Elimina il report</button>\n";
                echo "                </form>\n";
                echo "              </td>\n";


                echo "            </tr>\n";
            }

            foreach($segnalazioni_commenti as $segnalazione_commento){

                $id_segnalazionec = $segnalazione_commento->getAttribute('id');
                $id_commento = $segnalazione_commento->getAttribute('id_commento');
                $data = $segnalazione_commento->getAttribute('data_ora');

                $commento = getCommento($root, $id_commento);

                if($commento != null){
                  $reported_user = $commento->getAttribute('commentatore');
                  $id_discussione = $commento->getAttribute('id_discussione');
                  $discussione = getDiscussione($root, $id_discussione);
                  $id_progetto = $commento->getAttribute('id_progetto');

            

                  echo "            <tr>\n";
                  echo "              <td>". $reported_user ."</td>\n";
                  echo "              <td>Commento</td>\n";
                  echo "              <td>". $data ."</td>\n";
                  echo "              <td>\n";
                  echo "                <form action=\"view.php\" method=\"get\">\n";
                  echo "                  <input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\">\n";
                  echo "                  <button type=\"submit\">&#128269;</button>\n";
                  echo "                </form>\n";
                  echo "                <form action=\"../../lib/rimuovere_commento.php\" method=\"post\">\n";
                  echo "                  <input type=\"hidden\" name=\"id_commento\" value=\"" . $id_commento . "\">\n";
                  echo "                  <input type=\"hidden\" name=\"id_discussione\" value=\"" . $id_discussione . "\">\n";
                  echo "                  <input type=\"hidden\" name=\"id_progetto\"  value=\" . $id_progetto . \">\n";
                  echo "                  <button type=\"submit\">Rimuovi Contenuto</button>\n";
                  echo "                </form>\n";
                  echo "                <form action=\"../../lib/rimuovere_report_commento.php\" method=\"post\">\n";
                  echo "                  <input type=\"hidden\" name=\"id_commento\" value=\"" . $id_commento . "\">\n";
                  echo "                  <input type=\"hidden\" name=\"id_report\" value=\"" . $id_segnalazionec . "\">\n";
                  echo "                  <button type=\"submit\">Elimina il report</button>\n";
                  echo "                </form>\n";
                  echo "              </td>\n";


                  echo "            </tr>\n";
                }
              }
        
        echo "          </tbody>\n";
        echo "        </table>\n";                     
        }
        else{
            echo "      <div class=\"title\">NON CI SONO SEGNALAZIONI DA GESTIRE</div>\n";
        }
        ?>

                  








        
      </div>
    </div>
    
  </body>

</html>
