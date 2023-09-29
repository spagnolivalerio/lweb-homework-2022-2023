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

	function numElements($xmlFile){

		$nodeList = uploadXml($xmlFile);

		return $nodeList->length;
	}

	function getImage($xmlprogetti){

		$nodeList = uploadXML($xmlprogetti);
		$array_img = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);

			if(is_null($progetto)){
				exit();
			}

			$array_img[$i] = $progetto->getAttribute('file_img');
		}

		return $array_img;
	}

	function getIDprogetti($xmlprogetti){

		$nodeList = uploadXML($xmlprogetti);
		$array_id_progetti = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);

			if(is_null($progetto)){
				exit();
			}

			$array_id_progetti[$i] = $progetto->getAttribute('id');
		}

		return $array_id_progetti;
	}

	function getIDcreator($xmlprogetti){

		$nodeList = uploadXML($xmlprogetti);
		$array_creators = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);

			if(is_null($progetto)){
				exit();
			}

			$array_creators[$i] = $progetto->getAttribute('id_creator');

		}

		return $array_creators;
	}

		function getTitolo($xmlprogetti){

		$nodeList = uploadXML($xmlprogetti);
		$array_titoli = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);

			if(is_null($progetto)){
				exit();
			}

			$array_titoli[$i] = $progetto->getAttribute('titolo');

		}

		return $array_titoli;
	}

	function getIDcommenti($xmlprogetti){

		$nodeList = uploadXML($xmlprogetti);
		$array_progetti = array();

		for($i = 0; $i < $nodeList->length; $i++){

			$progetto = $nodeList->item($i);

			if(is_null($progetto)){
				exit();
			}

			$items = $progetto->childNodes;
			$commenti = $items->item(2);

			if(is_null($commenti)){
				exit();
			}

			$all_commenti = $commenti->childNodes;
			$array_id_commenti = array();

			$k = 0; 

			foreach($all_commenti as $commento){

				$array_id_commenti[$k] = $commento->getAttribute('id_commento');
				$k++;

			}

			$array_progetti[$i] = $array_id_commenti;
			
		}

		return $array_progetti;

	}

	function showProjects($xmlprogetti){

		$numProjects = numElements($xmlprogetti);

		$titolo = getTitolo($xmlprogetti);
		$creator = getIDCreator($xmlprogetti);
		$id = getIDprogetti($xmlprogetti);
		$img = getImage($xmlprogetti);

		for($i = 0; $i < $numProjects; $i++){
	
			echo "	<div class=\"projects\">
						<img class=\"img\" src=\"../img/$img[$i]\"></img>
						<div class=\"project-title\">$titolo[$i]</div>
						<div class=\"flex-box\">
							<div class=\"autore\">$creator[$i]</div>
							<form class=\"dettagli\" method=\"post\" action=\"\">
								<input name=\"id_progetto\" type=\"hidden\" value=\"$id[$i]\"></input>
								<button class=\"dettagli_bottone\" type=\"submit\">dettagli</button>
							</form>
						</div>
						<div class=\"time\">Tempo stimato: </div>
					</div>";
		}
	}

?>