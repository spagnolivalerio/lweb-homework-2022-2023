<?php

session_start();
require_once 'functions.php';
$root = "../";



if (!isset($_POST['id_bozza']) || empty($_POST['id_bozza'])) {
    exit;
} else {
    $id_bozza = $_POST['id_bozza'];
}

$xmlFile = "../data/xml/bozze.xml";
$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);

//RIMUOVERE IMMAGINE

$bozza = $xpath->query("/bozze/bozza[@id='$id_bozza']")->item(0);
$img_path = $bozza->getAttribute('nome_file_img');
$img_path = $root . $img_path;

if (file_exists($img_path)) {
    unlink($img_path);
}

//RIMUOVERE IMMAGINE STEP

$steps = $bozza->getElementsByTagName('step');
if(!empty($steps)){
    foreach($steps as $step){
        $img_path = $step->getAttribute('nome_file_img');
        $img_path = $root . $img_path;
        if (file_exists($img_path)){
            unlink($img_path);
        }
    }
}

//RIMUOVI DA BOZZE.XML

$query = "/bozze/bozza[@id";
remove_1_1($xmlFile, $query, $id_bozza);

$url = "../web/" . $_SESSION['Tipo_utente'] . "/view_bozze.php";
header("Location: $url");
exit;

?>