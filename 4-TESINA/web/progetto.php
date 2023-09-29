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

	$num = $_POST['num_progetto'];

	showComments($xmlCommenti, $xmlProgetti, $num);

?>

