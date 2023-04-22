<?php
  session_start();
?>
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>Login</title>

  </head>

  <body>

    <form method="post" action="http://localhost/projects/repository-linguaggi/res/lib/php/login.php">

       <?php
          if(isset($_SESSION['signup']) && $_SESSION['signup'] === 'valid'){
          $valid_signup = 'Registrazione effettuata con successo! Fai il login con le tue credenziali.';
          echo "<p style=\"color: green;\">$valid_signup</p>";
          }
        ?>

      <div>
        <label for="username">USERNAME</label><br />
        <input type="text" name="username"></input>
      </div>
      <div>
        <label for="username">PASSWORD</label><br />
        <input type="password" name="password"></input>
      </div><br />

      <input type="submit" name="submit"></input>
      
    </form><br />

    <span><a href="registrazione.php">NON HAI UN ACCOUNT?</a></span>
        
  </body>

  </html>