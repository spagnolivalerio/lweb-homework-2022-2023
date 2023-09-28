<?php

	function uploadXml($nomefile){

		$xmlstring = "";
		foreach (file("../data/xml/$nomefile") as $node){
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

	function getCategoria($nomefile){ //mi restituisce un array con dentro gli array con le categorie dei progetti

		$nodeList = uploadXml($nomefile);
		$array_categorie = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);

			$categorie = $progetto->firstChild;
			$categoria = $categorie->firstChild;

			$array_categoria = array();
			$k = 0;
			$array_categoria[$k] = $categoria->textContent;

			if(!is_null($categoria->nextSibling)){

				$categoria = $categoria->nextSibling;
				$k++;
				$array_categoria[$k] = $categoria->textContent;
				$array_categorie[$i] = $array_categoria;

			}

		}

		return $array_categorie;
	}

	function getCommenti($nomefile){

		$nodeList = uploadXml($nomefile);
		$array_commenti = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);

			$categorie = $progetto->item($i);
			$commenti = $categorie->nextSibling;
			$commento = $commenti->firstChild;

			if(is_null($commento)){
				exit();
			}

			$array_commento = array();
			$k = 0;
			$array_commento[$k] = $commento->textContent;

			if(!is_null($commento->nextSibling)){

				$commento = $commento->nextSibling;
				$k++;
				$array_commento[$k] = $commento->textContent;
				$array_commenti[$i] = $array_commento;
			}

		}

		return $array_commenti;
	}


?>