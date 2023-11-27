<?php 

    function getDOMdocument($xmlFile){ 

        $xmlstring = "";
        foreach (file($xmlFile) as $node){ //riscrive il file come un'unica stringa
            $xmlstring .= trim($node);
        }

        $doc = new DOMDocument(); //creo un oggetto DOMdocument
        if(!$doc->loadXML($xmlstring)){  //carico il file xml privo di spazi bianchi dentro all'oggetto doc
            exit;
        }

        return $doc;

    }

    function uploadXML($xmlFile){

        $doc = getDOMdocument($xmlFile); 
        $root = $doc->documentElement; //creo una variabile radice alla quale assegno il primo elemento del file xml
        $elementi = $root->childNodes; //childNodes restituisce una lista di nodi, i nodi figli di $root

        return $elementi; //array di childnodes della root del file xml

    }

    function generate_id($xmlFile){

        $nodes = uploadXML($xmlFile);

        if(empty($nodes)){
            return 1;
        }

        foreach($nodes as $node){
            
            $maxID = 1; 
            $currentID = $node->getAttribute('id');

            if($currentID > $maxID){
                $maxID = $currentID;
            }
        }

        $maxID++;

        return $maxID;
    }

    function ban(){};

    function sban(){};

    function mod_tipo_utente(){};

    function valutare_commento(){};

    function chiudi_discussione(){};

?>