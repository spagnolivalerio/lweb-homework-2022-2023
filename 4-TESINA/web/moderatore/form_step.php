
<?php

session_start();
require_once('../../lib/functions.php');

$path = "index.php"; 
$mod = "moderatore";     
addressing($_SESSION['Tipo_utente'], $mod, $path);
require_once('../../lib/functions.php');


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
          <a class="elem" href="view_bozze.php">Bozze</a>
          <a class="elem" href="view_storico.php">Storico</a>
          <div class="divisore"></div>
          <a class="elem" href="../../lib/logout.php">Logout</a>
        </div>
      </div>
      <div class="dashboard">
      <div class="bar"></div>
        <div class="toolbar"></div>

        <div class="title">AGGIUNGI TUTORIAL</div>
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
            <script>
                function scomparsa() {
                    var error = document.getElementById('error');
                    if (error) {
                        error.style.display = "none";
                    }
                }
                setTimeout(scomparsa, 4000);
            </script>

<form action="../../lib/step.php" method="post" enctype="multipart/form-data">

    <label for="descrizione">Descrizione:</label>
    <textarea name="descrizione" ></textarea><br>

    <label for="num_step">step</label>
    <textarea name="num_step" ></textarea><br>

    <label for="img">10</label>
    <input type="file" name="img" accept="image/*" ></input><br>

    <input type="submit" value="Aggiungi step">

</form>



<?php

$id_bozza = $_SESSION['id_bozza'];
$xmlFile = "../../data/xml/bozze.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$xpath = new DOMXPath($doc); 


$bozSteps = $xpath->query("/bozze/bozza[@id = '$id_bozza']/tutorial_bozza")->item(0)->childNodes; 

$numero_step = 0;

foreach($bozSteps as $bozzaStep){
    $numero_step++;
}

if($numero_step !== 0){
  echo "<form action=\"../../lib/progetto.php\" method=\"post\">\n";
  echo "    <button type=\"submit\">PUBBLICA</button>\n";
  echo "</form>\n";
  
}

?>
</body>
</html>







