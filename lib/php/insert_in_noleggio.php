<?php
	session_start();
	require('../../res/var/db.php');
	$conn = new mysqli($servername, $db_username, $db_password, $db_name);

	$id_auto = mysqli_real_escape_string($conn, $_SESSION['id_auto']);
	$start_day = mysqli_real_escape_string($conn, $_SESSION['giorno_inizio']);
	$end_day = mysqli_real_escape_string($conn, $_SESSION['giorno_fine']);
	$id_utente = mysqli_real_escape_string($conn, $_SESSION['id_utente']);
	$prezzo_tot = mysqli_real_escape_string($conn, $_SESSION['prezzo_tot']);

	$insert = "INSERT INTO noleggio(id_auto, id_utente, data_inizio, data_fine, prezzo_tot) 					  VALUES ('$id_auto', '$id_utente', '$start_day', '$end_day', '$prezzo_tot');";

	try{	
		mysqli_query($conn, $insert);
		$_SESSION['conferma_noleggio'] = 'true'; 
		header('Location: ../../web/checkout_noleggio.php');
		exit(1);
	} catch(Exception $e) {
		$_SESSION['conferma_noleggio'] = 'false';
		header('Location: ../../web/checkout_noleggio.php');
		exit(1);
	}
?>