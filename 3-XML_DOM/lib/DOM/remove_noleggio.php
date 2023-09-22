<?php

$id_noleggio = $_POST['id_noleggio'];
$targa_auto = $_POST['targa_auto'];


$xmlstring = "";
foreach (file('../../xml/automobili.xml') as $nodi) {
	$xmlstring .= trim($nodi);
}

$doc = new DOMDocument();
$doc->loadXML($xmlstring);
$root = $doc->documentElement;
$nodi = $root->childNodes;

for($i = 0; $i < $nodi->length; $i++){

	$auto = $nodi->item($i);
	$targa = $auto->getAttribute('targa');

	if($targa === $targa_auto){

		$auto_elements = $auto->childNodes;
		$k = 0; 
	
		while(!is_null($auto_elements->item(4+$k))){

			$noleggio = $auto_elements->item(4+$k);
			$id_noleggio_2 = $noleggio->getAttribute('id_noleggio');

			if($id_noleggio === $id_noleggio_2){

				$auto->removeChild($noleggio);

				$doc->formatOutput = true;

				$xml = $doc->saveXML();
				$xmlfile = "../../xml/automobili.xml";

				file_put_contents($xmlfile, $xml);

				header('location: ../../web/i-miei-noleggi.php');
				exit();

			} else {
				
				$k++;
			}
		}
	}
}

header('location: ../../web/i-miei-noleggi.php');


?>