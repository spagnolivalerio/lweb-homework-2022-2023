<?php
session_start();

if(isset($_POST['num_step'])){
    $num_step = $_POST['num_step'];
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

if(isset($_POST['id_progetto'])){
    $id_progetto = $_POST['id_progetto'];

} elseif(isset($_GET['anteprima']) && $_GET['anteprima'] === "true"){
    
    switch($_SESSION['Tipo_utente']){
    case "standard": 
        header("Location: ../web/standard/anteprima_tutorial.php?num_step=$num_step"); 
        break;
    case "moderatore":
        header("Location: ../web/moderatore/anteprima_tutorial.php?num_step=$num_step"); 
        break;
    case "admin":
        header("Location: ../web/admin/anteprima_tutorial.php?num_step=$num_step");
        break;
    default: 
        header("Location: ../web/visitatore/anteprima_tutorial.php?num_step=$num_step");
        break;
    }
    exit;
}else{
    exit;
}

switch($_SESSION['Tipo_utente']){
    case "standard": 
        header("Location: ../web/standard/view.php?num_step=$num_step&id_progetto=$id_progetto"); 
        break;
    case "moderatore":
        header("Location: ../web/moderatore/view.php?num_step=$num_step&id_progetto=$id_progetto"); 
        break;
    case "admin":
        header("Location: ../web/admin/view.php?num_step=$num_step&id_progetto=$id_progetto");
        break;
    default: 
        header("Location: ../web/visitatore/view.php?num_step=$num_step&id_progetto=$id_progetto");
        break;
}

exit; 

?>