<?php
session_start();

function handleError($errorMessage) {
    global $dbConnection;
    $_SESSION['rentError'] = '<span class="error">'.$errorMessage.'</span>';
    $dbConnection -> close();
    header('Location: view/html/rent-bike.php');
    exit();
}

if(!isset($_POST['stations'])){
    header("Location: view/html/index.php");
    exit();
}

require_once 'databaseConnect.php';
$dbConnection = @new mysqli($host, $dbUser, $dbPassword, $dbName);

$stationId = $_POST['stations'];
$stationId = htmlentities($stationId, ENT_QUOTES, "UTF-8");
$stationId = mysqli_real_escape_string($dbConnection, $stationId);

if($dbConnection -> connect_errno != 0) {
    handleError('Blad systemu');
}

if ($result = @$dbConnection -> query("SELECT id FROM stations WHERE id=$stationId")) {
    if ($result -> num_rows == 0)
        handleError('Nie udalo sie wypozyczyc roweru');
    $result -> free_result();
}else
    handleError('Blad systemu');

if ($result = @$dbConnection -> query("SELECT id FROM bikes WHERE station_id=$stationId LIMIT 1")) {
    if ($result -> num_rows == 0)
        handleError('Brak wolnych rowerow przy wybranej stacji');

    $bike = $result -> fetch_assoc();
    $bikeId = $bike['id'];
    $result -> free_result();
}else
    handleError('Blad systemu');

if ($_SESSION['wallet'] < 10){
    handleError('Za malo srodkow na koncie');
}

$dateTime = new DateTime();
$currentDateTime =  $dateTime -> format('Y-m-d H:i:s');

//INSERT INTO rents_history (id, customer_id, bike_id, rent_station_id, rent_date, return_station_id, return_date, charge)VALUES (NULL, 1, 3, 1, '2016-12-05 09:15:18', NULL, NULL, NULL);
//UPDATE 'bikes' SET 'rented' = 0, 'station_id' = NULL WHERE 'id' = 1;
//UPDATE 'customers' SET 'rented_bikes' = 1 WHERE 'id' = 5;
$insertRentQuery = "INSERT INTO rents_history (id, customer_id, bike_id, rent_station_id, rent_date, return_station_id, return_date, charge) VALUES (NULL, {$_SESSION['id']}, $bikeId, $stationId, '$currentDateTime', NULL, NULL, NULL);";
echo $insertRentQuery;
$incrementedRentedBikes = $_SESSION['rentedBikes'] + 1;

//ToDo Transaction

if (!@$dbConnection -> query($insertRentQuery))
    handleError('Blad systemu');
if (!@$dbConnection -> query("UPDATE bikes SET rented = 1, station_id = NULL WHERE id = $bikeId"))
    handleError('Blad systemu');
if (!@$dbConnection -> query("UPDATE customers SET rented_bikes = rented_bikes + 1 WHERE id = {$_SESSION['id']}"))
    handleError('Blad systemu');

if ($result = @$dbConnection -> query("select address from stations where id=$stationId")){
    $station = $result -> fetch_assoc();
    $rent['rentStationAddress'] = $station['address'];
    $result -> free_result();
}
else
    handleError('Blad systenu');

if ($result = @$dbConnection -> query("select id from rents_history where customer_id={$_SESSION['id']} AND rent_date='$currentDateTime'")){
    $data = $result -> fetch_assoc();
    $rent['rentId'] = $data['id'];
    $result -> free_result();
}
else
    handleError('Blad systemu');

$_SESSION['rentSuccess'] = true;
$_SESSION['rentedBikes']++;
$rent['rentDate'] = $currentDateTime;
$_SESSION['activeRents'][] = $rent;

$dbConnection -> close();
header("Location: view/html/rent-bike.php");