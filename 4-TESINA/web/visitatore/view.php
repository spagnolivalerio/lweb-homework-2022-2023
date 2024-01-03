<?php 
    session_start();
    $root = "../../";
    require_once($root . 'conn.php');
    require_once($root . "lib/get_nodes.php");
    require_once($root . "lib/functions.php");


    if (!isset($_POST['id_progetto']) && (isset($_GET['id_progetto']) ) ) {
      $id_progetto = $_GET['id_progetto'];
    } elseif(!empty($_POST['id_progetto'])) {
      $id_progetto = $_POST['id_progetto'];
    }elseif(!isset($_POST['id_progetto']) && !isset($_GET['id_progetto'])){
      header("Location: ../index.php" );
    }


    $discussioni = getDiscussioni($root, $id_progetto);
    $steps = getSteps($root, $id_progetto);

    if(empty($steps)){
      exit; 
    } 

    if(!empty($_GET['num_step'])){
      $num_step = $_GET['num_step'];
    } else {
      $num_step = 0; 
    }

    $step = $steps->item($num_step);
    $descrizione_step = $step->getElementsByTagName('descrizione')->item(0)->nodeValue; 
    $img_path = $step->getAttribute('nome_file_img');

    $progetto = getProgetto($root, $id_progetto);
    $id_creator = $progetto->getAttribute('id_creator');



    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
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

              echo "<div class=\"step\">\n";
              echo "    <div class=\"step-container\">\n";
              echo "        <div class=\"step-content\">\n";
              echo "            <div class=\"step-img\" style=\"background-image: url('../../$img_path'); background-size: cover; background-position: center;\"></div>\n";
              echo "            <div class=\"descrizione\">\n";
              echo "                <div class=\"fase\"><h4>STEP " . $num_step+1 . "</h4></div>\n";
              echo "                <div class=\"testo\">$descrizione_step</div>\n";
              echo "            </div>\n";
              echo "        </div>\n";
              echo "        <form action=\"" . $root . "lib/forward_numstep.php\" method=\"post\">\n";
              echo "        <input type=\"hidden\" value=\"$num_step\" name=\"num_step\"></input>\n";
              echo "        <input type=\"hidden\" value=\"$id_progetto\" name=\"id_progetto\"></input>\n";
              echo "        <div class=\"move-button\">\n";
              if($num_step === 0){
                  echo "            <div class=\"left\" type=\"submit\"></div>\n";
              } else{
                  echo "            <button class=\"left l\" name=\"action\" value=\"prev\" type=\"submit\">&#129184; Prev</button>\n";
              }

              if($step->nextSibling){
                  echo "            <button class=\"right r\" name=\"action\" value=\"next\" type=\"submit\">Next &#129185;</button>\n";
              } else{
                  echo "            <div class=\"right\" type=\"submit\"></div>\n";
              }
              echo "        </div>\n";
              echo "        </form>\n";

              echo "    </div>\n";
              echo "    <div class=\"options\">";
              echo "    <div class=\"options-title\"><h2>DICCI LA TUA</h2></div>";
              
              echo "  <div class=\"votato\">Accedi per interagire</div>\n";
              
              ?>
  
            <!-- STAMPA DISCUSSIONI -->
      
            <div class="content">

            <?php

              foreach($discussioni as $discussione){

                $id_discussione = $discussione->getAttribute('id');
                $titolo = $discussione->getAttribute('titolo');
                $descrizione = $discussione->getElementsByTagName('descrizione')->item(0)->nodeValue;
                $autore = $discussione->getAttribute('autore');
                $id_autore = $discussione->getAttribute('id_poster');
                $data_ora = $discussione->getAttribute('data_ora');
                $risolta = $discussione->getAttribute('risolta');
                $commenti = getCommenti($root, $id_discussione);




                echo "<div class=\"discussion-container\">\n";
                echo "    <div class=\"discussion-header\" id=\"" . $id_discussione . "\">\n";
                echo "        <h1 class=\"discussion-title\">$titolo</h1>\n";

                
                echo "        <p class=\"discussion-info\">\n";
                echo "            <span>$autore</span>\n";
                echo "            <span class=\"datetime\">$data_ora</span>\n";
                echo "        </p>\n";
                echo "        <p class=\"discussion-text\">$descrizione</p>\n";
                echo "    </div>\n";
                echo "    <div class=\"comment-container\">\n";

                if($risolta == "true"){

                  echo "  <div class=\"risolta\">Discussione risolta</div>\n";

                } 

                echo "        <span class=\"commenti-span\"><h2>COMMENTI</h2></span>\n";

                foreach($commenti as $commento){
                  $commentatore = $commento->getAttribute('commentatore');
                  $testo = $commento->getElementsByTagName('testo')->item(0)->nodeValue; 
                  $data_ora = $commento->getAttribute('data_ora');
                  $id_commento = $commento->getAttribute('id'); 
                  $id_commentatore = $commento->getAttribute('id_commentatore'); 
                 

                echo "        <div class=\"comment\" id=\"" . $id_commento . "\">\n";
                echo "            <div class=\"comment-info\">\n";
                echo "                <span class=\"comment-author\">$commentatore</span>\n";

                echo "                <span class=\"comment-datetime\">$data_ora</span>\n";
                echo "            </div>\n";
                echo "            <div class=\"comment-box\">\n";
                echo "                <p class=\"comment-text\">$testo</p>\n";
                echo "            </div>\n";
                
                echo "    </div>\n";
              }

              echo "    </div>\n"; 
              echo "    </div>\n"; 

            }

            ?>
          </div>
        </div>
    </div>
    
   
  </body>

</html>

