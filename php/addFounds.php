<?php
/*
 Error codes:
    0 - everything good
    1 - database error
    2 - user entered NaN
 */
session_start();
require_once '../classes/DatabaseUtil.php';

if(!isset($_POST['money'])) {
    header("Location: ../view/wallet.php");
    exit();
}

$addedFounds = $_POST['money'];

if ($addedFounds != floatval($addedFounds)){
    header('Location: ../view/wallet.php?error=2');
    exit();
}

$statement = DatabaseUtil::prepare('UPDATE customers SET wallet = wallet + ? WHERE id = ?');

try{
    $statement -> bindParam(1, $addedFounds);
    $statement -> bindParam(2, $_SESSION['id']);

    $statement -> execute();
} catch (PDOException $e){
    header('Location: ../view/wallet.php?error=1');
    exit();
}

$_SESSION['wallet'] += $addedFounds;

header('Location: ../view/wallet.php?error=0');
