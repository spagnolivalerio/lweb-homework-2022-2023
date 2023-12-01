<?php

session_start();
require_once 'functions.php';
$xmlFile = "../data/xml/tutorials.xml";
$img_dir_path = "../img/steps/";

if (!isset($_POST['id_progetto']) || empty($_POST['id_progetto'])) {
    exit;
} else {
    $id_progetto = $_POST['id_progetto'];
}

if (!isset($_POST['num_step']) || empty($_POST['num_step'])) {
    exit;
} else {
    $num_step = $_POST['num_step'];
}

$img_path = $img_dir_path . "img_step_" . $num_step . "_proj_" . $id_progetto;

$doc = getDOMdocument($xmlFile);
$xpath = new DOMXPath($doc);

?>