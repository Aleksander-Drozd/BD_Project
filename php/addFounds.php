<?php
/*
 Error codes:
    0 - everything good
    1 - database error
    2 - user entered NaN
 */
session_start();

if(!isset($_POST['money'])) {
    header("Location: ../view/wallet.php");
    exit();
}

$addedFounds = $_POST['money'];

if (!$addedFounds = intval($addedFounds)){
    header('Location: ../view/wallet.php?error=2');
    exit();
}

require_once 'databaseConnect.php';
mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );

try{
    $dbConnection = new mysqli($host, $dbUser, $dbPassword, $dbName);
    $dbConnection -> query("UPDATE customers SET wallet = wallet + '$addedFounds' WHERE id='{$_SESSION['id']}'");
} catch (Exception $e){
    header('Location: ../view/wallet.php?error=1');
    exit();
}

$_SESSION['wallet'] += $addedFounds;

header('Location: ../view/wallet.php?error=0');
