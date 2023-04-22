<?php 

    require('../../var/db.php');

    $conn = new mysqli($servername, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if ($nome == NULL || $cognome == NULL || $username == NULL || $password == NULL) {
      die("Compila tutti i campi!");
      header('Location: ../../../web/registrazione.html');
      exit(1);
    } else {

      $query = "INSERT INTO utente (username, password, nome, cognome) VALUES ('$username', '$password', '$nome','$cognome')";

      if(!mysqli_query($conn,$query)) {
        die ("Errore nell'inserimento dei dati: " . mysqli_error($conn));
        exit(1);
      } else{ 
        header('Location: ../../../web/login.html ');     
      }
    }

  $conn->close();

?>