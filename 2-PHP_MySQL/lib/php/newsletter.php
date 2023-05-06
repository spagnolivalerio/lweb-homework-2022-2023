<?php
	session_start();
	require_once('../../res/var/connection.php');

	$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

    $email = mysqli_real_escape_string($conn, $_POST['email']);


    if ($email == NULL) {
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


    $info_utente = "SELECT *
                    FROM utente
                    WHERE id = '$id_utente';";

    $result = mysqli_query($conn, $info_utente);

    //Catturo le info dell'utente che si sta iscrivendo alla newsletter per poi utilizzarle nell'inserimento all'interno della tabella newsletter

    if(mysqli_num_rows($result) > 0){
        $_user_row = mysqli_fetch_array($result);
        $nome =  $_user_row['nome'];
	    $cognome = $_user_row['cognome'];
    }



    $_SESSION['nome'] = "$nome";


    $insert = "INSERT INTO newsletter (id_utente, nome, cognome, email) VALUES ('$id_utente', '$nome', '$cognome', '$email');";

    mysqli_query($conn, $insert);
    header('Location: ../../web/conferma-newsletter.php');
   	exit();



	$conn->close();

?>