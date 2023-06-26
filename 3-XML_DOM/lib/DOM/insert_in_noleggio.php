<?php
	session_start();
	
	if(!isset($_SESSION['tipo_utente'])){
        header('Location: login.php');
        exit();
    }

    $xmlstring = "";
    foreach (file("../../xml/automobili.xml") as $node) {
  		$xmlstring .= trim($node);
	}

	$doc = new DOMDocument();
	$doc->loadXML($xmlstring);
	$root = $doc->documentElement;
	$nodi = $root->childNodes;

    $targa = $_SESSION['id_auto'];

    $noleggio = $doc->createElement('noleggio');
    $data_noleggio = $doc->createElement('data_noleggio');
    $data_inizio = $doc->createElement('data_inizio');
    $data_fine = $doc->createElement('data_fine');

    $data_inizio->nodeValue = $_SESSION['giorno_inizio'];
    $data_fine->nodeValue = $_SESSION['giorno_fine'];

    $data_noleggio->appendChild($data_inizio);
    $data_noleggio->appendChild($data_fine);

    $noleggio->appendChild($data_noleggio);
    $noleggio->setAttribute('id_utente', $_SESSION['id_utente']);


	for ($i = 0; $i < $nodi->length; $i++) {

		$auto = $nodi->item($i);
		$targa_auto = $auto->getAttribute('targa');

		if ($targa_auto === $targa) {

			$k = 0;
			$auto_elements = $auto->childNodes;

			while(!is_null($auto_elements->item(4+$k))) {

				$previous_noleggio = $auto_elements->item(4+$k);
				$not_equal_id = $previous_noleggio->getAttribute('id_noleggio');
				$k++;

			}	

				preg_match('/\d+/', $not_equal_id, $num);

				$int = intval($num[0]);
				$int = $int + 1;
				$int = strval($int);
				$newid = "" . $targa_auto. "_" . $int;

				$noleggio->setAttribute('id_noleggio', $newid);

				$auto->appendChild($noleggio);

				$xml = $doc->saveXML();
				$xmlfile = "../../xml/automobili.xml";

				file_put_contents($xmlfile, $xml);

				$_SESSION['conferma_noleggio'] = true;
				header('Location: ../../web/checkout_noleggio.php');
				exit();
				
		}
	}

	$_SESSION['conferma_noleggio'] = false;
	header('Location: ../../web/checkout_noleggio.php');
	exit();
?>