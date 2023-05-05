<?php 
    session_start();
    require_once('../../res/var/connection.php');

    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);

    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    if ($nome == NULL || $cognome == NULL || $username == NULL || $password == NULL) {
      $_SESSION['fields'] = 'empty'; 
      header('Location: ../../web/registrazione.php');
      exit();
    } else {

      $query = "INSERT INTO utente (username, password, nome, cognome) VALUES ('$username', '$password', '$nome','$cognome')";

      try{
        if(mysqli_query($conn, $query)){
          $_SESSION['signup'] = true;
          header('Location: ../../web/login.php');
          exit();
        }
      } catch (Exception $e){
          $_SESSION['signup'] = false;
          header('Location: ../../web/registrazione.php');
          exit();
      }
    }
    $conn->close();
?>