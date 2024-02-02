<?php

session_start();
require_once 'functions.php';



if (!isset($_POST['id_bozza']) || empty($_POST['id_bozza'])) {
    exit;
} else {
    $id_bozza = $_POST['id_bozza'];
}

$xmlFile = "../data/xml/bozze.xml";
$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);

//RIMUOVI DA BOZZE.XML

$query = "/bozze/bozza[@id";
remove_1_1($xmlFile, $query, $id_bozza);


$url = "../web/" . $_SESSION['Tipo_utente'] . "/view_bozze.php";
header("Location: $url");
exit;

?>