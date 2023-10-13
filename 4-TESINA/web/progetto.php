<?php
	
	session_start();

	require_once('../lib/xsdFunction.php');
	require_once('../lib/printFunction.php');
	require_once('../data/xml/xmlFile.php');
		
	if(isset($_POST['id_progetto'])){
		$id_progetto = $_POST['id_progetto'];
	} else {
		$id_progetto = $_SESSION['id_progetto'];
	}

	$_SESSION['id_progetto'] = $id_progetto;

	if(isset($_POST['num_progetto'])){

		$_SESSION['num'] = $_POST['num_progetto'];
	}

?>


<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<body>

		<?php

			showComments($xmlCommenti, $xmlProgetti, $_SESSION['num']);

		?>
		
		<form method="post" action="../lib/commentare.php">
			<input type="text" name="commento"></input>
			<button type="subimt">commenta</button>
		</form>
	</body>
</html>

