<?php

    session_start();

    if(!isset($_SESSION['Tipo_utente'])){
        header('Location: ../web/login.php');
        exit;
    }

    require_once('functions.php');
    $xmlFile = "../data/xml/reports_commenti.xml";

    if(!isset($_POST['testo']) || empty($_POST['testo'])){
        exit;
    } else {
        $newTestoValue = $_POST['testo'];
    }

    if(!isset($_POST['tipo']) || empty($_POST['tipo'])){
        exit;
    } else {
        $newTipoValue = $_POST['tipo'];
    }

    if(!isset($_POST['id_commento']) || empty($_POST['id_commento'])){
        exit;
    } else {
        $id_commento = $_POST['id_commento']; 
    }

    $id_segnalatore = $_SESSION['id_utente'];
    $id_segnalazione = generate_id($xmlFile);
    $data_ora = new DateTime();
    $data_ora = $data_ora->format('Y-m-d H:i:s');

    //AGGIUNTA IN REPORTS_COMMENTI.XML

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;

    $newReport = $doc->createElement('report_commento');
    $newReport->setAttribute('id', $id_segnalazione);
    $newReport->setAttribute('id_commento', $id_commento);
    $newReport->setAttribute('id_utente', $id_segnalatore);
    $newReport->setAttribute('data_ora', $data_ora);

    $newTipo = $doc->createElement('tipo', $newTipoValue);
    $newTesto = $doc->createElement('testo', $newTestoValue);

    $newReport->appendChild($newTipo);
    $newReport->appendChild($newTesto);

    $root->appendChild($newReport);

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
    file_put_contents($xmlFile, $xmlString);

    //AGGIUNTA IN COMMENTI.XML

    $xmlFile = "../data/xml/commenti.xml";
    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;
    $nodes = $root->childNodes;

    foreach($nodes as $node){
        
        if($id_commento === $node->getAttribute('id')){

            $comReport = $doc->createElement('report_commento');
            $comReport->setAttribute('id_report', $id_segnalazione);
            $comReportsCommenti = $node->getElementsByTagName('reports_commenti')->item(0);
            $comReportsCommenti->appendChild($comReport);

            $doc->formatOutput = true;
            $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
            file_put_contents($xmlFile, $xmlString);

            break; 
        }
    }

    //AGGIUNTA IN STORICI.XML   

    $xmlFile = "../data/xml/storici.xml";
    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;
    $nodes = $root->childNodes;

    foreach($nodes as $node){

        if($_SESSION['id_utente'] === $node->getAttribute('id_utente')){


            $stoReport = $doc->createElement('report_commento');
            $stoReport->setAttribute('id_report', $id_segnalazione);
            $stoReport->setAttribute('tipo', $newTipoValue);
            $stoReports = $node->getElementsByTagName('reports_commenti')->item(0);
            $stoReports->appendChild($stoReport);

            $doc->formatOutput = true;
            $xmlString = $doc->saveXML(); 
            file_put_contents($xmlFile, $xmlString);

            break; 

        }
    }

    header('Location: ../prove_funzioni/prova_segnalazione_commento.php');
    exit;

?>