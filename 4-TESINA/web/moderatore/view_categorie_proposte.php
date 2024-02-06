<?php
    session_start();   
    include('../../conn.php');
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    $id_utente = $_SESSION['id_utente'];
    $path = "index.php"; 
    $mod = "moderatore";     
    addressing($_SESSION['Tipo_utente'], $mod, $path);

    $logout = $root . "lib/logout.php?ban=true";
    addressing($_SESSION['ban'], 0, $logout);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/control/view-dashboard.css"></link>

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

        
        <?php

        $progetti = getProgetti($root);
        $numCategorieProposte = 0;

        foreach($progetti as $progetto){
            if($progetto->getAttribute('sospeso') == 'true'){
                $numCategorieProposte++;
            }
        }
        

        if($numCategorieProposte > 0){
            echo "      <div class=\"title\">CATEGORIE PROPOSTE</div>\n";
            echo "        <table class=\"tabella\">\n";
            echo "          <thead>\n";
            echo "            <tr>\n";
            echo "              <th>CATEGORIA</th>\n";
            echo "              <th>PROPOSTA DALL'UTENTE</th>\n";
            echo "              <th>GESTISCI</th>\n";
            echo "            </tr>\n";
            echo "          </thead>\n";
            echo "          <tbody>\n";

            foreach($progetti as $progetto){

                if($progetto->getAttribute('sospeso') == 'true'){
                    $nomeCategoria = $progetto->getElementsByTagName('categoriaProposta')->item(0)->nodeValue;
                    $user = $progetto->getAttribute('username_creator');
                    $id_progetto = $progetto->getAttribute('id');
                


                echo "            <tr>\n";
                echo "              <td>". $nomeCategoria ."</td>\n";
                echo "              <td>". $user ."</td>\n";
                echo "              <td class=\"interagisci\">\n";
                echo "                <form action=\"../../lib/modifica_sospensione_progetto.php\" method=\"post\">\n";
                echo "                  <div class=\"nascondi\"><input type=\"hidden\" name=\"id_progetto\" value=\"" . $id_progetto . "\"></input></div>\n";
                echo "                  <div class=\"nascondi\"><input type=\"hidden\" name=\"nomeCategoria\" value=\"" . $nomeCategoria . "\"></input></div>\n";
                echo "                  <button class=\"green\" type=\"submit\">&#10004;</button>\n";
                echo "                </form>\n";
                echo "                <form action=\"../../lib/rimuovere_progetto.php\" method=\"post\">\n";
                echo "                  <div class=\"nascondi\"><input type=\"hidden\" name=\"id_progetto\" value=\"" . $id_progetto . "\"></input></div>\n";
                echo "                  <button class=\"red\" type=\"submit\">&#10008;</button>\n";
                echo "                </form>\n";
                echo "              </td>\n";


                echo "            </tr>\n";
                }
            }

        echo "          </tbody>\n";
        echo "        </table>\n";                     
        }
        else{
            echo "      <div class=\"title\">NON CI SONO CATEGORIE PROPOSTE</div>\n";
        }
        ?>

        
      </div>
    </div>
    
  </body>

</html>
