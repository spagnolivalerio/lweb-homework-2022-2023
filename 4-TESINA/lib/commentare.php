<?php
session_start();
require_once('functions.php');
$xmlFile = "../data/xml/commenti.xml";

if(!isset($_POST['testo']) || empty($_POST['testo'])){
    exit;
}else{
    $newTestoValue = $_POST['testo'];
}

if(!isset($_POST['id_discussione']) || empty($_POST['id_discussione'])){
    exit;
} else {
    $id_discussione = $_POST['id_discussione']; 
}

$id_commentatore = $_SESSION['id_utente'];
$id_commento = generate_id($xmlFile);

//AGGIUNTA IN COMMENTI.XSD
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;

$newCommento = $doc->createElement('commento');
$newCommento->setAttribute('id_commento', $id_commento);
$newCommento->setAttribute('id_discussione', $id_discussione);
$newCommento->setAttribute('id_commentatore', $id_commentatore);

$newTesto = $doc->createElement('testo', $newTestoValue);

$newCommento->appendChild($newTesto);

$root->appendChild($newCommento);


$doc->formatOutput = true;
$xmlString = $doc->saveXML(); //ottengo il file xml come stringa
file_put_contents($xmlFile, $xmlString);


//AGGIUNTA IN DiSCUSSIONI.XML
$xmlFile = "../data/xml/discussioni.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

foreach($nodes as $node){
     
     if($id_discussione === $node->getAttribute('id')){

        $proCommento = $doc->createElement('commento');
        $proCommento->setAttribute('id_commento', $id_commento);
        $commenti = $doc->getElementsByTagName('commenti')->item(0);
        $commenti->appendChild($proCommento);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
        file_put_contents($xmlFile, $xmlString);

        break; 
     }
 }

header('Location: ../prove_funzioni/prova_commentare.php');
exit();

?>