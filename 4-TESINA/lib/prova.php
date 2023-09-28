<?php
require_once('function.php');

$array = getCategoria('progetti.xml');

$prova = $array[0][0];
$prova1 = $array[0][1];
$prov = $array[0][2];
 
echo "$prova, $prova1, $prov";


?>