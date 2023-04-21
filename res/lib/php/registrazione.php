<?php 
    require('../var/db.php');

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $nome = mysqli_real_escape_string($conn, $_POST['nome']);
      $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);

      $sql = "INSERT INTO utente (nome, cognome, email) VALUES ('$nome','$cognome','$email')";

      if(!mysqli_query($conn,$query)) {
        die ("Errore nell'inserimento dei dati: " . mysqli_error($conn));
      } 

      header(Location: '../../web/login.html');
      

$conn->close();



?>