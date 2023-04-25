<?php
  session_start();
  require('../res/var/sql_noleggio.php');
  require('../res/var/db.php');
  require('../lib/php/fun.php');

  $conn = new mysqli($servername, $db_username, $db_password, $db_name);

  unset($_SESSION['id_auto']);
  
?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>S&amp;S noleggio</title>
      <link rel="stylesheet" href="../res/css/global/header.css" type="text/css" />
      <link rel="stylesheet" href="../res/css/noleggio/body.css"   type="text/css" />
      <link rel="stylesheet" href="../res/css/global/footer.css" type="text/css" />

  </head>

  <body>

    <div id="header">
      <div id="title"><img src="http://localhost/projects/repository-linguaggi/img/logoS_S.png" alt=" "></img></div>
    </div>
    <div class ="mainmenu">
        <ul>
          <li><a href ="dove_siamo.php">DOVE SIAMO</a></li>
          <li><a href ="homepage.php">HOMEPAGE</a></li>
          <li><a href ="#contatti">CONTATTI</a></li>
        </ul>
     </div>
      <div id="select-menu"><a href="#hidden-menu">&#x2630;</a></div>
      <div><span id="back-target"></span></div>
      <div id="hidden-menu">
        <ul>
          <li>SERVIZI FINANZIARI</li>
          <li>USATO GARANTITO</li>
          <li>PRENOTA UN NOLEGGIO</li>

          <?php
            if(isset($_SESSION['tipo_utente'])){
              $nome_utente = $_SESSION['nome_utente'];
              echo "<li style=\"color: #FF6600;\">$nome_utente</li>";
            } else {
              echo "<a href=\"login.php\" style=\"color: #FF6600;\"><li>ACCEDI</li></a>";
            }
          ?>

          <li>IMPOSTAZIONI</li>
          <li>NEWSLETTER</li>
          <li>FAQ</li>
        </ul>
        <div id="back"><a href="#back-target">&#x2715;</a></div>
     </div>

     <!--BODY-->

      <div class="box">

       <?php

        $result = mysqli_query($conn, $auto_noleggio);

        if(mysqli_num_rows($result) > 0){
  
          print_auto($result);

        } else {
          echo "<span>NON CI SONO MACCHINE DISPONIBILI PER IL NOLEGGIO</span>";
        }

        $conn->close();

       ?>
      </div>

     <div class="footer" id="contatti">
      <div class="grid-item" id="grid-item-1">
        <h3>SIAMO QUI PER TE</h3>
        <p>S&amp;S Motors nasce per offrirti le migliori autovetture sul mercato a prezzi imbattibili. <br />
        Proproniamo anche diversi servizi come noleggio auto o finaziamenti a tasso 0.<br />
        Non perderti le nostre prossime offerte e iscriviti alla newsletter.</p>
        <img src="../img/payment.jpg" alt="payment-methods" class="payment"></img>
      </div>
      <div class="grid-item" id="grid-item-2">
        <h3>CONTATTI</h3>
        <ul>
          <li><span class="social">k</span>  sands@motors.it</li>
          <li><span class="social">L</span>  333.3333333</li>
          <li><span class="social">m</span>  06.0000000</li>
          <li><a href="https://goo.gl/maps/fxjQaQMvub5emHyo9"><span class="social social-transition">9</span></a></li>
        </ul>
      </div>
      <div class="grid-item" id="grid-item-3">
        <h3>SOCIAL</h3>
        <ul>
          <li><span class="social social-transition">E</span></li>
          <li><span class="social social-transition">Q</span></li>
          <li><a href="https://github.com/danielesiciliano/repository-linguaggi.git"><span class="social social-transition">)</span></a></li>
        </ul>
      </div>
    </div>

  </body>
</html>