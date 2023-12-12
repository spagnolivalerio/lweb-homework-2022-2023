<?php
    session_start();   
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    $username = $_SESSION['username'];

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

    <div class ="mainmenu">
        <ul>
          <li><a href ="dove_siamo.php">DOVE SIAMO</a></li>
          <li><a href ="noleggio.php">NOLEGGIO</a></li>
          <li><a href ="#contatti">CONTATTI</a></li>
        </ul>
    </div>

     <div class="personal-area">
        <div class="slot slot2"><a>&#128269;</a></div>
        <div class="slot slot1"><a><?php echo "$username"; ?></a></div>
    </div>
      
      <div id="select-menu"><a href="#hidden-menu">&#x2630;</a></div>
      <div><span id="back-target"></span></div>
      <div id="hidden-menu">
        <ul>
          <li>SERVIZI FINANZIARI</li>
          <li>USATO GARANTITO</li>
          <li><a href ="noleggio.php">PRENOTA UN NOLEGGIO</a></li>
          <li>IMPOSTAZIONI</li>
          <li>FAQ</li>
  
          <form method="post" action="../lib/php/dark-mode.php">
            <li>
              <input type="hidden" name="page" value="homepage">
              <input class="dkmd" type="submit" name="dark-mode"
              <?php

                if(!isset($_COOKIE['dark-mode']) || $_COOKIE['dark-mode'] === 'false'){
                  echo "value=\"dark\"";
                } elseif (isset($_COOKIE['dark-mode']) && $_COOKIE['dark-mode'] === 'true'){
                  echo "value=\"light\"";
                }

              ?> >
            
            </input></li>
          </form>
        </ul>
        <div id="back"><a href="#back-target">&#x2715;</a></div>
      </div>
      
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

    <div class="footer" id="contatti"></div>

  </body>

</html>

</html>