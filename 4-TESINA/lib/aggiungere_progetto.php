<?php

session_start();
require_once 'functions.php';
$xmlFile = "../data/xml/progetti.xml";
$xmlTutorial = "../data/xml/tutorials.xml";
$img_dir_path = "../img/proj/";

if (!isset($_POST['categorie']) || empty($_POST['categorie'])) {
    exit;
} else {
    $categorie = $_POST['categorie'];
}

if (!isset($_POST['descrizione']) || empty($_POST['descrizione'])) {
    exit;
} else {
    $descrizione = $_POST['descrizione'];
}

if (!isset($_POST['titolo']) || empty($_POST['titolo'])) {
    exit;
} else {
    $titolo = $_POST['titolo'];
}

if (!isset($_POST['tempo_medio']) || empty($_POST['tempo_medio'])) {
    exit;
} else {
    $tempo_medio = $_POST['tempo_medio'];
}

if (!isset($_POST['difficolta']) || empty($_POST['difficolta'])) {
    exit;
} else {
    $difficolta = $_POST['difficolta'];
}

if (!isset($_FILES['img']['tmp_name']) || empty($_FILES['img']['tmp_name'])) {
    exit;
} else {
    $img_location = $_FILES['img']['tmp_name'];
}

if (!isset($_FILES['img']['tmp_name']) || empty($_FILES['img']['tmp_name'])) {
    exit;
} else {
    $img_location = $_FILES['img']['tmp_name'];
}

$id_progetto = generate_id($xmlFile);
$id_tutorial = $id_progetto;

$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
$nome_file_img = $img_dir_path . uniqid('img_proj_') . "." . $ext;

$data_ora = new DateTime();
$data_ora = $data_ora->format('Y-m-d H:i:s');
$id_creator = $_SESSION['id_utente'];

//AGGIUNTA IN PROGETTI.XML

$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;

$newProgetto = $doc->createElement('progetto');

$proTitolo = $doc->createElement('titolo', $titolo);
$proCategorie = $doc->createElement('categorie');
$proDescrizione = $doc->createElement('descrizione', $descrizione);
$proReports = $doc->createElement('reports_progetti');
$proDiscussioni = $doc->createElement('discussioni');
$proTutorial = $doc->createElement('tutorial_progetto');
$proValutazioni = $doc->createElement('valutazioni');

$newProgetto->setAttribute('id', $id_progetto);
$newProgetto->setAttribute('id_creator', $id_creator);
$newProgetto->setAttribute('tempo_medio', $tempo_medio);
$newProgetto->setAttribute('data_pubblicazione', $data_ora);
$newProgetto->setAttribute('visualizzazioni', 0);
$newProgetto->setAttribute('nome_file_img', $nome_file_img);
$newProgetto->setAttribute('difficolta', $difficolta);

foreach ($categorie as $categoria) {

    $proCategoria = $doc->createElement('categoria');
    $proCategoria->setAttribute('id_categoria', $categoria);
    $proCategorie->appendChild($proCategoria);

}

$proTutorial->setAttribute('id_tutorial', $id_tutorial);

$newProgetto->appendChild($proCategorie);
$newProgetto->appendChild($proDescrizione);
$newProgetto->appendChild($proReports);
$newProgetto->appendChild($proDiscussioni);
$newProgetto->appendChild($proTutorial);
$newProgetto->appendChild($proValutazioni);

$root->appendChild($newProgetto);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

//CREAZIONE SCHELETRO TUTORIAL IN TUTORIALS_PROGETTI.XSD

$doc = getDOMdocument($xmlTutorial);
$root = $doc->documentElement;
$nodes = $root->childNodes;

$newTutorial = $doc->createElement('tutorial_progetto');

$newTutorial->setAttribute('id', $id_tutorial);
$newTutorial->setAttribute('id_progetto', $id_progetto);

$root->appendChild($newTutorial);

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlTutorial, $xmlString);

//AGGIUNTA IN STORICO.XML

$xmlFile = "../data/xml/storici.xml";
$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

foreach ($nodes as $node) {

    if ($_SESSION['id_utente'] === $node->getAttribute('id_utente')) {

        $stoProgetto = $doc->createElement('progetto');
        $stoProgetto->setAttribute('titolo', $titolo);
        $stoProgetto->setAttribute('id_progetto', $id_progetto);
        $stoProgetti = $node->getElementsByTagName('progetti')->item(0);
        $stoProgetti->appendChild($stoProgetto);

        $doc->formatOutput = true;
        $xmlString = $doc->saveXML();
        file_put_contents($xmlFile, $xmlString);

        break;

    }
}

add_img($img_location, $nome_file_img);

header('Location: ../prove_funzioni/prova_aggiungi_progetto.php');
exit;

?>