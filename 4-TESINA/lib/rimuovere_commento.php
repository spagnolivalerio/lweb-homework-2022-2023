<?php 

    session_start();

    if(!isset($_SESSION['Tipo_utente'])){
        header('Location:../web/login.php');
        exit();
    }

    require_once('functions.php');
    $xmlFile = "../data/xml/commenti.xml";

    //HO BISOGNO DI PORTARMI DIETRO SIA L'IDENTIFICATIVO DEL COMMENTO CHE DELLA DISCUSSIONE

    if(!isset($_POST['id_commento']) || empty($_POST['id_commento'])){
        exit();
    }else{
        $id_commento = $_POST['id_commento'];
    }


    if(!isset($_POST['id_discussione']) || empty($_POST['id_discussione'])){
        exit();
    }else{
        $id_discussione = $_POST['id_discussione'];
    }

    //RIMUOVI DA COMMENTI.XML

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;
    $nodes = $root->childNodes;

    foreach($nodes as $node){

        if($id_commento === $node->getAttribute('id')){
            
            $root->removeChild($node);

            $doc->formatOutput = true;
            $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
            file_put_contents($xmlFile, $xmlString);

            break; 
        }    
    }

    //RIMUOVI DA DISCUSSIONI.XM

    $xmlFile = "../data/xml/discussioni.xml";

    $doc = getDOMdocument($xmlFile);
    $root = $doc->documentElement;
    $nodes = $root->childNodes;

    foreach($nodes as $node){

        if($id_discussione === $node->getAttribute('id')){

            $discCommenti = $node->getElementsByTagName('commenti')->item(0);
            $discCommento = $discCommenti->childNodes;

            foreach($discCommento as $commento){

                if($id_commento === $commento->getAttribute('id_commento')){

                    $discCommenti->removeChild($commento);
                    $doc->formatOutput = true;
                    $xmlString = $doc->saveXML(); //ottengo il file xml come stringa
                    file_put_contents($xmlFile, $xmlString);

                    break; 

                }
            }
        }    
    }

    header('Location: ../prove_funzioni/rimuovi_commento.php');
    exit;

?>