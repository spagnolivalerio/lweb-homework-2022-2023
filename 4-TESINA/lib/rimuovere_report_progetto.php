<?php

session_start();
require_once 'functions.php';

if (!isset($_SESSION['Tipo_utente'])) {
    header('Location:../web/login.php');
    exit();
}



if (!isset($_POST['id_report']) || empty($_POST['id_report'])) {
    exit();
} else {
    $id_report = $_POST['id_report'];
}

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit();
} else {
    $id_progetto = $_POST['id_progetto'];
}


//RIMUOVI DA REPORTS_PROGETTI.XML

$xmlFile = "../data/xml/reports_progetti.xml";
$query = "/reports_progetti/report_progetto[@id";
remove_1_1($xmlFile, $query, $id_report);


//RIMUOVI DA PROGETTI.XML
$xmlFile = "../data/xml/progetti.xml";

$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

foreach ($nodes as $node) {

    if ($id_progetto === $node->getAttribute('id')) {

        $proReports = $node->getElementsByTagName('reports_progetti')->item(0);
        $proReport = $proReports->childNodes;

        foreach ($proReport as $report) {

            if ($id_report === $report->getAttribute('id_report')) {

                $proReports->removeChild($report);
                $doc->formatOutput = true;
                $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
                file_put_contents($xmlFile, $xmlString);

                break;

            }
        }
    }
}

$url = "../web/" . $_SESSION['Tipo_utente'] . "/view_segnalazioni.php";
header("Location: $url");
exit;


?>




