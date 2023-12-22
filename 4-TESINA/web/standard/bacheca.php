<?php
    session_start();   
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
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
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/bacheca.css" />

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
        <div class="bacheca">
            <div class="profilo">
                NOME ACCOUNT
            </div>
            <div class="account-type">tipo account</div>
        </div>
        <div class="feed">
          <a href="form_progetto.php">Pubblica progetto</a>
        </div>
      </div>
    </div>
    
  </body>

</html>

</html>