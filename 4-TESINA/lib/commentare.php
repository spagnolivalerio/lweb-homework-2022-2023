<?php
	session_start();
	require_once('../data/xml/xmlFile.php');
	require_once('../lib/xsdFunction.php');

	$id_utente = $_SESSION['id_utente'];
	$id_progetto = $_SESSION['id_progetto'];

	if(isset($_POST['commento']) && !empty($_POST['commento'])){

		$commento = $_POST['commento'];
		$doc = getDOMdocument($xmlCommenti);
		$root = $doc->documentElement;
		$commenti = $root->childNodes;

		$newcom = $doc->createElement('commento');
		$testo = $doc->createElement('testo');
		$testo->nodeValue = $commento;
		$newcom->appendChild($testo);

		$exist = false;

		while(!$exist){

			foreach($commenti as $commento){

				if($commento->getAttribute('id') === $id_commento){;}
	
				else{
					
					$id_commento++;
					$exist = true;
		
				}
				
			}
		}

		$newcom->setAttribute('id', $id_commento);
		$newcom->setAttribute('id_commentatore', $id_utente);
		$newcom->setAttribute('id_progetto', $id_progetto);

		$root->appendChild($newcom);

		$doc->formatOutput = true;
		$xml = $doc->saveXML();
		$xmlfile = "../data/xml/$xmlCommenti";
		file_put_contents($xmlfile, $xml);

		$doc2 = getDOMdocument($xmlProgetti);
		$root = $doc2->documentElement;
		$nodeListProgetti = $root->childNodes;

		foreach($nodeListProgetti as $progetto){

			if($progetto->getAttribute('id') === $id_progetto){

				$commento = $doc2->createElement('commento');
				$commento->setAttribute('id_commento', $id_commento); 

				$progetto = $nodeListProgetti->item($_SESSION['num']);

				$progetto->childNodes->item(2)->appendChild($commento);

				$doc2->formatOutput = true;
				$xml = $doc2->saveXML();
				$xmlfile = "../data/xml/$xmlProgetti";
				file_put_contents($xmlfile, $xml);
				break;

			}

		}

		header('Location: ../web/progetto.php');

	} else {

		header('Location: ../web/progetto.php');
		exit();
	}



?>
