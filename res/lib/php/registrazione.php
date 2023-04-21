<?php 

    require('../var/db.php');

    $conn = new mysqli($servername, $db_username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

    if(isset($_POST['submit'])) {

        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);

        if($nome==NULL || $cognome==NULL || $username==NULL) {
          die("Compila tutti i campi!");
        }
        
        else{

          $query = "INSERT INTO utente (nome, cognome, username) VALUES ('$nome','$cognome','$username')";

          if(!mysqli_query($conn,$query)) {
            die ("Errore nell'inserimento dei dati: " . mysqli_error($conn));
          } 
        }
      }

      header(Location: '../../web/login.html');
      
      $conn->close();

?>