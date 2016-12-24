<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel uzytkownika</title>
</head>
<body>
    <h1>
        <?php
        echo $_SESSION['firstName']." ".$_SESSION['lastName'];
        ?>
    </h1>
    Stan portfela:
    <?php
    echo $_SESSION['wallet'];
    ?>
    <br>
    Wypozyczonych rowerow:
    <?php
    echo $_SESSION['rentedBikes'];
    ?>
</body>
</html>