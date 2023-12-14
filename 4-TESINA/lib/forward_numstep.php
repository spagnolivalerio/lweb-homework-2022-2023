<?php

if(!empty($_POST['num_step'])){
    $num_step = $_POST['num_step'];
} else {
    header('Location: ../web/index.php');
    exit;
}

if(!empty($_POST['action'])){
    $action = $_POST['action'];    
} else {
    header('Location: ../web/index.php');
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
    case 'standard': 
        header("Location: ../web/standard/view-discussioni.php?num_step=$num_step"); 
        break;
    case 'moderatore':
        header("Location: ../web/moderatore/view-discussioni.php?num_step=$num_step"); 
        break;
    case 'admin':
        header("Location: ../web/admin/view-discussioni.php?num_step=$num_step");
        break;
    default:
        header('Location: ../web/index.php');
}

exit; 
?>