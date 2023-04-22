<?php
  session_start();
?>
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <link rel="stylesheet" href="../res/css/login/body.css" type="text/css" />

      <title>Login</title>

  </head>

  <body>

       <?php
          if(isset($_SESSION['signup']) && $_SESSION['signup'] === 'valid'){
          $valid_signup = 'Registrazione effettuata con successo! Fai il login con le tue credenziali.';
          echo "<p class=\"success-signup\">$valid_signup</p>";
          }
        ?>

    <form class="form" method="post" action="http://localhost/projects/repository-linguaggi/res/lib/php/login.php">

      <div class="title">
        <h2>LOGIN</h2>
      </div>

      <div class="form-item">
        <label for="username">USERNAME:</label><br />
        <input type="text" name="username"></input>
      </div>
      <div class="form-item">
        <label for="username">PASSWORD:</label><br />
        <input type="password" name="password"></input>
      </div><br />

      <div class="form-item invia">
        <input type="submit" name="submit"></input><br />
      </div>
      
      <div class="form-item non-hai-un-account">
        <a href="registrazione.php">NON HAI UN ACCOUNT?</a>
      </div>

    </form>

        
  </body>

  </html>