<?php
	     session_start();
	     require_once('../../res/var/connection.php');

       if(!isset($_SESSION['tipo_utente'])){
          header('Location: ../../web/login.php');
          exit();
       }

	    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);

      $email = mysqli_real_escape_string($conn, $_POST['email']);


      if(empty($_POST['email'])) {
        $_SESSION['fields'] = 'empty'; 
        header('Location: ../../web/newsletter-form.php');
        exit();
      } 

      //Recupero l'utente che è loggato
      $nome = $_SESSION['nome_cliente'];
      $cognome = $_SESSION['cognome_cliente'];
      $id_utente = $_SESSION['id_utente'];

      //Controllo se l'utente che sta tentando la registrazione già è iscritto alla newsletter
      $verifica_utente = "SELECT *
                          FROM newsletter
                          WHERE id_utente = '$id_utente';";
  
      $user_res = mysqli_query($conn, $verifica_utente);
  
      if(!$user_res){
          exit();
      }
  
      if(mysqli_num_rows($user_res) > 0){
          $_SESSION['esistenza'] = true;
          header('Location: ../../web/newsletter-form.php');
          exit();
      }

      $insert = "INSERT INTO newsletter (id_utente, email) VALUES ('$id_utente', '$email');";

      try{
          mysqli_query($conn, $insert);
          header('Location: ../../web/conferma-newsletter.php');
   	      exit();
      }catch(Exception $e){
          $_SESSION['esistenza'] = true;
          header('Location: ../../web/newsletter-form.php');
          exit();
      }

	    $conn->close();

?>