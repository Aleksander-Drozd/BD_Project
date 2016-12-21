<?php
    require_once "databaseConnect.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $dbConnection = new mysqli($host, $dbUser, $dbPassword, $dbName);

    if($dbConnection -> connect_errno != 0)
        echo "Blad polaczenia z baza danych";
    else{
        $query = "Select * from customers where email='$email' and password='$password'";
        $result = $dbConnection -> query($query);
        $data = $result -> fetch_assoc();
        echo $data['first_name']."<br>";
        echo $data['last_name']."<br>";
        $result -> free_result();
        $dbConnection -> close();
    }


