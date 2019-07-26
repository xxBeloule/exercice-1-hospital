<?php
require_once 'connect.php';
if (count($_POST) > 0) {
    $error = false;
    $regexText = '/^[a-zA-Zèéçêëü\- ]{2,}$/';
    $regexPhone = '/^0[0-9]{9}/';
    $regexBirthdate = '/^[0-9]{4}(-[0-9]{2}){2}$/';

    if (empty($_POST['firstName']) || !preg_match($regexText, $_POST['firstName'])) {
        $error = true;
    }
    if (empty($_POST['lastName']) || !preg_match($regexText, $_POST['lastName'])) {
        $error = true;
    }
    if (empty($_POST['birthdate']) || !preg_match($regexBirthdate, $_POST['birthdate'])) {
        $error = true;
    }
    if (empty($_POST['mail']) || !filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL)) {
        $error = true;
    }
    if (empty($_POST['phone']) || !preg_match($regexPhone, $_POST['phone'])) {
        $error = true;
    }

    if (!$error) {
      if (connectDb()) {
          $db = connectDb();
        $pdoStat = $db->prepare('INSERT INTO patients VALUES (NULL, :lastName, :firstName, :birthdate, :phone, :mail)');
        $pdoStat->bindValue(':lastName', $_POST['lastName'], PDO::PARAM_STR);
        $pdoStat->bindValue(':firstName', $_POST['firstName'], PDO::PARAM_STR);
        $pdoStat->bindValue(':birthdate', $_POST['birthdate'], PDO::PARAM_STR);
        $pdoStat->bindValue(':phone', $_POST['phone'], PDO::PARAM_STR);
        $pdoStat->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR);

        $Isok = $pdoStat->execute();
      }  
    } 
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/lux/bootstrap.min.css" rel="stylesheet" integrity="sha384-hVpXlpdRmJ+uXGwD5W6HZMnR9ENcKVRn855pPbuI/mwPIEKAuKgTKgGksVGmlAvt" crossorigin="anonymous">
        <title>Page d'inscription</title>
        <style media="screen">
            .background{
                margin: 100px;
                padding: 20px;
                background: skyblue;
                border: 2px solid black;
                border-radius: 20px 20px 20px 20px;
                text-align: center;
                box-shadow: 10px 10px 10px 10px;
            }
            label,input {
                margin: auto;
                display: block;
            }
            h1 {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h1>Page d'inscription</h1>
        <?php
        if ($Isok) {
            ?>
            <div class="background">
                <p class="alert alert-success">L'ajout du patient a bien été pris en compte</p>
                <a href="../exo2/liste-patients.php">Cliquez pour voir la liste des patients</a>
            </div>
        <?php } else { ?>
            <div class="background">
                <form class="" action="#" method="post">
                    <label for="lastName">Nom : </label>
                    <input type="text" name="lastName" value="" required>
                    <label for="firstName">Prénom : </label>
                    <input type="text" name="firstName" value="" required>
                    <label for="birthdate">Date de naissance :</label>
                    <input type="date" name="birthdate" value="" required>
                    <label for="phone">Téléphone :</label>
                    <input type="tel" name="phone" value="" required>
                    <label for="mail">Email :</label>
                    <input type="email" name="mail" value="" required>
                    <input type="submit" name="submit" value="Valider">
                </form>
            </div>
        <?php }
        ?>
    </body>
</html>
