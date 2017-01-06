<?php
    session_start();

    if(!isset($_POST['return'])){
        header("Location: ../view/user.php");
        exit();
    }
    
    $rentId = $_POST['return'];

    foreach ($_SESSION['activeRents'] as $index => $rent){
        if($rent['rentId'] == $rentId){
            unset($_SESSION['activeRents'][$index]);
            header("Location: ../view/user.php");
            exit();
        }
    }
