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

                <div class="wallet-info">
                    <p>Stan konta:
                        <span>
                            <?php
                                echo $_SESSION['wallet'].' zl';
                            ?>
                        </span>
                    </p>

                    <?php
                        if ($_SESSION['wallet'] < 0) {
                            echo '<div class="error">Ureguluj zalegle oplaty!</div>';
                        }
                    ?>

                    <form action="../php/addFounds.php" method="post">
                        <label for="money">Kwota doladowania:</label><br>
                        <input type=text id="money" name="money">
                        <button type="submit">Doladuj konto</button>
                    </form>
                </div>

                <div class="wallet-history">
                    <?php
                    if(isset($_GET['error'])){
                        switch ($_GET['error']){
                            case 0:
                                echo 'Pomyslnie dodano fundusze<br>';
                                break;
                            case 1:
                                echo '<span class="error">Nie udalo sie doladowac konta</span><br>';
                                break;
                            case 2:
                                echo 'Wprowadzono niepoprawna kwote<br>';
                                break;
                            default:
                                break;
                        }
                    }
                    ?>
                    <p>Historia portfela:</p>
                    <ul>
                        <?php
                        require_once '../php/databaseConnect.php';
                        mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );

                        try{
                            $dbConnection = new mysqli($host, $dbUser, $dbPassword, $dbName);
                            $result = $dbConnection -> query("SELECT return_date, charge from rents_history where customer_id='{$_SESSION['id']}' AND return_date IS NOT NULL ORDER BY return_date desc");

                            if($result -> num_rows == 0)
                                exit();
                        } catch (Exception $e){
                            exit();
                        }
                        
                        while ($rent = $result -> fetch_assoc()){
                            $charge = $rent['charge'];

                            if ($charge == 0)
                                continue;

                            $date = $rent['return_date'];
                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $date);

                            if ($date != false)
                                $date = $date -> format('d-m-y H:i');

                            $charge = $rent['charge'];

                            echo "<li>$date -$charge zl</li>";
                        }

                        $result -> free_result();
                        $dbConnection -> close();
                        ?>
                    </ul>
                </div>

            </main>

        </div>

        <script>
            const button = document.querySelector( '.addFunds' );

            function addFunds( e ) {
                e.preventDefault();

                const value = document.getElementById( 'money' ).value;
                this.value = value;

                const wallet = document.querySelector( '.wallet-info span' );

                const current = parseFloat( wallet.innerHTML.replace( ',', '.' ) );
                const added = parseFloat( value.replace( ',', '.' ) );

                wallet.innerHTML =  current + added;
            }

            //button.addEventListener( 'click', addFunds );
        </script>

    </body>
</html>