<?php
  session_start();
?>
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>Registrazione</title>

  </head>

  <body>

    <form method="post" action="http://localhost/projects/repository-linguaggi/res/lib/php/registrazione.php">

      <?php
        if(isset($_SESSION['fields']) && $_SESSION['fields'] === 'empty'){
          $missed_field = "compila tutti i campi prima di procedere.";
          echo "<p style=\"color: red;\">$missed_field</p>";
        }
      ?>

      <div>
        <label for="nome">nome</label><br />
        <input type="text" name="nome"></input>
      </div>
      <div>
        <label for="cognome">cognome</label><br />
        <input type="text" name="cognome"></input>
      </div>
      <div>
        <label for="username">username</label>
        <br />
        <input type="text" name="username"></input>

        <?php
          if(isset($_SESSION['signup']) && $_SESSION['signup'] === 'invalid'){
          $error_username = 'username esistente';
          echo "<p style=\"color: red;\">$error_username</p>";
          }
        ?>

      </div>
      <div>
        <label for="password">password</label><br />
        <input type="password" name="password"></input>
      </div><br />

      <input type="submit" name="invia"></input>

    </form><br />

    <span><a href="login.php">HAI GIA UN ACCOUNT?</a></span>
        
  </body>

  </html>