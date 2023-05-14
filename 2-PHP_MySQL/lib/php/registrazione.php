<?php 
    session_start();
    require_once('../../res/var/connection.php');

    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);

    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password_crypt = mysqli_real_escape_string($conn, md5($_POST['password']));

    $_SESSION['nome'] = $nome;
    $_SESSION['cognome'] = $cognome;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $_POST['password'];

    if(empty($nome) || empty($cognome) || empty($username) || empty($password)){

      $_SESSION['empty']['empty-name'] = empty($nome);
      $_SESSION['empty']['empty-lastname'] = empty($cognome);
      $_SESSION['empty']['empty-username'] = empty($username);
      $_SESSION['empty']['empty-pwd'] = empty($password_crypt);

      header('Location: ../../web/registrazione.php');

    } else {

      $query = "INSERT INTO utente (username, password, nome, cognome) VALUES ('$username', '$password_crypt', '$nome','$cognome')";

      try{
        if(mysqli_query($conn, $query)){
          session_destroy();
          session_start();
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