<?php

session_start();
require_once('../../lib/functions.php');
$tps_root = "../../";
$path = "index.php"; 
$mod = "moderatore";     
addressing($_SESSION['Tipo_utente'], $mod, $path);

$logout = $tps_root . "lib/logout.php?ban=true";
addressing($_SESSION['ban'], 0, $logout);

if(isset($_POST['num_step'])){
    $num_step = $_POST['num_step'];
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/control/view-dashboard.css"></link>
      <link type="text/css" rel="stylesheet" href="../../res/css/form_step.css"></link>

  </head>

  <body>

    <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione">
          
        </div>
        <div class="homepage-sidebar-list">
          <a class="elem" href="homepage.php">Homepage</a>
          <a class="elem" href="bacheca.php">Profilo</a>
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
            <script type="text/javascript">
                function scomparsa() {
                    var error = document.getElementById('error');
                    if (error) {
                        error.style.display = "none";
                    }
                }
                setTimeout(scomparsa, 4000);
            </script>

<form action="../../lib/step.php" method="post" enctype="multipart/form-data" class="form-container">

    <p class="form-label">Titolo:<br />
    <input name="titolo" class="form-text"></input><br /></p>

    <p class="form-label">Descrizione:<br />
    <textarea name="descrizione" class="form-textarea" rows="1" cols="50"></textarea><br /></p>

    <div class="nascondi"><input name="num_step" type="hidden" value="<?php echo"$num_step"; ?>"></input></div>

    <p class="form-label">Immagine<br />
    <input type="file" name="img" accept="image/*" class="form-file-input"></input><br /></p>

    <div><input type="submit" value="Aggiungi step" class="form-submit"></input></div>

</form>
</div>
</div>
</body>
</html>
