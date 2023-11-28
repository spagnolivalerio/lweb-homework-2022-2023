<?php

    session_start();
    require_once('functions.php');
    $xmlFile = "../data/xml/progetti.xml";

    if(!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])){
        exit;
    } else {
        $id_progetto = $_POST['id_progetto'];
    }

    //RIMUOVI DA PROGETTI.XML

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement; 
    $xpath = new DOMXPath($doc); 

    $progetto = $xpath->query("/progetti/progetto[@id = '$id_progetto']")->item(0);

    $root->removeChild($progetto);

    $doc->formatOutput = true; 
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    //RIMUOVI DA TUTORIALS.XML

    $xmlFile = "../data/xml/tutorials.xml";
    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement; 
    $xpath = new DOMXPath($doc); 
  
    $tutorial = $xpath->query("/tutorials/tutorial[@id_progetto = '$id_progetto']")->item(0);
    
    if($tutorial !== NULL){ //con l'array non devo controllare perchè se è vuoto il foreach non si esegue; 

        $root->removeChild($tutorial);

    }
  
    $doc->formatOutput = true; 
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    //RIMUOVI DA VALUTAZIONI.XML
    
    //RIMUOVI DA DISCUSSIONI.XML
    
    $xmlFile = "../data/xml/discussioni.xml"; 
    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement; 
    $xpath = new DOMXPath($doc);
    $id_discussioni = array();

    $discussioni = $xpath->query("/discussioni/discussione[@id_progetto = '$id_progetto']"); 

    foreach($discussioni as $discussione){

        array_push($id_discussioni, $discussione->getAttribute('id'));
        $root->removeChild($discussione);
    
    }

    $doc->formatOutput = true; 
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    //RIMUOVI DA RICHIESTE_ACCESSO_DISCUSSIONI.XML

    $xmlFile = "../data/xml/richieste_accesso_discussioni.xml"; 
    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement; 
    $xpath = new DOMXPath($doc);
    $array_richieste = array();

    foreach($id_discussioni as $id_discussione){

        $richieste = $xpath->query("/richieste/richiesta[@id_discussione = '$id_discussione']");
        
        foreach($richieste as $richiesta){

            array_push($array_richieste, $richiesta); 
        }
    }

    foreach($array_richieste as $to_remove_ric){

        $root->removeChild($to_remove_ric);
    }

    $doc->formatOutput = true; 
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    //RIMUOVI DA COMMENTI.XML

    $xmlFile = "../data/xml/commenti.xml"; 
    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement; 
    $xpath = new DOMXPath($doc);
    $array_commenti = array();
    $array_id_commenti = array();

    foreach($id_discussioni as $id_discussione){

        $commenti = $xpath->query("/commenti/commento[@id_discussione = '$id_discussione']");

        foreach($commenti as $commento){

            array_push($array_commenti, $commento); 

        }
    }

    foreach($array_commenti as $to_remove_com){

        array_push($array_id_commenti, $to_remove_com->getAttribute('id')); 
        $root->removeChild($to_remove_com);
    }

    $doc->formatOutput = true; 
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    header('Location: ../prove_funzioni/prova_rimuovi_progetto.php');
    exit; 

?>