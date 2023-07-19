<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login/register s 2FA</title>
    <link rel="stylesheet" type="text/css" href="../style.css">

   
</head>
<body>
<header>
    <hgroup>
        <h1>Správa používateľov</h1>
        <h2>Registrácia a prihlásenie používateľa s 2FA</h2>
    </hgroup>
</header>
<main>

    <?php

    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        // Neprihlásený používateľ, zobraz odkaz na Login alebo Register stránku.
        echo '<p>Nie ste prihlásený, prosím <a href="login.php" class="login-register-link">prihláste sa</a> alebo sa <a href="register.php" class="login-register-link">zaregistrujte</a>.</p>';
    } else {
        // Prihlásený používateľ, zobraz odkaz na zabezpečenú stránku.
        echo '<h3>Vitaj ' . $_SESSION['fullname'] . ' </h3>';
        echo '<a href="prihlaseny_uzivatel.php">Zabezpečená stránka</a>';
    }

    ?>
</main>
</body>
</html>
