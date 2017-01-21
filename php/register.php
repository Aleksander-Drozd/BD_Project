<?php
session_start();

function checkLength($string, $lowerBound, $upperBound, $name){
    if(isset($_SESSION['registrationErrors'][$name]))
        return;

    if (mb_strlen($string, 'UTF-8') < $lowerBound || mb_strlen($string, 'UTF-8') > $upperBound) {
        if ($lowerBound == $upperBound)
            $_SESSION['registrationErrors'][$name] = "To pole musi zawierac $lowerBound znakow";
        else
            $_SESSION['registrationErrors'][$name] = "To pole musi zawierac $lowerBound-$upperBound znakow";
    }
}

function validate($string, $name){
    global $dbConnection;

    if(isset($_SESSION['registrationErrors'][$name]))
        return;

    $validated = htmlentities($string, ENT_QUOTES, "UTF-8");
    $validated = mysqli_real_escape_string($dbConnection, $validated);

    if ($string != $validated)
        $_SESSION['registrationErrors'][$name] = 'Nieprawidlowe dane';
}

if (!isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['email']) || !isset($_POST['phoneNumber']) || !isset($_POST['password']) || !isset($_POST['passwordConfirmation'])) {
    header('Location: ../view/registration.php');
    exit();
}

$_SESSION['registrationErrors'] = array();

foreach ($_POST as $key => $input){
    if (empty($input))
        $_SESSION['registrationErrors'][$key] = 'To pole nie moze byc puste';
}

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phoneNumber = $_POST['phoneNumber'];
$password = $_POST['password'];
$passwordConfirmation = $_POST['passwordConfirmation'];

checkLength($firstName, 1, 30, 'firstName');
checkLength($lastName, 1, 30, 'lastName');
checkLength($email, 1, 50, 'email');
checkLength($phoneNumber, 9, 9, 'phoneNumber');
checkLength($password, 8, 30, 'password');

$sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
if (!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL) || $email != $sanitizedEmail)
    $_SESSION['registrationErrors']['email'] = 'Niepoprawny adres email';

if ($password != $passwordConfirmation)
    $_SESSION['registrationErrors']['passwordConfirmation'] = 'Hasla musza byc takie same';

require_once 'databaseConnect.php';
mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );

try{
    $dbConnection = new mysqli($host, $dbUser, $dbPassword, $dbName);
}
catch (Exception $e){
    $_SESSION['registrationErrors']['systemError'] = 'Blad systemu';
    exit();
}

if($result = $dbConnection -> query("SELECT email FROM customers WHERE email = '$email'")){
    if ($result -> num_rows != 0)
        $_SESSION['registrationErrors']['email'] = 'Podany email juz istnieje w bazie';
    $result -> free_result();
} else {
    $_SESSION['registrationErrors']['systemError'] = 'Blad systemu';
    header('Location: ../view/registration.php');
    exit();
}

validate($firstName, 'firstName');
validate($lastName, 'lastName');
validate($password, 'password');
validate($phoneNumber, 'phoneNumber');
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

if (!is_int($phoneNumber))
    $_SESSION['registrationErrors']['phoneNumber'] = 'Nieprawidlowy numer telefonu';

if (!empty($_SESSION['registrationErrors'])) {
    header('Location: ../view/registration.php');
    $dbConnection -> close();
    exit();
}

header('Location: ../view/index.php');

try{
    $dbConnection -> query("INSERT INTO customers (id, first_name, last_name, email, `password`, phone_number) VALUES (NULL, '$firstName', '$lastName', '$email', '$hashedPassword', '$phoneNumber')");
}catch (Exception $e){
    header('Location: ../view/registration.php');
    $_SESSION['registrationErrors']['systemError'] = 'Blad systemu';
}

$dbConnection -> close();
