<?php
  session_start();
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
      <div id="title"><img src="../img/logoS_S.png" alt=" "></img></div>
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
          <li>ACCOUNT</li>
          <li>IMPOSTAZIONI</li>
          <li>NEWSLETTER</li>
          <li>FAQ</li>
        </ul>
        <div id="back"><a href="#back-target">&#x2715;</a></div>
     </div>

     <!--BODY-->

     <div class="auto-da-noleggiare first-auto">
      <a href="#" class="gallery">GALLERIA</a>
      <div class="flexbox-container">
       <div class="flexbox">
          <p class="car-name">BMW <span class="bold-text">SERIE 3 BERLINA</span></p>
          <button class="noleggio-button">NOLEGGIA ORA</button>
          <p class="description">La BMW SERIE 3 BERLINA &egrave; il nostro fiore all&#180;occhiello! Prova subito su strada i suoi 551 cv di potenza! Mi raccomando per&ograve; di rispettare i limiti di velocit&agrave; e di non far mangiare troppa polvere a chi ti sta dietro.</p>
       </div>
      </div>
     </div>

     <div class="auto-da-noleggiare second-auto">
      <a href="#" class="gallery">GALLERIA</a>
      <div class="flexbox-container">
        <div class="flexbox">
          <p class="car-name">AUDI <span class="bold-text">A3 BERLINA</span></p>
          <button class="noleggio-button">NOLEGGIA ORA</button>
          <p class="description">Prova subtio L&#180;AUDI A3 BERLINA, una vettura elegante e sportiva che unisce la sofisticatezza del design Audi con prestazioni eccezionali. Godi della comodità che solo i marchi tedeschi possono donarti.</p>
        </div>
      </div>
     </div>

     <div class="auto-da-noleggiare third-auto">
      <a href="#" class="gallery">GALLERIA</a>
      <div class="flexbox-container">
        <div class="flexbox">
          <p class="car-name">FORD <span class="bold-text">SUPER DUTY</span></p>
          <button class="noleggio-button">NOLEGGIA ORA</button>
          <p class="description">Il FORD SUPER DUTY &egrave; il pickup leggendario che ha conquistato l&#180;America con la sua potenza e affidabilit&agrave;. Con il suo design imponente e la sua capacit&agrave; di traino eccezionale &egrave; il compagno ideale per qualsiasi sfida e avventura.</p>
       </div>
      </div>
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