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
        <title>Rejestracja</title>
        <link rel="stylesheet" href="../css/registration.css">
    </head>
    <body>
        <form action="../../register.php" method="post">
            <p><label for="first-name-input">Imie</label>
            <input type="text" id="first-name-input" name="firstName"></p>
            <p><label for="first-name-input">Nazwisko</label>
            <input type="text" id="last-name-input" name="lastName"></p>
            <p> <label for="email-input">E-mail</label>
            <input type="text" id="email-input" name="email"></p>
            <p><label for="phone-number-input">Numer telefonu</label>
            <input type="text" id="phone-number-input" name="phoneNumber"></p>
            <p><label for="password-input">Haslo</label>
            <input type="text" id="password-input" name="password"></p>
            <p><label for="passowrd-confirm-input">Powtorz haslo</label>
            <input type="text" id="passowrd-confirm-input" name="passwordConfirmation"></p>
            <input type="submit" value="Zarejstruj sie">
        </form>
    </body>
</html>