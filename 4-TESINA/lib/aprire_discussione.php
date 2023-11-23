<?php

    session_start();
    require_once('functions.php');
    $xmlFile = "../data/xml/discussioni.xml";

    if(!isset($_POST['titolo']) || empty($_POST['titolo'])){
        exit;
    } else {
        $newTitolo = $_POST['titolo']; 
    }

    if(!isset($_POST['descrizione']) || empty($_POST['descrizione'])){
        exit;
    } else {
        $newDescrizioneValue = $_POST['descrizione']; 
    }

    if(!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])){
        exit;
    } else {
        $id_progetto = $_POST['id_progetto']; 
    }

    $id_poster = $_SESSION['id_utente'];
    $id_discussione = generate_id($xmlFile);

    //AGGIUNTA IN DISCUSSIONI.XML

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;

    $newDiscussione = $doc->createElement('discussione');
    $newDiscussione->setAttribute('titolo', $newTitolo);
    $newDiscussione->setAttribute('id_poster', $id_poster);
    $newDiscussione->setAttribute('risolta', 'false');
    $newDiscussione->setAttribute('id_discussione', $id_discussione);
    $newDiscussione->setAttribute('id_progetto', $id_progetto);

    $newDescrizione = $doc->createElement('descrizione', $newDescrizioneValue);

    $newDiscussione->appendChild($newDescrizione);

    $root->appendChild($newDiscussione);

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
    file_put_contents($xmlFile, $xmlString);

    //AGGIUNTA IN PROGETTI.XML
    
    $xmlFile = "../data/xml/progetti.xml";
    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;
    $nodes = $root->childNodes;

    foreach($nodes as $node){
     
        if($id_progetto === $node->getAttribute('id')){

            $proDiscussione = $doc->createElement('discussione');
            $proDiscussione->setAttribute('id_discussione', $id_discussione);
            $discussioni = $doc->getElementsByTagName('discussioni')->item(0);
            $discussioni->appendChild($proDiscussione);

            $doc->formatOutput = true;
            $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
            file_put_contents($xmlFile, $xmlString);

            break; 
        }
    }

    header('Location: ../prove_funzioni/prova_aggiungi_discussione.php');
    exit();

?>