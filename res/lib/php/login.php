<?php

	session_start();
	require('../../var/db.php');

	$conn = new mysqli($servername, $db_username, $db_password, $db_name);

	if($conn->connect_error){
		die("Errore nella connessione con il database: " . $conn->connect_error);
	}

	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	$query = "SELECT *
			  FROM utente
			  WHERE username = '$username'
			  AND password = '$password';";

	$rows = mysqli_query($conn, $query);

	if(!$rows) {
		die("Impossibile eseguire la query");
		exit(1);
	}
	
	if(mysqli_num_rows($rows) > 0){
		$_SESSION['tipo_utente'] = 'cliente';
		$_SESSION['nome_utente'] = '$username';
		header('Location: ../../../web/homepage.html');
	} else {
		header('Location: ../../../web/login.html');
	}

	$conn->close();

?>