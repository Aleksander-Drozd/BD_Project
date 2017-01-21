<?php
session_start();

function displayError($errorMessage){
    echo "<span class='error'>$errorMessage</span><br><br>";
}

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
    <link rel="stylesheet" href="../css/change-password.css">
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
        <?php
        if (isset($_GET['error'])){
            switch ($_GET['error']){
                case 0:
                    echo 'Haslo pomyslnie zmienione <br><br>';
                    break;
                case 1:
                    displayError('Bledne dane');
                    break;
                case 2:
                    displayError('Blad systemu');
                    break;
                case 3:
                    displayError('Podane hasla nie sa takie same');
                    break;
                case 4:
                    displayError('Bledne haslo');
                    break;
                case 5:
                    displayError('Bledne aktualne haslo');
                    break;
                default:
                    break;
            }
        }
        ?>
        <div>
            <form action="../php/changePassword.php" method="post">
                <label for="oldPassword">Podaj stare haslo: </label>
                <input type="password" name="oldPassword"><br>
                <label for="newPassword">Podaj nowe haslo: </label>
                <input type="password" name="newPassword"><br>
                <label for="newPassword2">Powtorz nowe haslo: </label>
                <input type="password" name="newPassword2"><br><br>
                <button type="submit">Zapisz</button>
            </form>
        </div>
    </main>

</div>

</body>
</html>