<?php
session_start();

function handleError($errorMessage) {
    global $dbConnection;
    $_SESSION['rentError'] = '<span class="error">'.$errorMessage.'</span>';
    $dbConnection -> close();
    header('Location: ../view/rent-bike.php');
    exit();
}

if(!isset($_POST['stations'])){
    header("Location: ../view/index.php");
    exit();
}

require_once 'databaseConnect.php';
mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );

try{
    $dbConnection = @new mysqli($host, $dbUser, $dbPassword, $dbName);
}catch (mysqli_sql_exception $e){
    handleError('Blad systemu');
}

$stationId = $_POST['stations'];
$stationId = htmlentities($stationId, ENT_QUOTES, "UTF-8");
$stationId = mysqli_real_escape_string($dbConnection, $stationId);

try{
    $result = $dbConnection -> query("SELECT id FROM stations WHERE id=$stationId");

    if ($result -> num_rows == 0)
        handleError('Nie udalo sie wypozyczyc roweru');
    $result -> free_result();

    $result = $dbConnection -> query("SELECT id FROM bikes WHERE station_id=$stationId LIMIT 1");
    if ($result -> num_rows == 0)
        handleError('Brak wolnych rowerow przy wybranej stacji');

    $bike = $result -> fetch_assoc();
    $bikeId = $bike['id'];
    $result -> free_result();
}catch (mysqli_sql_exception $e){
    handleError('Blad systemu');
}

if ($_SESSION['wallet'] < 10)
    handleError('Za malo srodkow na koncie');
if ($_SESSION['rentedBikes'] > 5)
    handleError('Wypozyczono maksymalną ilosc rowerow');

$dateTime = new DateTime();
$currentDateTime =  $dateTime -> format('Y-m-d H:i:s');

$insertRentQuery = "INSERT INTO rents_history (id, customer_id, bike_id, rent_station_id, rent_date, return_station_id, return_date, charge) VALUES (NULL, {$_SESSION['id']}, $bikeId, $stationId, '$currentDateTime', NULL, NULL, NULL);";

//ToDo Transaction

try{
    $dbConnection -> query($insertRentQuery);
    $dbConnection -> query("UPDATE bikes SET rented = 1, station_id = NULL WHERE id = $bikeId");
    $dbConnection -> query("UPDATE customers SET rented_bikes = rented_bikes + 1 WHERE id = {$_SESSION['id']}");
}catch (mysqli_sql_exception $e){
    handleError('Blad systemu');
}

try{
    $result = $dbConnection -> query("select address from stations where id=$stationId");
    $station = $result -> fetch_assoc();
    $rent['rentStationAddress'] = $station['address'];
    $result -> free_result();
}catch (mysqli_sql_exception $e){
    handleError('Blad systemu');
}

try{
    $result = @$dbConnection -> query("select id from rents_history where customer_id={$_SESSION['id']} AND rent_date='$currentDateTime'");
    $data = $result -> fetch_assoc();
    $rent['rentId'] = $data['id'];
    $result -> free_result();
}catch (mysqli_sql_exception $e){
    handleError('Blad systemu');
}

$rent['rentDate'] = $currentDateTime;
$_SESSION['rentSuccess'] = true;
$_SESSION['rentedBikes']++;
$_SESSION['activeRents'][] = $rent;

$dbConnection -> close();
header("Location: ../view/rent-bike.php");