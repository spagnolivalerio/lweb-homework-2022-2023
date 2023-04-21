<?php

	session_start();
	require('../../var/db.php');

	$conn = new mysqli($servername, $db_username, $password, $dbname);

	if($conn->connect_error){
		die("Errore nella connessione con il database: " . $conn->connect_error);
	}

	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	$query = "SELECT *
			  FROM utente
			  WHERE username = '$username'
			  AND password = '$password';";

	if(!mysqli_query($conn, $query)){
		die("error: " .$conn->connect_error);
	}
	
	if(mysqli_num_rows($query) > 0){
		$_SESSION['tipo_utente'] = 'cliente';
		$_SESSION['nome_utente'] = '$username';
		header(Location: '../../web/homepage');
	}

	$conn->close();

?>