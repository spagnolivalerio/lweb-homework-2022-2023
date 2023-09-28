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
		$array_categorie_column = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);

			$categorie = $progetto->firstChild;
			$categoria = $categorie->firstChild;

			$array_categorie_row = array();
			$k = 0;
			$array_categorie_row[$k] = $categoria->textContent;

			while(!is_null($categoria->nextSibling)){

				$categoria = $categoria->nextSibling;
				$k++;
				$array_categorie_row[$k] = $categoria->textContent;

			}

				$array_categorie_column[$i] = $array_categorie_row;

		}

		return $array_categorie_column;
	}

	function getCommenti($nomefile){

		$nodeList = uploadXml($nomefile);
		$array_commento_column = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);

			$elementi = $progetto->childNodes;
			$commenti = $elementi->item(1);
			$commento = $commenti->firstChild;

			if(is_null($commento)){
				exit();
			}

			$array_commento_row = array();
			$k = 0;
			$array_commento_row[$k] = $commento->textContent;

			while(!is_null($commento->nextSibling)){

				$commento = $commento->nextSibling;
				$k++;
				$array_commenti_row[$k] = $commento->textContent;

			}

				$array_commenti_column[$i] = $array_commenti_row;

		}

		return $array_commenti_column;
	}

	function getValutazione($nomefile){

		$nodeList = uploadXml($nomefile);
		$array_valutazioni_column = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);

			$elementi = $progetto->childNodes;
			$valutazioni = $elementi->item(2);
			$valutazione = $valutazioni->firstChild;

			if(is_null($valutazione)){
				exit();
			}

			$array_valutazioni_row = array();
			$k = 0; 
			$array_valutazioni_row[$k] = $valutazione->nodeValue;

			while(!is_null($valutazione->nextSibling)){

				$valutazione = $valutazione->nextSibling;
				$k++;
				$array_valutazioni_row[$k] = $valutazione->nodeValue;

			}

				$array_valutazioni_column[$i] = $array_valutazioni_row;

		}

		return $array_valutazioni_column;
	}


?>