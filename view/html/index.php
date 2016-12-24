<?php
    session_start();
    if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
        header("Location: user.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wypozyczalnia rowerow</title>
    <link rel="stylesheet" href="../css/main-style.css">
</head>
<body>
    <h1>Wypozyczalnia rowerow</h1>
    <form action="../../login.php" method="post">
        <label for="login-input">E-mail:</label> <br>
        <input type="email" id="login-input" name="email"><br>
        <label for="password-input">Haslo:</label> <br>
        <input type="password" id="password-input" name="password"><br>
        <?php
            if(isset($_SESSION['error'])){
                echo $_SESSION['error']."<br>";
                unset($_SESSION['error']);
            }
        ?>
        <input type="submit" value="Zaloguj"><br>
    </form>
        Nie masz konta? <a href="registration.html">Zarejestruj sie</a>
</body>
</html>