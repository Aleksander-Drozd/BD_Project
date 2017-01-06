<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Historia wypozyczen</title>

    <link rel="stylesheet" href="../css/main-theme.css">
</head>
<body>

<div class="containter">

    <header>
        <h1>Wypozyczalnia Rowerow</h1>
        <p>Zadzwon!!!</p>
    </header>

    <nav class="navigation">
        <ol class="navigation__list">
            <li>
                <div class="user-info">
                    <p class="user-info__user-name">
                        <?php
                        echo $_SESSION['firstName'] . " " . $_SESSION['lastName'];
                        ?>
                    </p>
                    Stan portfela:
                    <span class="user-info__details">
                        <?php
                        echo $_SESSION['wallet'].'zl';
                        ?>
                    </span><br>
                    Wypozyczonych rowerow:
                    <span class="user-info__details">
                        <?php
                        echo $_SESSION['rentedBikes'];
                        ?>
                    </span>
                    <a class="user-info__logout-button" href="../php/logout.php">Wyloguj sie</a>
                </div>
            </li>
            <li>
                <a href="user.php" class="nav-link">Panel glowny</a>
            </li>
            <li>
                <a href="rent-bike.php" class="nav-link">Wypozycz rower</a>
            </li>
            <li>
                <a href="rents-history.php" class="nav-link">Historia wypozyczen</a>
            </li>
            <li>
                <a href="wallet.php" class="nav-link">Zarzadzaj portfelem</a>
            </li>
            <li>
                <a href="#" class="nav-link">Moje konto</a>
            </li>
        </ol>
    </nav>

    <main class="rents">
        <?php
        require_once '../php/databaseConnect.php';
        $dbConnection = @new mysqli($host, $dbUser, $dbPassword, $dbName);

        if($dbConnection -> connect_errno != 0)
            echo "Blad polaczenia z baza danych";
        else if ($result = @$dbConnection -> query("SELECT * FROM rents_history WHERE customer_id={$_SESSION['id']} AND return_date IS NOT NULL ORDER BY return_date desc")) {
            while ($rent = mysqli_fetch_assoc($result)) {
                if ($r = @$dbConnection -> query("SELECT address FROM stations WHERE id={$rent['rent_station_id']}")) {
                    $station = $r -> fetch_assoc();
                    $rentStation = $station['address'];
                }
                if ($r = @$dbConnection -> query("SELECT address FROM stations WHERE id={$rent['return_station_id']}")) {
                    $station = $r -> fetch_assoc();
                    $returnStation = $station['address'];
                }
                echo <<< EOT
                    <div class="rents__rent rents__rent--active">
                        <div class="rents__rent-info">
                            <span class="rents__rent-label">Data wypozyczenia:
                                <span class="rents__rent-date">{$rent['rent_date']}</span>
                            </span>
                            <span class="rents__rent-label">Stacja wypozyczenia:
                                <span class="rents__rent-station">$rentStation</span>
                            </span>
                        </div>
                        <div class="rents__rent-info">
                            <span class="rents__rent-label">Data oddania:
                                <span class="rents__rent-date">{$rent['return_date']}</span>
                            </span>
                            <span class="rents__rent-label">Stacja oddania:
                                <span class="rents__rent-station">$returnStation</span>
                            </span>
                        </div>
                        <span class="rents__rent-label">Oplata:
                            <span class="rents__rent-cost">{$rent['charge']}</span>
                        </span>
                    </div>
EOT;
            }
            $result -> free_result();
        }
        $dbConnection -> close();
            foreach ($_SESSION['activeRents'] as $rent){

            }
        ?>
    </main>

</div>
</body>

</html>