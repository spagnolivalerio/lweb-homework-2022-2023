<?php
    session_start();   
    include('../../conn.php');
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    $id_utente = $_SESSION['id_utente'];
    $path = "index.php"; 
    $std = "standard";     
    addressing($_SESSION['Tipo_utente'], $std, $path);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/bozze.css" />

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
        <div class="toolbar"></div>
        <div class="cards">

        
        <div class="container">
        <table class="user-list">
            <thead>
                <tr>
                    <th><span>ID</span></th>
                    <th><span>Created</span></th>
                    <th>Tools</th>
                </tr>
            </thead>

        <?php

            $bozze = getBozze($root, $id_utente);


            foreach($bozze as $bozza){

                $id_bozza = $bozza->getAttribute('id');
                $data = $bozza->getAttribute('data_pubblicazione');


                echo "        <tbody>\n";
                echo "            <tr>\n";
                echo "                <td>\n";
                echo "                        <a href=\"#\" class=\"user-link\">" . $id_bozza . "</a>\n";

                echo "                </td>\n";
                echo "                <td>\n";
                echo "                    " . $data . "\n";
                echo "                </td>\n";



                echo "          <td>\n";
                echo "          <form class=\"form-ban\" action=\"../../lib/ricarica_bozza.php\" method=\"post\">\n";
                echo "                   <input type=\"hidden\" name=\"id_bozza\" value=" . $id_bozza . "></input>\n";
                echo "                   <button type=\"submit\">Ricarica</button>\n";
                echo "          </form>\n";
                echo "          </td>\n";


                echo "            </tr>\n";
                echo "        </tbody>\n";
                }
        ?>
        </table>       
        


        </div>
      </div>
    </div>
  </body>

</html>