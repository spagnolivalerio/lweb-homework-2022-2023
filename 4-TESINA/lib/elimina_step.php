<?php
session_start();
require_once('functions.php');
require_once('get_nodes.php');

$tps_root = "../";
$id_bozza = $_SESSION['id_bozza'];
if(isset($_POST['num_step'])){
    $num_step = (int) $_POST['num_step'] + 1;
}

$xmlFile = $tps_root . "data/xml/bozze.xml";
$query = "/bozze/bozza[@id = '$id_bozza']/tutorial_bozza/step[@num_step";
remove_1_1($xmlFile, $query, $num_step);

$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);
$bozza = $xpath->query("/bozze/bozza[@id = '$id_bozza']")->item(0);

$steps = $bozza->getElementsByTagName('tutorial_bozza')->item(0)->childNodes;

$k = 1;
foreach($steps as $step){
    $step->setAttribute('num_step', $k);
    $k++;
}

$doc->formatOutput = true;
$xmlString = $doc->saveXML();
file_put_contents($xmlFile, $xmlString);

$url = "../web/" . $_SESSION['Tipo_utente'] . "/anteprima_tutorial.php";
header("Location: $url");
exit;
?>