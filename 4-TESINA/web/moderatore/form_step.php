<?php

session_start();
require_once('../../lib/functions.php');

$path = "index.php"; 
$mod = "moderatore";     
addressing($_SESSION['Tipo_utente'], $mod, $path);

if(isset($_POST['num_step'])){
    $num_step = $_POST['num_step'];
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/control/view-dashboard.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/form_step.css" />

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

<form action="../../lib/step.php" method="post" enctype="multipart/form-data" class="form-container">

    <label for="titolo" class="form-label">Titolo:</label>
    <input name="titolo" class="form-text"></input><br>

    <label for="descrizione" class="form-label">Descrizione:</label>
    <textarea name="descrizione" class="form-textarea"></textarea><br>

    <input name="num_step" type="hidden" value="<?php echo"$num_step"; ?>"></input><br>

    <label for="img" class="form-label">Immagine</label>
    <input type="file" name="img" accept="image/*" class="form-file-input"></input><br>

    <input type="submit" value="Aggiungi step" class="form-submit">

</form>
