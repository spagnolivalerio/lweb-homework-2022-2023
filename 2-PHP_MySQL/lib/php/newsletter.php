<?php
	session_start();
	require_once('../../res/var/connection.php');

	$conn = connect_to_db($servername, $db_username, $db_password, $db_name);


	$nome = mysqli_real_escape_string($conn, $_POST['nome']);
	$cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if ($nome == NULL || $cognome == NULL || $email == NULL) {
        $_SESSION['fields'] = 'empty'; 
        header('Location: ../../web/newsletter-form.php');
        exit();
      } 

      //Recupero l'id dell'utente che è loggato
      $id_utente = $_SESSION['id_utente'];

      //Controllo se l'utente che sta tentando la registrazione già è iscritto alla newsletter
      $verifica = "SELECT *
                FROM newsletter
                WHERE id_utente = '$id_utente';";
  
      $ver = mysqli_query($conn, $verifica);
  
      if(!$ver) {
          exit();
      }
  
      if(mysqli_num_rows($ver) > 0){
          $_SESSION['esistenza'] = true;                      //la variabile di sessione $_SESSION['esistenza'] = true; sta ad indicarmi che l'utente è già iscritto alla newletter
          header('Location: ../../web/newsletter-form.php');
          exit();
      }

      //Controllo che l'email scritta non sia già presente nella tabella newsletter
	$query = "SELECT *
			  FROM newsletter
			  WHERE email = '$email';";

	$rows = mysqli_query($conn, $query);

	if(!$rows) {
		exit();
	}


    if(mysqli_num_rows($rows) > 0){
        $_SESSION['registrazione'] = false;                 //la variabile di sessione $_SESSION['registrazione'] = false;  sta ad indicarmi che l'email inserita già è iscritta 
        header('Location: ../../web/newsletter-form.php');
        exit();
    }


    $_SESSION['nome'] = "$nome";


    $insert = "INSERT INTO newsletter (id_utente, nome, cognome, email) VALUES ('$id_utente', '$nome', '$cognome', '$email');";

    mysqli_query($conn, $insert);
    header('Location: ../../web/conferma-newsletter.php');
   	exit();



	$conn->close();

?>