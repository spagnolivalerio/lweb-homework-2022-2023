<?php

require_once('functions.php');

function getProgetti($root){

    $xmlFile = $root . "data/xml/progetti.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}

/*funzione che prende in input l'id progetto e returna una DOMNodeList di discussioni*/

/*funzione che prende un DOMNode discussione e stampa tutti i commenti, indicativamente da mettere in un foreach*/ 

?>