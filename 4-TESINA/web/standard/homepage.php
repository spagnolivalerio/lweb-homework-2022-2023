<?php
    session_start();   
    $root = "../../";
    require_once($root . "lib/get_nodes.php");

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/standard/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css" />

  </head>

  <body>

    <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione">
          <div class="logo">TPS</div>
        </div>
        <div class="homepage-sidebar-list">
          <a class="elem">Homepage</a>
          <a class="elem">Progetti</a>
          <a class="elem">Bozze</a>
          <a class="elem">Storico</a>
          <div class="divisore"></div>
          <a class="elem">Logout</a>
        </div>
      </div>
      <div class="dashboard">
        <div class="toolbar"></div>
        <div class="cards">
            <?php

              $progetti = getProgetti($root);

              foreach($progetti as $progetto){

                $titolo = $progetto->getElementsByTagName('titolo')->item(0)->nodeValue;
                $descrizione = $progetto->getElementsByTagName('descrizione')->item(0)->nodeValue;
                $username = $progetto->getAttribute('username_creator');
                $img_path = "../" . $progetto->getAttribute('nome_file_img');
                $id_progetto = $progetto->getAttribute('id');

                echo "<div class=\"card-container\">\n";
                  echo "<div class=\"card-header\" style=\"background-image: url('$img_path'); background-size: cover; background-position: center;\">\n";
                    echo "<div class=\"card-user\">&#x1F464; $username</div>\n";
                  echo "</div>\n";
                  echo "<div class=\"card-footer\">\n";
                    echo "<div class=\"flexbox1\">\n";
                      echo "<div class=\"card-titolo\">$titolo</div>\n";
                      echo "<div class=\"card-rating\">rating</div>\n";
                    echo"</div>\n";
                    echo "<div class=\"flexbox2\">\n";
                      echo "<div class=\"card-descrizione\">$descrizione</div>\n";
                      echo "<form class=\"card-commenta\" action=\"view-discussuioni.php\" method=\"post\"><input class=\"submit\" type=\"submit\" value=\"DISCUSSIONI\"></input>\n";
                        echo "<input class=\"hidden\" type=\"hidden\ value=\"$id_progetto\">\n";
                      echo "</form>\n";
                    echo "</div>\n";
                  echo "</div>\n";
                echo "</div>\n";
              }
           ?>
        </div>
      </div>
    </div>
  </body>

</html>

</html>