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

if (!isset($_POST['id_commento']) || empty($_POST['id_commento'])) {
    exit();
} else {
    $id_commento = $_POST['id_commento'];
}


//RIMUOVI DA REPORTS_COMMENTI.XML

$xmlFile = "../data/xml/reports_commenti.xml";
$query = "/reports_commenti/report_commento[@id";
remove_1_1($xmlFile, $query, $id_report);


//RIMUOVI DA COMMENTI.XML
$xmlFile = "../data/xml/commenti.xml";

$doc = getDOMdocument($xmlFile);
$root = $doc->documentElement;
$nodes = $root->childNodes;

foreach ($nodes as $node) {

    if ($id_commento === $node->getAttribute('id')) {

        $comReports = $node->getElementsByTagName('reports_commento')->item(0);
        $comReport = $comReports->childNodes;

        foreach ($comReport as $report) {

            if ($id_report === $report->getAttribute('id_report')) {

                $comReports->removeChild($report);
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


