<?php
    session_start();
    $rentId = $_POST['return'];

    foreach ($_SESSION['activeRents'] as $rent){
        if($rent['rentId'] == $rentId){
            unset($_SESSION['activeRents'][array_search($rent, $_SESSION['activeRents'])]);
            header("Location: view/html/user.php");
        }
    }