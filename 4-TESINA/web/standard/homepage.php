<?php
    session_start();   
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    $id_utente = $_SESSION['id_utente'];

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

      <link type="text/css" rel="stylesheet" href="../../res/css/standard/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/card.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/discussioni.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/progetti.css" />

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
                $valutazioni_progetto = getValutazioniProgetto($root, $id_progetto);
                $voted = already_voted($valutazioni_progetto, $id_utente);

              echo "<div class=\"card-container\">\n";
              echo "  <div class=\"card-header\" style=\"background-image: url('$img_path'); background-size: cover; background-position: center;\">\n";
              echo "    <div class=\"card-user\">&#x1F464; $username</div>\n";
              echo "  </div>\n";
              echo "  <div class=\"card-footer\">\n";
              echo "    <div class=\"flexbox1\">\n";
              echo "      <div class=\"card-titolo\">$titolo</div>\n";
              echo "      <div class=\"card-rating\">rating</div>\n";
              echo "    </div>\n";
              echo "    <div class=\"flexbox2\">\n";
              echo "      <div class=\"card-descrizione\">$descrizione</div>\n";
              echo "      <form class=\"card-commenta\" action=\"view-discussioni.php\" method=\"post\">\n";
              echo "        <input class=\"submit\" type=\"submit\" value=\"DISCUSSIONI\">\n";
              echo "        <input class=\"hidden\" name=\"id_progetto\" type=\"hidden\" value=\"$id_progetto\">\n";
              echo "      </form>\n";
              echo "    </div>\n";
              echo "  </div>\n";

              if($voted){
                echo "  <div class=\"votato\">Contributo già valutato</div>\n";
              }else{
                echo "            <form class=\"form-box\" action=\"../../lib/valutare_progetto.php\" method=\"post\">\n";
                echo "                <div class=\"rating\">\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"5\" id=\"5_$id_progetto\">\n";
                echo "                    <label for=\"5_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"4\" id=\"4_$id_progetto\">\n";
                echo "                    <label for=\"4_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"3\" id=\"3_$id_progetto\">\n";
                echo "                    <label for=\"3_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"2\" id=\"2_$id_progetto\">\n";
                echo "                    <label for=\"2_$id_progetto\">&#9734;</label>\n";
                echo "                    <input type=\"radio\" name=\"rating\" value=\"1\" id=\"1_$id_progetto\">\n";
                echo "                    <label for=\"1_$id_progetto\">&#9734;</label>\n";
                echo "                    <span class=\"type-rating\">Rating</span>\n";
                echo "                </div>\n";
                echo "                <input type=\"hidden\" name=\"id_progetto\" value=\"$id_progetto\"></input>\n";
                echo "                <textarea type=\"text\" name=\"testo\"></textarea>\n";
                echo "                <button type=\"submit\" class=\"valuta\">VALUTA</button>\n";
                echo "            </form>\n";
              }






              echo "</div>\n";

              }

           ?>
        </div>
      </div>
    </div>
  </body>

</html>

</html>