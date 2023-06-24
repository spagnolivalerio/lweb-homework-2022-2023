<?php

$doc = new DOMDocument();
$doc->load('../../xml/automobili.xml');
if(!$doc->schemaValidate('../../xsd/auto.xsd')){
	echo "Il file non è conforme allo schema";
} else {
	echo "Il file segue in modo corretto il suo xsd";
}

?>