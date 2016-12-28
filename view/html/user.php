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

        <link rel="stylesheet" href="../css/user.css">
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
                        <a href="#" class="nav-link">Wypozycz rower</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">Historia wypozyczen</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">Zarzadzaj portfelem</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">Moje konto</a>
                    </li>
                </ol>
            </nav>

            <main class="rents">

                <div class="rents__rent rents__rent--active">
                    <div class="rents__rent-info">
                        <span class="rents__rent-label">Data wypozyczenia:
                            <span class="rents__rent-date">
                                <?php
                                //TODO data wypozyczenia
                                ?>
                            </span>
                        </span>
                        <span class="rents__rent-label">Stacja wypozyczenia:
                            <span class="rents__rent-station">
                                <?php
                                //TODO stacja wypozyczenia
                                ?>
                            </span>
                        </span>
                    </div>
                    <div class="rents__rent-info">
                        <span class="rents__rent-label">Data oddania:
                            <span class="rents__rent-date">
                                <?php
                                //TODO data oddania
                                ?>
                            </span>
                        </span>
                        <span class="rents__rent-label">Stacja oddania:
                            <span class="rents__rent-station">
                                <?php
                                //TODO stacja oddania
                                ?>
                            </span>
                        </span>
                    </div>
                    <span class="rents__rent-label">
                        <form action="#" method="post">
                            <button name="return" value="">Oddawaj!</button>
                        </form>
                    </span>
                    <span class="rents__rent-label">Oplata:
                        <span class="rents__rent-cost">
                            <?php
                            //TODO wygenerowac oplate
                            ?>
                        </span>
                    </span>
                </div>

            </main>

        </div>
    </body>
</html>