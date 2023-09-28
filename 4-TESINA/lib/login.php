<?php

	session_start();
	require_once('../conn.php');

	$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

	if(!empty($_POST['username']) && !empty($_POST['password'])){ //isset controlla se le variabili sono state settate, e si settano appena invii i dati con POST. Per controllare se i dati sono vuoti si usa empty();
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
	} else {
		$_SESSION['credenziali'] = "false";
		header('Location: ../web/login.php');
		exit();
	}

	$password = md5($password);

	$query = "SELECT *
			  FROM utente
			  WHERE username = '$username'
			  AND password = '$password'"; //in sql i valori delle stringhe vanno in apici, le variabili sono intepretate dalle virgolette "";

	$rows = mysqli_query($conn, $query);

	if(!$rows){
		header('Location: ../web/login.php');
		exit();
	}

	if(mysqli_num_rows($rows) > 0){

		session_unset();
		$row = mysqli_fetch_array($rows);
		$_SESSION['Nome'] = $row['nome'];
		$_SESSION['Cognome'] = $row['cognome'];
		$_SESSION['Tipo_utente'] = $row['tipo'];
		$_SESSION['id'] = $row['id'];

		header('Location: ../web/homepage.php');
	} else {
		header('Location: ../web/login.php');
	}

	$conn->close();

?>