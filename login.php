<?php
    require_once "databaseConnect.php";
    session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $dbConnection = @new mysqli($host, $dbUser, $dbPassword, $dbName);

    if($dbConnection -> connect_errno != 0)
        echo "Blad polaczenia z baza danych";
    else{
        $query = "Select * from customers where email='$email' and password='$password'";

        if($result = @$dbConnection -> query($query)){
            if($result -> num_rows == 1){
                $data = $result -> fetch_assoc();

                $_SESSION['firstName'] = $data['first_name'];
                $_SESSION['lastName'] = $data['last_name'];
                $_SESSION['wallet'] = $data['wallet'];
                $_SESSION['rentedBikes'] = $data['rented_bikes'];

                $result -> free_result();
                header("Location: view/html/user.php");
            }else{
                $_SESSION['error'] = '<span class="error">Nieprawidlowy login lub haslo</span>';
                header("Location: view/html/index.php");
            }
        }

        $dbConnection -> close();
    }
