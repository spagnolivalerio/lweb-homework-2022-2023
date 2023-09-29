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

	function numProjects($nomefile){

		$nodeList = uploadXml($nomefile);

		return $nodeList->length;
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
				return 0;
			}

			$array_commenti_row = array();
			$k = 0;
			$array_commenti_row[$k] = $commento->textContent;

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
				return 0;
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

	function getCreator($nomefile){

		$nodeList = uploadXml($nomefile);
		$array_id_progetti = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);
			$array_id_progetti[$i] = $progetto->getAttribute('id_progetto');

		}

		return $array_id_progetti;

	}

	function getDescrizione($nomefile){

		$nodeList = uploadXml($nomefile);
		$array_descrizioni = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);
			$elementi = $progetto->childNodes;
			$descrizione = $elementi->item(4);

			$array_descrizioni[$i] = $descrizione->textContent;

		}

		return $array_descrizioni;
	}

	function getTitolo($nomefile){

		$nodeList = uploadXml($nomefile);
		$array_titoli = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);
			$titolo = $progetto->getAttribute('titolo');
			$array_titoli[$i] = $titolo;

		}

		return $array_titoli;
	}

	function getTempistica($nomefile){

		$nodeList = uploadXml($nomefile);
		$array_tempistiche = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);
			$elementi = $progetto->childNodes;
			$tempistica = $elementi->item(6);

			$array_tempistiche[$i] = $tempistica->textContent; 

		}

		return $array_tempistiche;

	}

	function getIDprogetto($nomefile){

		$nodeList = uploadXml($nomefile);
		$array_id_progetti = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);
			$id = $progetto->getAttribute('id_progetto');
			$array_id_progetti[$i] = $id;

		}

		return $array_id_progetti;


	}

	function showProjects($nomefile){

		$numProjects = numProjects($nomefile);

		$titolo = getTitolo($nomefile);
		$tempistica = getTempistica($nomefile);
		$creator = getCreator($nomefile);
		$id = getIDprogetto($nomefile);

		for($i = 0; $i < $numProjects; $i++){
	
			echo "	<div class=\"projects\">
						<img class=\"img\" src=\"../img/arduino.jpg\"></img>
						<div class=\"project-title\">$titolo[$i]</div>
						<div class=\"flex-box\">
							<div class=\"autore\">autore</div>
							<form class=\"dettagli\" method=\"post\" action=\"\">
								<input name=\"id_progetto\" type=\"hidden\" value=\"$id[$i]\"></input>
								<button class=\"dettagli_bottone\" type=\"submit\">dettagli</button>
							</form>
						</div>
						<div class=\"time\">Tempo stimato: $tempistica[$i]</div>
					</div>";
		}
	}


?>