<?php
	require_once('../data/xml/xmlFile.php');

	function showProjects($xmlprogetti){

		$numProjects = numElements($xmlprogetti);

		$_SESSION['num'] = $numProjects;

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
							<form class=\"dettagli\" method=\"post\" action=\"progetto.php\">
								<input name=\"id_progetto\" type=\"hidden\" value=\"$id[$i]\"></input>
								<input name=\"num_progetto\" type=\"hidden\" value=\"$i\"></input>
								<button class=\"dettagli_bottone\" type=\"submit\">dettagli</button>
							</form>
						</div>
						<div class=\"time\">Tempo stimato: </div>
					</div>";
		}
	}

	function showComments($xmlcommenti, $xmlprogetti, $num){

		$idFixedList = getIDcommenti($xmlprogetti);
		$idFixedList = $idFixedList[$num];

		$commentList = uploadXML($xmlcommenti);

		foreach($idFixedList as $id){
			foreach($commentList as $com){
				if($id === $com->getAttribute('id')){
					$commento = $com->textContent;
					echo "<div class=\"commento\">$commento</div>
						a";
				}
			}
		}
	}

?>