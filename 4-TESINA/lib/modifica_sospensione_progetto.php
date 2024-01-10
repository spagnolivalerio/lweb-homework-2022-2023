<?php

session_start();
include('../conn.php');
require_once('get_nodes.php');
require_once('functions.php');
$radice = "../";


if (!isset($_SESSION['Tipo_utente'])) {
    header('Location: ../web/login.php');
    exit;
}

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}

if (!isset($_POST['nomeCategoria']) || empty($_POST['nomeCategoria'])) {
    exit;
} else {
    $nomeCategoria = $_POST['nomeCategoria'];
}


# AGGIUNTA IN CATEGORIE.XML

$xmlFile = "../data/xml/categorie.xml";
$id_categoria = generate_id($xmlFile);
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;


$newCategoria = $doc->createElement('categoria');
$newCategoria->setAttribute('id', $id_categoria);


$newNomeCategoria = $doc->createElement('nomeCategoria', $nomeCategoria);


$newCategoria->appendChild($newNomeCategoria);


$root->appendChild($newCategoria);

$doc->formatOutput = true;
$xmlString = $doc->saveXML(); //ottengo il file xml come stringa
file_put_contents($xmlFile, $xmlString);

# AGGIORNAMENTO IN PROGETTI.XML

$xmlFile = "../data/xml/progetti.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$xpath = new DOMXPath($doc); 


$modProgetto = $xpath->query("/progetti/progetto[@id = '$id_progetto']")->item(0); 

$modProgetto->setAttribute('sospeso', 'false');

$categorie =  $modProgetto->getElementsByTagName('categorie')->item(0);
$nuovaCategoria = $doc->createElement('categoria');
$nuovaCategoria->setAttribute('id_categoria', $id_categoria);
$categorie->appendChild($nuovaCategoria);


$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);
    

header('Location: ../web/' . $_SESSION['Tipo_utente'] . '/view_categorie_proposte.php');

exit;

?>