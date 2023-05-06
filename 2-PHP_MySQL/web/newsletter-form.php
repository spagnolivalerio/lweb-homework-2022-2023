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

      <title>S&amp;S newsletter</title>
      <?php 

        if(!isset($_COOKIE['dark-mode']) || $_COOKIE['dark-mode'] === 'false'){
          echo"
              <link rel=\"stylesheet\" href=\"../res/css/global/header.css\" type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/newsletter/body.css\"   type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/global/footer.css\" type=\"text/css\" />";
        } elseif(isset($_COOKIE['dark-mode']) && $_COOKIE['dark-mode'] === 'true'){
          echo"
              <link rel=\"stylesheet\" href=\"../res/css/global/dark-theme/dark-header.css\" type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/newsletter/dark-theme/dark-body.css\"   type=\"text/css\" />
              <link rel=\"stylesheet\" href=\"../res/css/global/dark-theme/dark-footer.css\" type=\"text/css\" />";
        }

      ?>

  </head>

   <body>

     <div id="select-menu"><a href="#hidden-menu">&#x2630;</a></div>
      <div><span id="back-target"></span></div>
      <div id="hidden-menu">
        <ul>
          <li><a href="homepage.php" id="homepage">HOMEPAGE</a></li>
          <li>SERVIZI FINANZIARI</li>
          <li>USATO GARANTITO</li>
          <li><a href ="noleggio.php">PRENOTA UN NOLEGGIO</a></li>
          <li>IMPOSTAZIONI</li>
          <li><a href="newsletter-form.php">NEWSLETTER</a></li>
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
              <input type="hidden" name="page" value="newsletter-form">
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

      <?php
          if(isset($_SESSION['nome'])){
            //allora significa che già sono iscritto(va gestito)
          }
      
      ?>

      <div class="title">
        <h1>UNISCITI A NOI</h1>
        <h3>Compila il form e mantieniti aggiornato</h3>
      </div>

        <form class="form" method="post" action="../lib/php/newsletter.php">

        <?php
          if(isset($_SESSION['registrazione']) && $_SESSION['registrazione'] === false){
          $invalid_signup = 'e-mail già esistente';
            echo "<p class=\"errors\">$invalid_signup</p>";
            unset($_SESSION['registrazione']);
          }
        ?>

        <?php
          if(isset($_SESSION['esistenza']) && $_SESSION['esistenza'] === true){
          $invalid_signup = 'profilo già registrato alla newsletter';
            echo "<p class=\"errors\">$invalid_signup</p>";
            unset($_SESSION['esistenza']);
          }
        ?>

        <?php
          if(isset($_SESSION['fields']) && $_SESSION['fields'] === 'empty'){
            $missed_field = "&#x26A0; compila tutti i campi prima di procedere.";
            echo "<script>

                  function go_away(id){
                    var error = document.getElementById(id);
                    error.style.display = \"none\";
                  }

                  setTimeout(function() { go_away(\"missed-field\"); }, 5000);

                </script>

                <div class=\"errors\">$missed_field</div>";
                
                unset($_SESSION['fields']);
          }
        ?>
          <div class="form-item">
            <label for="email">e-mail:</label><br />
            <input type="text" id="email" name="email"></input>
          </div>
          <div class="form-item">
            <button type="submit" id="invia">INVIA</button>
          </div>
        </form>

     <!--FOOTER-->
     
      <div class="footer" id="contatti">
      <div class="grid-item" id="grid-item-1">
        <h3>SIAMO QUI PER TE</h3>
        <p>S&amp;S Motors nasce per offrirti le migliori autovetture sul mercato a prezzi imbattibili. <br />
        Proproniamo anche diversi servizi come noleggio auto o finaziamenti a tasso 0.<br />
        Non perderti le nostre prossime offerte e iscriviti alla <a href="newsletter-form.html">newsletter</a>.</p>
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