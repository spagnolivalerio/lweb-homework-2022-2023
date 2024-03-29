
<?php

session_start();
require_once('../../lib/functions.php');
require_once('../../lib/get_nodes.php');

$tps_root = "../../";
$id_bozza = $_SESSION['id_bozza'];
$tutorial_bozza = getTutorialBozza($tps_root, $id_bozza);
$path = "index.php"; 
$std = "standard";     
$steps = $tutorial_bozza->childNodes;
if($steps->length < 1){
  header('Location: form_step.php');
  exit;
} 

if(isset($_GET['num_step'])){
  $num_step = $_GET['num_step'];
} else {
  $num_step = 0; 
}

$step = $steps->item($num_step);
addressing($_SESSION['Tipo_utente'], $std, $path);

$logout = $tps_root . "lib/logout.php?ban=true";
addressing($_SESSION['ban'], 0, $logout);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" ></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/progetti.css" ></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/anteprima_tutorial.css" ></link>


  </head>

  <body>

    <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione">
          
        </div>
        <div class="homepage-sidebar-list">
          <a class="elem" href="homepage.php">Homepage</a>
          <a class="elem" href="bacheca.php">Profilo</a>
          <a class="elem" href="view_bozze.php">Bozze</a>
          <a class="elem" href="view_storico.php">Storico</a>
          <div class="divisore"></div>
          <a class="elem" href="../../lib/logout.php">Logout</a>
        </div>
      </div>
      <div class="dashboard">
        <div class="toolbar"></div>

        <div class="title-add-tutorial"><h2>AGGIUNGI TUTORIAL</h2></div>
        <div id="error">
                <?php 
                    if(isset($_SESSION['empty_form']) && $_SESSION['empty_form'] === "true" ){
                        echo "Compila tutti i campi";
                        unset($_SESSION['empty_form']);
                    }elseif(isset($_SESSION['zero_step']) && $_SESSION['zero_step'] === "true" ){
                        echo "Stai tentando di pubblicare un progetto senza tutorial, pubblica almeno uno step!";
                        unset($_SESSION['zero_step']);
                    }

                ?>
          </div>
            <script type="text/javascript">
                function scomparsa() {
                    var error = document.getElementById('error');
                    if (error) {
                        error.style.display = "none";
                    }
                }
                setTimeout(scomparsa, 4000);
            </script>

<?php
                $img_path = $step->getAttribute('nome_file_img');
                $descrizione_step = $step->getElementsByTagName('descrizione')->item(0)->nodeValue;
                $titolo_step = $step->getAttribute('titolo_step');

                echo "<div class=\"anteprima_box\">";
          
                  echo"<div class=\"insert_before\">";
                      echo "<form class=\"insert_form\" method=\"post\" action=\"form_step.php\">";
                        echo "<div class=\"nascondi\"><input type=\"hidden\" name=\"num_step\" value=\"$num_step\"></input></div>";
                        echo "<div><button type=\"submit\">AGGIUNGI PRIMA</button></div>";
                      echo "</form>";
                  echo"</div>"; //chiusura insert_before

                  echo "<div class=\"step step-anteprima\">\n";
                  echo "    <div class=\"step-container\">\n";
                  echo "        <div class=\"step-content\">\n";
                  echo "            <div class=\"step-img\" style=\"background-image: url('../../$img_path'); background-size: cover; background-position: center;\"></div>\n";
                  echo "            <div class=\"descrizione\">\n";
                  echo "                <div class=\"fase\"><h4>".$titolo_step." - STEP " . $num_step+1 . "</h4></div>\n";
                  echo "                <div class=\"testo\">$descrizione_step</div>\n";
                  echo "            </div>\n";
                  echo "        </div>\n";
                  echo "        <form action=\"" . $tps_root . "lib/forward_numstep.php?anteprima=true\" method=\"post\">\n";
                  echo "        <div class=\"nascondi\"><input type=\"hidden\" value=\"$num_step\" name=\"num_step\"></input></div>\n";
                  echo "        <div class=\"move-button\">\n";

                  if($num_step == 0){
                      echo "            <div class=\"left\"></div>\n";
                  } else{
                      echo "            <button class=\"left l\" name=\"action\" value=\"prev\" type=\"submit\">&#129184; Prev</button>\n";
                  }

                  if($step->nextSibling){
                      echo "            <button class=\"right r\" name=\"action\" value=\"next\" type=\"submit\">Next &#129185;</button>\n";
                  } else{
                      echo "            <div class=\"right\"></div>\n";
                  }

                  echo "        </div>\n";
                  echo "        </form>\n";
                  echo " </div>";
                  echo " </div>";

                  echo"<div class=\"insert_after\">";
                    echo "<form class=\"insert_form\" method=\"post\" action=\"form_step.php\">";
                        echo "<div class=\"nascondi\"><input type=\"hidden\" name=\"num_step\" value=\"". $num_step+1 ."\"></input></div>";
                        echo "<div><button type=\"submit\">AGGIUNGI DOPO</button></div>";
                    echo "</form>";
                  echo"</div>"; //chiisura insert_after

                echo "</div>"; //chiusura anteprima_box
    ?>


<?php

$numero_step = $steps->length;

if($numero_step !== 0){

  echo "<form action=\"../../lib/progetto.php\" method=\"post\" class=\"pubblica-form\">\n";
  echo "    <div class=\"ante-box\"><button type=\"submit\">PUBBLICA</button></div>\n";
  echo "</form>\n";
  echo " <form class=\"pubblica-form\" action=\"../../lib/elimina_step.php\" method=\"post\">\n";
  echo "    <div class=\"nascondi\"><input type=\"hidden\" name=\"num_step\" value=\"$num_step\"></input></div>";
  echo "    <div class=\"ante-box\"><button class=\"elimina-step\" type=\"submit\">ELIMINA STEP</button></div>\n";
  echo " </form>\n";
  echo " <form class=\"salva-form\" action=\"view_bozze.php\" method=\"post\">\n";
  echo "    <div class=\"ante-box\"><button class=\"salva-in-bozza\" type=\"submit\">SALVA IL PROGETTO COME BOZZA</button></div>\n";
  echo " </form>\n";
  
}

?>
</div>
</div>
</body>
</html>







