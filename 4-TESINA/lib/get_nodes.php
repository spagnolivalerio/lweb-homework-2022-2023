<?php

require_once('functions.php');

function getProgetti($root){

    $xmlFile = $root . "data/xml/progetti.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}

/*funzione che prende in input l'id progetto e returna una DOMNodeList di discussioni*/

function getDiscussioni($root, $id_progetto){

    $discussioni = [];
    $xmlFile = $root . "data/xml/discussioni.xml";
    $doc = getDOMdocument($xmlFile);

    return $xpath->query("/discussioni/discussione[@id_progetto='$id_progetto']");  
    
}
/*funzione che prende un DOMNode discussione e stampa tutti i commenti, indicativamente da mettere in un foreach*/ 

function getCommenti($root, $discussioni){

    $xmlFile = $root . "data/xml/commenti.xml";
    $doc = getDOMdocument($xmlFile);

    foreach($discussioni as $discussione){
        $id_discussione = $discussione->getAttribute('id');
        $nodes = $xpath->query("/commenti/commento[@id_discussione='$id_discussione']");

        foreach($nodes as $node){
            
        }
    }

}



?>