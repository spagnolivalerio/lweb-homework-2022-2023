<?php
	session_start();
	require_once('../data/xml/xmlFile.php');
	require_once('../lib/xsdFunction.php');

	$id_utente = $_SESSION['id_utente'];
	$id_progetto = $_SESSION['id_progetto'];

	if(isset($_POST['commento'])){
		$commento = $_POST['commento'];
	} else {
		exit();
	}

	$xmlstring = "";
    foreach (file("../../xml/$xmlCommenti") as $node) {
  		$xmlstring .= trim($node);
	}



?>