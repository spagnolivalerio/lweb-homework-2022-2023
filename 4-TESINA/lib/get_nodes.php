<?php

require_once('functions.php');



function getProgetti($root){

    $xmlFile = $root . "data/xml/progetti.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}

function getProgetto($root, $id_progetto){

    $xmlFile = $root . "data/xml/progetti.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/progetti/progetto[@id = '$id_progetto']")->item(0);

}

function getAllDiscussioni($root){

    $xmlFile = $root . "data/xml/discussioni.xml";
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


function getDiscussione($root, $id_discussione){
    
    $xmlFile = $root . "data/xml/discussioni.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/discussioni/discussione[@id = '$id_discussione']")->item(0);  
}

function getCommenti($root, $id_discussione){

    $xmlFile = $root . "data/xml/commenti.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/commenti/commento[@id_discussione = '$id_discussione']");

}

function getAllCommenti($root){

    $xmlFile = $root . "data/xml/commenti.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}

function getCommento($root, $id_commento){

    $xmlFile = $root . "data/xml/commenti.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/commenti/commento[@id = '$id_commento']")->item(0);

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

function getAllSegnalazioniCommento($root){
    $xmlFile = $root . "data/xml/reports_commenti.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}


function getSegnalazioniProgetto($root, $id_progetto){
    $xmlFile = $root . "data/xml/reports_progetti.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/reports_progetti/report_progetto[@id_progetto = '$id_progetto']");

}

function getAllSegnalazioniProgetto($root){
    $xmlFile = $root . "data/xml/reports_progetti.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}



function getRichiesteAccesso($root, $id_discussione){
    $xmlFile = $root . "data/xml/richieste_accesso_discussioni.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/richieste/richiesta[@id_discussione = '$id_discussione']");

}

function getAllRichiesteAccesso($root){
    $xmlFile = $root . "data/xml/richieste_accesso_discussioni.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}

function getWaitingRequestNumber($root, $richieste){
    $counter = 0;

    foreach($richieste as $richiesta){
        if($richiesta->getAttribute('stato') === 'in lavorazione'){
            $counter++;
        }
    }

    return $counter;
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

function getBozza($root, $id_bozza){

    $xmlFile = $root . "data/xml/bozze.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXpath($doc);

    return $xpath->query("/bozze/bozza[@id_bozza = '$id_bozza']")->item(0);

}

function getCategorie($root){

    $xmlFile = $root . "data/xml/categorie.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}

function getNomeCategoria($root, $id_categoria){

    $xmlFile = $root . "data/xml/categorie.xml";
    $doc = getDOMdocument($xmlFile);

    $categorie = $doc->documentElement->childNodes;

    foreach($categorie as $categoria){
        if($categoria->getAttribute('id') === $id_categoria){
            return $categoria->getElementsByTagName('nomeCategoria')->item(0)->nodeValue;
        }
    }

}

function getStoricoUtente($root, $id_utente){

    $xmlFile = $root . "data/xml/storici.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/storici/storico[@id_utente = '$id_utente']")->item(0);

}

function getTutorialBozza($root, $id_bozza){

    $xmlFile = $root . "data/xml/bozze.xml";
    $doc = getDOMdocument($xmlFile);

    $xpath = new DOMXPath($doc);

    return $xpath->query("/bozze/bozza[@id = '$id_bozza']/tutorial_bozza")->item(0);

}

function getStorici($root){

    $xmlFile = $root . "data/xml/storici.xml";
    $doc = getDOMdocument($xmlFile);

    return $doc->documentElement->childNodes;

}

function getStoricoProgetti($root, $storico){

    $progetti = $storico->getElementsByTagName('progetti')->item(0);
    $progetti = $progetti->childNodes;

    return $progetti; 

}

function getStoricoReportsCommenti($root, $storico){

    $reports_commenti = $storico->getElementsByTagName('reports_commenti')->item(0);
    $reports_commenti = $reports_commenti->childNodes;

    return $reports_commenti; 

}

function getStoricoReportsProgetti($root, $storico){

    $reports_progetti = $storico->getElementsByTagName('reports_progetti')->item(0);
    $reports_progetti = $reports_progetti->childNodes;

    return $reports_progetti; 

}

function getStoricoRichieste($root, $storico){

    $richieste = $storico->getElementsByTagName('richieste')->item(0);
    $richieste = $richieste->childNodes;

    return $richieste; 

}

function getStoricoCommenti($root, $storico){

    $commenti = $storico->getElementsByTagName('commenti')->item(0);
    $commenti = $commenti->childNodes;

    return $commenti; 

}

function getStoricoValutazioniProgetti($root, $storico){

    $valutazioni_progetti = $storico->getElementsByTagName('valutazioni_progetti')->item(0);
    $valutazioni_progetti = $valutazioni_progetti->childNodes;

    return $valutazioni_progetti; 

}

function getStoricoValutazioniCommenti($root, $storico){

    $valutazioni_commenti = $storico->getElementsByTagName('valutazioni_commenti')->item(0);
    $valutazioni_commenti = $valutazioni_commenti->childNodes;

    return $valutazioni_commenti; 

}

function getStoricoDiscussioni($root, $storico){

    $discussioni = $storico->getElementsByTagName('discussioni')->item(0);
    $discussioni = $discussioni->childNodes;

    return $discussioni; 

}






?>