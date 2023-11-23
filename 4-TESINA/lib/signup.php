<?php

    session_start();
    require_once('../conn.php');
   
    $conn = connect_to_db($servername, $db_username, $db_password, $db_name);

    $campi = [$_POST['nome'], $_POST['cognome'], $_POST['e-mail'], $_POST['indirizzo'], $_POST['username'], $_POST['password']];

    $not_empty = array_reduce($campi, function($true, $campo){return $true && !empty($campo);}, true); //array_reduce riduce tutti i valori dell'array in un unico valore con l'ausilio di una variabile $true con cui esegue ad ogni iterazione $$ con !empty($campo), $campo singolo campo dell'array $campi

    if($not_empty){

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $email = mysqli_real_escape_string($conn, $_POST['e-mail']);
        $indirizzo = mysqli_real_escape_string($conn, $_POST['indirizzo']);

    } else {

        $_SESSION['credenziali'] = false; 
        header('Location: ../web/signup.php');
        exit;

    }

    $_QUERY_username_uguale = "SELECT * 
                               FROM utente
                               WHERE username = '$username'";
                               
    $_QUERY_email_uguale = "SELECT *
                            FROM utente
                            WHERE email = '$email'";

    $rows = mysqli_query($conn, $_QUERY_username_uguale);

    if(!$rows){
        header('Location: ../web/signup.php');
		exit;
    }

    if(mysqli_num_rows($rows) > 0){
        $_SESSION['username_esistente'] = true;
        header('Location: ../web/singup.php');
        exit;
    }

    $rows = mysqli_query($conn, $_QUERY_email_uguale);

    if(!$rows){
        header('Location: ../web/signup.php');
		exit;
    }

    if(mysqli_num_rows($rows) > 0){
        $_SESSION['email_esistente'] = true;
        header('Location: ../web/singup.php');
        exit;
    }

    $_QUERY_inserimento_utente = "INSERT INTO utente (nome, cognome, username, password, email, indirizzo)
                                  VALUES ('$nome', '$cognome', '$username', '$password', '$email', '$indirizzo')";

    $_QUERY_cerca_id = "SELECT id 
                        FROM utente 
                        WHERE username = '$username'";

    if(!mysqli_query($conn, $_QUERY_inserimento_utente)){

        $_SESSION['utente_creato']['per_storico'] = false;
        $_SESSION['utente_creato']['per_login'] = false;

    } else {

        $_SESSION['utente_creato']['per_storico'] = true;
        $_SESSION['utente_creato']['per_login'] = true;

        $result = mysqli_query($conn, $_QUERY_cerca_id);
        $row = mysqli_fetch_array($result);
        $_SESSION['id_utente'] = $row['id']; //per la creazione dello storico -> $_SESSION['id_utente'] viene sempre risettata ad ogni login, quindi posso riutilizzarla in questa fase che è subito dopo la creazione di storico, dopodiche unsetto;

        header('Location: crea_storico.php'); 
        exit;
    }

    header('Location: ../web/login.php');
    $conn->close();
    exit; 

?>