<?php
session_start();

if(isset($_POST['num_step'])){
    $num_step = $_POST['num_step'];
} else {
    exit;
}

if(isset($_POST['id_progetto'])){
    $id_progetto = $_POST['id_progetto'];
} else {
    exit;
}

if(!empty($_POST['action'])){
    $action = $_POST['action'];    
} else {
    exit; 
}

if($action === "next"){
    $num_step++;
} elseif($action === "prev"){
    $num_step--;
} else{
    exit;
}

switch($_SESSION['Tipo_utente']){
    case "standard": 
        header("Location: ../web/standard/view-discussioni.php?num_step=$num_step&id_progetto=$id_progetto"); 
        break;
    case "moderatore":
        header("Location: ../web/moderatore/view-discussioni.php?num_step=$num_step&id_progetto=$id_progetto"); 
        break;
    case "admin":
        header("Location: ../web/admin/view-discussioni.php?num_step=$num_step&id_progetto=$id_progetto");
        break;
    default: 
        header("Location: ../index.php");
        break;
}

exit; 

?>