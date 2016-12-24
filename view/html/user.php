<?php
    session_start();
    if(!isset($_SESSION['logged'])){
        header("Location: index.php");
        exit();
    }
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
    <a href="../../logout.php">Wyloguj sie</a>
</body>
</html>