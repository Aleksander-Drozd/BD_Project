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
        <title>Wypozycz rower</title>

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
                    <a href="#" class="nav-link">Historia wypozyczen</a>
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

            <form action="../../rent.php" method="post">
                <label for="stations">Wybierz stacje: </label>
                <select name="stations" id="stations">
                    <?php

                    echo '<option value="20">ul. Marianska 15</option>';
                    echo '<option value="10">ul. Malopanewska 1</option>';
                    echo '<option value="5">ul. Danilowskiego 13a</option>';

                    ?>
                </select>
                <button>Wypozycz</button>
            </form>

            <?php
                if ( isset($_SESSION['rentSuccess']) ) {
                    echo '<div class="answer">
                            
                            Wypozyczono!
                          </div>';

                    unset($_SESSION['rentSuccess']);
                }
            ?>


        </main>

    </body>
</html>