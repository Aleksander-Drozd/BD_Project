<?php
session_start();

if(!isset($_POST['money']) || !is_numeric($_POST['money'])) {
    header("Location: ../view/wallet.php");
    exit();
}

$_SESSION['wallet'] += $_POST['money'];

//TODO add money to db

