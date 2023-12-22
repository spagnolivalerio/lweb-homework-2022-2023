<?php

require_once('functions.php');



function getProgetti($root){

    $xmlFile = $root . "data/xml/progetti.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}

/*funzione che prende in input l'id progetto e returna una DOMNodeList di discussioni*/

function getDiscussioni($root, $id_progetto){

    $xmlFile = $root . "data/xml/discussioni.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/discussioni/discussione[@id_progetto = '$id_progetto']");  
    
}
/*funzione che prende un DOMNode discussione e stampa tutti i commenti, indicativamente da mettere in un foreach*/ 

function getCommenti($root, $id_discussione){

    $xmlFile = $root . "data/xml/commenti.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/commenti/commento[@id_discussione = '$id_discussione']");

}

function getPartecipanti($root, $id_discussione){

    $xmlFile = $root . "data/xml/discussioni.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);
    $discussione = $xpath->query("/discussioni/discussione[@id = '$id_discussione']")->item(0);
    
    $partecipanti = $discussione->getElementsByTagName('partecipanti')->item(0);
    $partecipanti = $partecipanti->childNodes;

    return $partecipanti; 

}

function getValutazioniCommenti($root, $id_commento){
    $xmlFile = $root . "data/xml/valutazioni_commenti.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/valutazioni_commenti/valutazione_commento[@id_commento = '$id_commento']");

}

function getValutazioniProgetto($root, $id_progetto){
    $xmlFile = $root . "data/xml/valutazioni_progetti.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/valutazioni/valutazione_progetto[@id_progetto = '$id_progetto']");

}


function getSegnalazioniCommento($root, $id_commento){
    $xmlFile = $root . "data/xml/reports_commenti.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/reports_commenti/report_commento[@id_commento = '$id_commento']");

}

function getSegnalazioniProgetto($root, $id_progetto){
    $xmlFile = $root . "data/xml/reports_progetti.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/reports_progetti/report_progetto[@id_progetto = '$id_progetto']");

}

function getRichiesteAccesso($root, $id_discussione){
    $xmlFile = $root . "data/xml/richieste_accesso_discussioni.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/richieste/richiesta[@id_discussione = '$id_discussione']");

}

function getSteps($root, $id_progetto){
    $xmlFile = $root . "data/xml/tutorials.xml";
    $doc = getDOMdocument($xmlFile); 

    $xpath = new DOMXPath($doc);

    return $xpath->query("/tutorials_progetti/tutorial_progetto[@id_progetto = '$id_progetto']")->item(0)->childNodes; 

}

function getBozze($root, $id_utente){

    $xmlFile = $root . "data/xml/bozze.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/bozze/bozza[@id_creator = '$id_utente']");

}

function getCategorie($root){

    $xmlFile = $root . "data/xml/categorie.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}


?>