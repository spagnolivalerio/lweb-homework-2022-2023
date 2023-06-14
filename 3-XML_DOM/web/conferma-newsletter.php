<?php

  session_start();
  require_once('../res/var/connection.php');

  $conn = connect_to_db($servername, $db_username, $db_password, $db_name);

?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>Conferma Registrazione</title>
      <?php 

        if(!isset($_COOKIE['dark-mode']) || $_COOKIE['dark-mode'] === 'false'){
          echo"
              <link rel=\"stylesheet\" href=\"../res/css/newsletter/newsletter-style.css\" type=\"text/css\" />";
        } elseif(isset($_COOKIE['dark-mode']) && $_COOKIE['dark-mode'] === 'true'){
          echo"
              <link rel=\"stylesheet\" href=\"../res/css/newsletter/dark-theme/dark-newsletter-style.css\" type=\"text/css\" />";
        }

      ?>
  </head>

  <body>
  <div id="title"><img src="../img/logoS_S.png" alt=" "></img></div>
    <div class="blocco">
        <h1>Registrazione completata</h1>
        <ul>
            <li>
                <?php 
                    $_SESSION['newsletter'] = true;
                    echo"". $_SESSION['nome_cliente'] . "";
                ?>
                , Grazie per esserti iscritto alla nostra newsletter.
            </li>
            <li>Resta sintonizzato per non perderti le nostre migliori offerte!</li>
            <li class="bottone"><a href="homepage.php"><span class="icon-home">&#x2302;</span></a></li>
        </ul>
    </div>
  </body>
</html>