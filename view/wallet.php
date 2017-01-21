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
                        <a href="#" class="nav-link">Moje konto</a>
                    </li>
                </ol>
            </nav>

            <main class="rents">

                <div class="wallet-info">
                    <p>Stan konta:
                        <span>
                            <?php
                                echo $_SESSION['wallet'];
                            ?>
                        </span>
                         zl
                    </p>

                    <?php
                        if ($_SESSION['wallet'] < 0) {
                            echo '<div class="error">Ureguluj zalegle oplaty!</div>';
                        }
                    ?>

                    <form action="#" method="post">
                        <input id="money" type="text" />
                        <button class="addFunds" value="" name="money">Doladuj konto</button>
                    </form>
                </div>

                <div class="wallet-history">
                    <p>Historia portfela:</p>
                    <ul>
                        <?php
                            echo '<li>Zaplacono 14,50 zl</li>'
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