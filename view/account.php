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

            <?php
            require_once '../php/databaseConnect.php';

            mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );

            try{
                $dbConnection = new mysqli($host, $dbUser, $dbPassword, $dbName);
                $dbConnection -> set_charset('utf8');
            } catch (Exception $e){
                exit();
            }

            try{
                $result = $dbConnection -> query("SELECT email, phone_number FROM customers where id='{$_SESSION['id']}'");
                $customer = $result -> fetch_assoc();
                $result -> free_result();

                $email = $customer['email'];
                $phoneNumber = $customer['phone_number'];
            } catch (Exception $e){}

            ?>

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
                            if (isset($email))
                                echo $email;
                            ?>
                        </span>
                    </p>
                    <p>Telefon:
                        <span>
                            <?php
                            if (isset($phoneNumber))
                                echo $phoneNumber;
                            ?>
                        </span>
                    </p>
                    <p>
                    <form action="change-password.php" method="post">
                        <button>Zmien haslo</button>
                    </form>
                    </p>
                </div>
            </main>

        </div>

    </body>
</html>