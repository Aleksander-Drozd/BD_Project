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
$dbConnection = @new mysqli($host, $dbUser, $dbPassword, $dbName);

$rentId = $_POST['return'];
$rentId = htmlentities($rentId, ENT_QUOTES, "UTF-8");
$rentId = mysqli_real_escape_string($dbConnection, $rentId);
$stationId = $_POST['stations'];
$stationId = htmlentities($stationId, ENT_QUOTES, "UTF-8");
$stationId = mysqli_real_escape_string($dbConnection, $stationId);

if($dbConnection -> connect_errno != 0)
    handleError('Blad systemu 1');

if($result = @$dbConnection -> query("select customer_id, bike_id, rent_date from rents_history WHERE id='$rentId'")){
    if ($result -> num_rows != 1)
        handleError('Blad systemu 2');

    $rent = $result -> fetch_assoc();
    $result -> free_result();

    $bikeId = $rent['bike_id'];
    $rentDate = DateTime::createFromFormat('Y-m-d H:i:s', $rent['rent_date']);

    if($rent['customer_id'] != $_SESSION['id'])
        handleError('Blad systemu 3');
}
else
    handleError('Blad systemu 4');

if ($result = @$dbConnection -> query("SELECT id FROM stations WHERE id='$stationId'")) {
    if ($result -> num_rows == 0)
        handleError('Blad systemu 5');
    $result -> free_result();
}else
    handleError('Blad systemu 6');

$dateTime = new DateTime();
$currentDate = $dateTime -> format('Y-m-d H:i:s');
$rentDuration = $dateTime -> diff($rentDate);
$charge = $rentDuration -> format('%d') * 50 + $rentDuration -> format('%h') * 5;

//ToDo Transaction
if (!@$dbConnection -> query("UPDATE rents_history SET return_date = '$currentDate', return_station_id = '$stationId', charge = '$charge' WHERE id = '$rentId'"))
    handleError('Blad systemu 7');
if (!@$dbConnection -> query("UPDATE bikes SET rented = 0, station_id = '$stationId' WHERE id = '$bikeId'"))
    handleError('Blad systemu 8');
if (!@$dbConnection -> query("UPDATE customers SET rented_bikes = rented_bikes - 1, wallet = wallet - '$charge' WHERE id = '{$_SESSION['id']}'"))
    handleError('Blad systemu 9');

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

