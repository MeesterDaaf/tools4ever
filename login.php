<?php

if (session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
//als de gebruiker is ingelogd dat hoeft hij/zij natuurlijk niet deze pagina te zien
if (isset($_SESSION['user_id'])) {
    header('location: users_index.php');
}

include 'header.php';

require 'database.php'; //load database

$error_message = ''; //start met een lege error bericht

if (isset($_POST['submit']) && $_POST['email'] != '' && $_POST['password'] != '') {
    //als het formulier is ingevuld en verzonden dan deze code uitvoeren

    //selecteer een gebruiker op basis van het emailadres
    $sql = "SELECT * FROM users WHERE email = :ph_email";
    $statement = $db_conn->prepare($sql);
    $statement->bindParam(":ph_email", $_POST['email']); // placeholder = :ph_email
    $statement->execute();
    $database_gegevens = $statement->fetch(PDO::FETCH_ASSOC);

    //als $database_gegevens een array is, dan is er een gebruiker gevonden
    if (is_array($database_gegevens)) {

        if ($_POST['password']  == $database_gegevens['password']) {
            //Hoera!!! JE BENT INGELOGD!!!! HOERA!!!! YESYESYESYESYES!!!!!

            session_start();
            $_SESSION['user_id'] = $database_gegevens['id'];
            $_SESSION['role']    = $database_gegevens['role'];

            header('location: users_index.php');
        }
    }

    $error_message = 'Deze gegevens kloppen niet';
}



?>
<div class="container d-flex justify-content-center mt-4">

    <div class="col-6">
        <form method="post">
            <h4>Inloggen</h4>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" value="" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" value="" name="password" id="password" class="form-control">
            </div>
            <button type="submit" name="submit" class="btn btn-success">Login</button>

            <?php if ($error_message != '') : ?>
                <div class="alert alert-danger" role="alert">
                    A simple danger alert—check it out!
                </div>
            <?php endif; ?>
        </form>

    </div>
</div>