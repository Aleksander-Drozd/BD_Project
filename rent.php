<?php

session_start();

echo $_POST['stations'];

$_SESSION['rentSuccess'] = true;

header("Location: view/html/rent-bike.php");