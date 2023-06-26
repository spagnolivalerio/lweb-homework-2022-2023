<?php
	session_start();
	require_once('../../res/var/connection.php');

	$conn = connect_to_db($servername, $db_username, $db_password, $db_name);

	if(isset($_POST['username']) && isset($_POST['password'])){
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
	} else {
		header('Location: ../../index.php');
		exit();
	}

	$password = md5($password);

	$query = "SELECT *
			  FROM utente
			  WHERE username = '$username'
			  AND password = '$password';";

	$rows = mysqli_query($conn, $query);

	if(!$rows) {
		exit();
	}

	$_user_row = mysqli_fetch_array($rows);
	$id_user = $_user_row['id'];
	$name = $_user_row['nome'];
	$lastname = $_user_row['cognome'];

	if(mysqli_num_rows($rows) > 0){
		session_unset();
		$_SESSION['id_utente'] = "$id_user";
		$_SESSION['tipo_utente'] = 'cliente';
		$_SESSION['nome_utente'] = "$username";
		$_SESSION['nome_cliente'] = "$name";
		$_SESSION['cognome_cliente'] = "$lastname";

		header('Location: ../../web/homepage.php');
	} else {
		header('Location: ../../web/login.php');
	}

	$conn->close();

?>