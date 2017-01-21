<?php
/*
 Error numbers:
    1 - wrong data
    2 - system error
    3 - passwords mismatch
    4 - Wrong new password
    5 - wrong current password
 */
session_start();
function exitWithError($errorNumber){
    global $dbConnection;
    header("Location: ../view/change-password.php?error=$errorNumber");
    $dbConnection -> close();
    exit();
}

function checkInput($input){
    global $dbConnection;

    $cleanInput = htmlentities($input, ENT_QUOTES, "UTF-8");
    $cleanInput = mysqli_real_escape_string($dbConnection, $cleanInput);

    if ($input != $cleanInput){
        exitWithError(10);
    }
}

function query($query){
    global $dbConnection;

    try{
        $result = $dbConnection -> query($query);
        return $result;
    }catch (Exception $e){
        exitWithError(21);
    }
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword']) || !isset($_POST['newPassword2'])){
    header('Location: ../view/change-password.php');
    exit();
}

$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];
$newPassword2 = $_POST['newPassword2'];

require_once 'databaseConnect.php';

mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );

try{
    $dbConnection = new mysqli($host, $dbUser, $dbPassword, $dbName);
} catch (Exception $e){
    exitWithError(22);
}

checkInput($oldPassword);
checkInput($newPassword);
checkInput($newPassword2);

if (mb_strlen($newPassword, 'UTF-8') < 8 || mb_strlen($newPassword, 'UTF-8') > 30)
    exitWithError(41);

$result = query("SELECT password FROM customers WHERE id='{$_SESSION['id']}'");

if ($result -> num_rows != 1)
    exitWithError(23);

$customer = $result -> fetch_assoc();
$result -> free_result();

$currentPassword = $customer['password'];

if (!password_verify($oldPassword, $customer['password']))
    exitWithError(51);

if ($newPassword != $newPassword2)
    exitWithError(31);

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

query("UPDATE customers SET password='$hashedPassword' WHERE id='{$_SESSION['id']}'");

$dbConnection -> close();
header('Location: ../view/change-password.php?error=0');
