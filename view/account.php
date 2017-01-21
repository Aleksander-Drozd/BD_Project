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
        <title>Zarzadzaj portfelem</title>

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
                        <a href="account.php" class="nav-link">Moje konto</a>
                    </li>
                </ol>
            </nav>

            <main class="rents">
                <div>
                    <p>Imie:
                        <span>
                            <?php
                                echo $_SESSION['firstName'];
                            ?>
                        </span>
                    </p>
                    <p>Nazwisko:
                        <span>
                            <?php
                                echo $_SESSION['lastName'];
                            ?>
                        </span>
                    </p>
                    <p>E-mail:
                        <span>
                            <?php
                                //TODO Get e-mail from db
                            ?>
                        </span>
                    </p>
                    <p>
                        <form action="change-password.php" method="post">
                            <button>Zmien haslo</button>
                        </form>
                    </p>
                    <p>Telefon:
                        <span>
                            <?php
                                // TODO Get phone number form db
                            ?>
                        </span>
                    </p>
                </div>
            </main>

        </div>

    </body>
</html>