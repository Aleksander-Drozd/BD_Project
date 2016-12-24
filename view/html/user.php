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
    <p>Stan portfela:
    <?php
    echo $_SESSION['wallet'];
    ?>
    </p>
    <p>Wypozyczonych rowerow:
    <?php
    echo $_SESSION['rentedBikes'];
    ?>
    </p>
</body>
</html>