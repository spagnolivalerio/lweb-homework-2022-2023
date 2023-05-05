<?php
  session_start();
?>
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>Registrazione</title>
      <link rel="stylesheet" href="../res/css/registrazione/body.css" type="text/css">

  </head>

  <body>
    <form method="post" action="../lib/php/registrazione.php" class="form">

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

                <div id=\"missed-field\" style=\"color: red;\">$missed_field</div>";
                
                unset($_SESSION['fields']);
        }
      ?>
      <div class="bar">REGISTRAZIONE</div>
      <div class="grid">
        <div class="column">
          <div class="form-item">
            <label for="nome">NOME:</label><br />
            <input type="text" name="nome"></input>
          </div>
          <div class="form-item">
            <label for="cognome">COGNOME:</label><br />
            <input type="text" name="cognome"></input>
          </div>
        </div>
        <div class="column">
          <div class="form-item">
            <label for="username">USERNAME:</label>
            <br />
            <input type="text" name="username"></input>

            <?php
              if(isset($_SESSION['signup']) && $_SESSION['signup'] === 'invalid'){
              $error_username = '&#x26A0; username esistente';
              echo "<script>

                  function go_away(id){
                    var error = document.getElementById(id);
                    error.style.display = \"none\";
                  }

                  setTimeout(function() { go_away(\"missed-field\"); }, 5000);

                </script>

                <div id=\"missed-field\" style=\"color: red;\">$error_username</div>";

                unset($_SESSION['signup']);
              }
            ?>

          </div>
          <div class="form-item">
            <label for="password">PASSWORD:</label><br />
            <input type="password" name="password"></input>
          </div><br />
        </div>
      </div>
      <div class="center">
        <button class="invia" type="submit" name="invia">REGISTRATI</button>
      </div>
      <div class="login"><a href="login.php">HAI GIA UN ACCOUNT?</a></div>

    </form><br />

        
  </body>

  </html>