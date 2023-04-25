<?php

	session_start();
	require('../../res/var/db.php');

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

	$query = "SELECT id
			  FROM utente
			  WHERE username = '$username';";
	
	$res = mysqli_query($conn, $query);

	$_user_row = mysqli_fetch_array($res);
	$IDUSER = $_user_row['id'];



	if(mysqli_num_rows($rows) > 0){
		session_destroy();
		session_start();
		$_SESSION['id_utente'] = "$IDUSER";
		$_SESSION['tipo_utente'] = 'cliente';
		$_SESSION['nome_utente'] = "$username";
		header('Location: ../../web/homepage.php');
	} else {
		header('Location: ../../web/login.php');
	}

	$conn->close();

?>