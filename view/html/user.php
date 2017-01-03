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
        <title>Panel uzytkownika</title>

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
                            <a class="user-info__logout-button" href="../../logout.php">Wyloguj sie</a>
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
                if(isset($_SESSION['activeRents']))
                    foreach ($_SESSION['activeRents'] as $rent){
                        echo <<< EOT
                        <div class="rents__rent rents__rent--active">
                            <div class="rents__rent-info">
                                <span class="rents__rent-label">Data wypozyczenia:
                                    <span class="rents__rent-date">{$rent['rentDate']}</span>
                                </span>
                                <span class="rents__rent-label">Stacja wypozyczenia:
                                    <span class="rents__rent-station"> {$rent['rentStationAddress']}</span>
                                </span>
                            </div>
                            <div class="rents__rent-info">
                                <span class="rents__rent-label">Data oddania:
                                    <span class="rents__rent-date">--</span>
                                </span>
                                <span class="rents__rent-label">Stacja oddania:
                                    <span class="rents__rent-station">--</span>
                                </span>
                            </div>
                            <span class="rents__rent-label">
                                <form action="../../returnBike.php" method="post">
                                    <button name="return" value="{$rent['rentId']}">Oddawaj!</button>
                                </form>
                            </span>
                            <span class="rents__rent-label">Oplata:
                                <span class="rents__rent-cost"></span>
                            </span>
                        </div>
EOT;
                    }
                ?>
            </main>

        </div>
    </body>

</html>