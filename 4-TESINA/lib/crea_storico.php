<?php

    session_start();
    require_once('functions.php');
    $xmlFile = "../data/xml/storici.xml";

    if(!$_SESSION['utente_creato']['per_storico']){
        header('Location: ../web/signup.php');
        exit; 
    }

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement; 
    
    $newStorico = $doc->createElement('storico');
    $newStorico->setAttribute('id_utente', $_SESSION['id_utente']);

    unset($_SESSION['id_utente']);

    $stoProgetti = $doc->createElement('progetti');
    $stoRichieste = $doc->createElement('richieste');
    $stoCommenti = $doc->createElement('commenti');
    $stoValutazioni = $doc->createElement('valutazioni');
    $stoReports_progetti = $doc->createElement('reports_progetti');
    $stoReports_commenti = $doc->createElement('reports_commenti');

    $newStorico->appendChild($stoProgetti);
    $newStorico->appendChild($stoRichieste);
    $newStorico->appendChild($stoCommenti);
    $newStorico->appendChild($stoValutazioni);
    $newStorico->appendChild($stoReports_progetti);
    $newStorico->appendChild($stoReports_commenti);
    
    $root->appendChild($newStorico);

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    header('Location: ../web/login.php');
    exit; 
?>