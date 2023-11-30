<?php

    session_start();
    require_once('functions.php');
    $xmlFile = "../data/xml/tutorials.xml";
    $img_dir_path = "../img/steps/";

    if(!isset($_POST['descrizione']) || empty($_POST['descrizione'])){
        exit;
    } else {
        $descrizione = $_POST['descrizione']; 
    }

    if(!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])){
        exit;
    } else {
        $id_progetto = $_POST['id_progetto']; 
    }

    if(!isset($_POST['num_step'])){

        exit;

    } elseif(!empty($_POST['num_step']) || $_POST['num_step'] === '0'){

        $num_step = (int)$_POST['num_step'] + 1; 

    }

    if(!isset($_FILES['img']['tmp_name']) || empty($_FILES['img']['tmp_name'])){
        exit;
    } else {
        $img_location = $_FILES['img']['tmp_name']; 
    }

    $doc = getDOMdocument($xmlFile);
    $xpath = new DOMXPath($doc);

    $tutorial = $xpath->query("/tutorials_progetti/tutorial_progetto[@id_progetto = '$id_progetto']")->item(0);

    $prev_step = $xpath->query("/tutorials_progetti/tutorial_progetto[@id_progetto = '$id_progetto']/step[@num_step = '$_POST[num_step]']")->item(0);

    $newStep = $doc->createElement('step'); 
    $descrizione = $doc->createElement('descrizione', $descrizione);
    $newStep->appendChild($descrizione);  

    if($prev_step->nextSibling === null){

        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $nome_file_img = $img_dir_path .  "img_step_" . $num_step . "_proj_" . $id_progetto . "." . $ext;
        $newStep->setAttribute('num_step', $num_step);
        $newStep->setAttribute('nome_file_img', $nome_file_img); 
        $tutorial->appendChild($newStep);

        $fd = fopen($nome_file_img, 'w');
        $img = file_get_contents($img_location); 

        if($fd){

            fwrite($fd, $img);
            fclose($fd);

        } else {

            exit; 

        }


    } else {

        $k = 1;
        $tutorial->insertBefore($newStep, $prev_step->nextSibling);
        $steps = $tutorial->childNodes;

        foreach($steps as $step){

            $old_path_file_img = $step->getAttribute('nome_file_img'); 

            if($k !== $num_step){
                $ext = pathinfo($old_path_file_img, PATHINFO_EXTENSION); //estensione immagine step k-esimo != $num_step inserito
            } else {
                $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION); //estensione immagine inserita
            }

            $new_path_file_img = $img_dir_path . "img_step_" . $k . "_proj_" . $id_progetto . "." . $ext; 

            if($old_path_file_img !== $new_path_file_img){ //se lo step ha sfasati i num step e l'url del file img

                if(file_exists($old_path_file_img)){

                    rename($old_path_file_img, $new_path_file_img);

                } 

                $step->setAttribute('nome_file_img', $new_path_file_img);

                if($k === $num_step){

                    $fd = fopen($new_path_file_img, 'w'); 
                    $img = file_get_contents($img_location); 

                    if($fd){

                    fwrite($fd, $img);
                    fclose($fd);

                    } else {

                    exit; 

                    }
                }

            }
            
            $step->setAttribute('num_step', $k);;
            $k++;
        }
    }
    

    $doc->formatOutput = true;
    $xmlString = $doc->saveXML();
    file_put_contents($xmlFile, $xmlString);

    header('Location: ../prove_funzioni/prova_aggiungi_step.php');
    exit; 

?>