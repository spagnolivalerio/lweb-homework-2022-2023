<?php

function cerca_auto($targa_auto){

	$xmlstring = "";
	foreach (file("../xml/automobili.xml") as $node){
  		$xmlstring .= trim($node);
	}

	$doc = new DOMDocument();
	$doc->loadXML($xmlstring);
	$root = $doc->documentElement;
	$nodi = $root->childNodes;

	for($i = 0; $i < $nodi->length; $i++){
		$auto = $nodi->item($i);
		$targa = $auto->getAttribute('targa');
		if($targa === $targa_auto){

			$marca = $auto->firstChild;
			$nomeMarca = $marca->textContent;
			$modello = $marca->nextSibling;
			$nomeModello = $modello->textContent;
			$prezzo_giornaliero = $modello->nextSibling;
			$value_prezzo_giornaliero = $prezzo_giornaliero->nodeValue;
			$img = $prezzo_giornaliero->nextSibling;
			$nome_img = $img->textContent;

			$_SESSION['prezzo_giornaliero'] = $value_prezzo_giornaliero;
			$_SESSION['marca'] = $nomeMarca;
			$_SESSION['modello'] = $nomeModello;
			$_SESSION['nome_file_img'] = $nome_img;
			$_SESSION['targa'] = $targa;

			break;
		}
	}
}

?>
