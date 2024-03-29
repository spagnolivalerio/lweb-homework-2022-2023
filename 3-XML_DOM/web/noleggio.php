<?php

  session_start();
  require_once('../lib/DOM/stampaAuto.php');

?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>S&amp;S noleggio</title>
      <?php 

        if(!isset($_COOKIE['dark-mode']) || $_COOKIE['dark-mode'] === 'false'){
          echo"
              <link rel=\"stylesheet\" href=\"../res/css/global/header.css\" type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/noleggio/body.css\"   type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/global/footer.css\" type=\"text/css\" />";
        } elseif(isset($_COOKIE['dark-mode']) && $_COOKIE['dark-mode'] === 'true'){
          echo"
              <link rel=\"stylesheet\" href=\"../res/css/global/dark-theme/dark-header.css\" type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/noleggio/dark-theme/dark-body.css\"   type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/global/dark-theme/dark-footer.css\" type=\"text/css\" />";
        }

      ?>

  </head>

  <body>

    <div id="header">
      <div id="title"><img src="../img/logoS_S.png" alt=" "></img></div>
    </div>
    <div class ="mainmenu">
        <ul>
          <li><a href ="dove_siamo.php">DOVE SIAMO</a></li>
          <li><a href ="homepage.php">HOMEPAGE</a></li>
          <?php
            if(isset($_SESSION['tipo_utente']) && $_SESSION['tipo_utente'] === 'cliente'){
              echo "<li><a href=\"i-miei-noleggi.php\">I MIEI NOLEGGI</a></li>";
            }
          ?>
          <li><a href ="#contatti">CONTATTI</a></li>
        </ul>
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

          <?php
            if(isset($_SESSION['tipo_utente'])){
              $nome_utente = $_SESSION['nome_utente'];
              echo "<li style=\"color: #FF6600;\">$nome_utente</li>
                    <li><a href=\"../lib/php/logout.php\">LOGOUT</a></li>";
            } else {
              echo "<a href=\"login.php\" style=\"color: #FF6600;\"><li>ACCEDI</li></a>";
            }
          ?>

          <form method="post" action="../lib/php/dark-mode.php">
             <li>
              <input type="hidden" name="page" value="noleggio">
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

     <!--BODY-->

      <div class="box">

       <?php
  
          print_auto();

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