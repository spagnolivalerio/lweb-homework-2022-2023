<?php

require_once('../data/xml/xmlFile.php');
require_once('xsdFunction.php');

$commenti = getIDCommenti($xmlProgetti);
$lenght = numElements($xmlProgetti);

for($i = 0; $i < $lenght; $i++){

	$commenti_progetto_iesimo = $commenti[$i];

	foreach($commenti_progetto_iesimo as $commento){

			echo "$commento \n";
	}
	
}


