<?php
    session_start();   
    include('../../conn.php');
    $root = "../../";
    require_once($root . "lib/get_nodes.php");
    $id_utente = $_SESSION['id_utente'];

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/standard/bozze.css" />

  </head>

  <body>

    <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione">
          <div class="logo">TPS</div>
        </div>
        <div class="homepage-sidebar-list">
          <a class="elem" href="homepage.php">Homepage</a>
          <a class="elem" href="bacheca.php">Bacheca</a>
          <a class="elem">Progetti</a>
          <a class="elem">Bozze</a>
          <a class="elem">Storico</a>
          <div class="divisore"></div>
          <a class="elem">Logout</a>
        </div>
      </div>
      <div class="dashboard">
        <div class="toolbar"></div>
        <div class="cards">

        
        <div class="container">
        <table class="user-list">
            <thead>
                <tr>
                    <th><span>ID</span></th>
                    <th><span>Created</span></th>
                    <th>Tools</th>
                </tr>
            </thead>

        <?php