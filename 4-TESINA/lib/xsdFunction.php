<?php

	require_once('../data/xml/xmlFile.php');

	function uploadXML($xmlFile){

		$xmlstring = "";
		foreach (file("../data/xml/$xmlFile") as $node){
  			$xmlstring .= trim($node);
		}

		$doc = new DOMDocument(); //creo un oggetto DOMdocument
		if(!$doc->loadXML($xmlstring)){  //carico il file xml privo di spazi bianchi dentro all'oggetto doc
			exit();
		}

		$root = $doc->documentElement; //creo una variabile radice alla quale assegno il primo elemento del file xml
		$elementi = $root->childNodes; //childNodes restituisce una lista di nodi, i nodi figli di $root

		return $elementi;

	}

	function getDOMdocument($xmlfile){

			$xmlstring = "";
		foreach (file("../data/xml/$xmlfile") as $node){
  			$xmlstring .= trim($node);
		}

		$doc = new DOMDocument(); //creo un oggetto DOMdocument
		if(!$doc->loadXML($xmlstring)){  //carico il file xml privo di spazi bianchi dentro all'oggetto doc
			exit();
		}

		return $doc;

	}

	function numElements($xmlFile){

		$nodeList = uploadXml($xmlFile);

		return $nodeList->length;
	}

?>