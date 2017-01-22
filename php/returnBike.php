<?php
session_start();

function handleError($errorMessage) {
    global $dbConnection;
    $_SESSION['returnError'] = '<span class="error">'.$errorMessage.'</span>';
    $dbConnection -> close();
    header('Location: ../view/user.php');
    echo '<span class="error">'.$errorMessage.'</span>';
    exit();
}

if(!isset($_POST['return']) || !isset($_POST['stations'])){
    header("Location: ../view/user.php");
    exit();
}

require_once 'databaseConnect.php';

try{
    $dbConnection = new mysqli($host, $dbUser, $dbPassword, $dbName);
}catch (mysqli_sql_exception $e){
    handleError('Blad systemu');
}

$rentId = $_POST['return'];
$rentId = htmlentities($rentId, ENT_QUOTES, "UTF-8");
$rentId = mysqli_real_escape_string($dbConnection, $rentId);
$stationId = $_POST['stations'];
$stationId = htmlentities($stationId, ENT_QUOTES, "UTF-8");
$stationId = mysqli_real_escape_string($dbConnection, $stationId);

try{
    $result = $dbConnection -> query("select customer_id, bike_id, rent_date from rents_history WHERE id='$rentId'");

    if ($result -> num_rows != 1)
        handleError('Blad systemu');

    $rent = $result -> fetch_assoc();
    $result -> free_result();

    $bikeId = $rent['bike_id'];
    $rentDate = DateTime::createFromFormat('Y-m-d H:i:s', $rent['rent_date']);

    if($rent['customer_id'] != $_SESSION['id'])
        handleError('Blad systemu 3');
}catch (mysqli_sql_exception $e){
    handleError('Blad systemu');
}

try{
    $result = $dbConnection -> query("SELECT id FROM stations WHERE id='$stationId'");

    if ($result -> num_rows == 0)
        handleError('Blad systemu');
    $result -> free_result();
}catch (mysqli_sql_exception $e){
    handleError('Blad systemu');
}

$dateTime = new DateTime();
$currentDate = $dateTime -> format('Y-m-d H:i:s');
$rentDuration = $dateTime -> diff($rentDate);
$charge = intval($rentDuration -> format('%d')) * 46;

if ($rentDuration -> format('%i') - 20 > 0) {
    $charge += (intval($rentDuration -> format('%h')) * 2) + 2;
} else {
    $charge += (intval($rentDuration -> format('%h')) * 2);
}

//ToDo Transaction
try{
    $dbConnection -> query("UPDATE rents_history SET return_date = '$currentDate', return_station_id = '$stationId', charge = '$charge' WHERE id = '$rentId'");
    $dbConnection -> query("UPDATE bikes SET rented = 0, station_id = '$stationId' WHERE id = '$bikeId'");
    $dbConnection -> query("UPDATE customers SET rented_bikes = rented_bikes - 1, wallet = wallet - '$charge' WHERE id = '{$_SESSION['id']}'");
}catch (mysqli_sql_exception $e){
    handleError('Blad systemu');
}

$dbConnection -> close();

$_SESSION['rentedBikes']--;
$_SESSION['wallet'] -= $charge;

foreach ($_SESSION['activeRents'] as $index => $rent){
    if($rent['rentId'] == $rentId){
        unset($_SESSION['activeRents'][$index]);
        header("Location: ../view/user.php");
        exit();
    }
}

