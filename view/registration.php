<?php
session_start();

function displayError($name){
    if (isset($_SESSION['registrationErrors'][$name]))
        echo "<span class=\"error\">{$_SESSION['registrationErrors'][$name]}</span><br>";
}

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
        <link rel="stylesheet" href="../css/main-style.css">
    </head>
    <body>
        <?php
        displayError('systemError');
        ?>
        <form action="../php/register.php" method="post">
            <p><label for="first-name-input">Imie</label>
            <input type="text" id="first-name-input" name="firstName"></p>
            <?php
            displayError('firstName');
            ?>
            <p><label for="first-name-input">Nazwisko</label>
            <input type="text" id="last-name-input" name="lastName"></p>
            <?php
            displayError('lastName');
            ?>
            <p> <label for="email-input">E-mail</label>
            <input type="text" id="email-input" name="email"></p>
            <?php
            displayError('email');
            ?>
            <p><label for="phone-number-input">Numer telefonu</label>
            <input type="text" id="phone-number-input" name="phoneNumber"></p>
            <?php
            displayError('phoneNumber');
            ?>
            <p><label for="password-input">Haslo</label>
            <input type="password" id="password-input" name="password"></p>
            <?php
            displayError('password');
            ?>
            <p><label for="passowrd-confirm-input">Powtorz haslo</label>
            <input type="password" id="passowrd-confirm-input" name="passwordConfirmation"></p>
            <?php
            displayError('passwordConfirmation');
            ?>
            <input type="submit" value="Zarejstruj sie">
        </form>
    </body>
</html>
<?php
unset($_SESSION['registrationErrors'])
?>