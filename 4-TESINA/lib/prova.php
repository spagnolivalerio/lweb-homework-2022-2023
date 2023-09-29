<?php

require_once('function.php');

$path = "progetti.xml";

$categorie = getCategoria($path);
$commenti = getCommenti($path);
$valutazione = getValutazione($path);
$creator = getCreator($path);
$descrizione = getDescrizione($path);

$lenght = numProjects($path);

for($i = 0; $i < $lenght; $i++){

	$categorie_istanza = $categorie[$i];

	foreach($categorie_istanza as $categorie_progetto){

			echo "$categorie_progetto \n";
	}

	$commenti_istanza = $commenti[$i];

	foreach($commenti_istanza as $commento){

		echo "$commento ";
	}
	
}


