<?php

$id_auto = "AA000AA";
$xmlstring = "";
	foreach(file('../../xml/automobili.xml') as $node){
		$xmlstring .= trim($node);
	}

	$doc = new DOMDocument();
	$doc->loadXML($xmlstring);
	$root = $doc->documentElement;
	$nodi = $root->childNodes;

	for($i = 0; $i < $nodi->length; $i++){

		$auto = $nodi->item($i);
		$targa = $auto->getAttribute('targa');

		if($targa === $id_auto){

			$auto_elements = $auto->childNodes;
			$k=0;
			while(!is_null($auto_elements->item(4+$k))){

				$noleggio_auto = $auto_elements->item(4+$k);
				$noleggio_elements = $noleggio_auto->childNodes;
				$data_noleggio = $noleggio_elements->item(0);
				$data_inizio = $data_noleggio->firstChild;
				$value_data_inizio = $data_inizio->nodeValue;
				$data_fine = $data_inizio->nextSibling;
				$value_data_fine = $data_fine->nodeValue;

				echo "$value_data_fine - $value_data_inizio\n";

				$k++;
			}
		}
	}
?>