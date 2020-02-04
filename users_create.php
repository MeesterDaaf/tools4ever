<?php

require 'database.php';

//check button press en of de velden gevuld zijn
if (isset($_POST['submit'])  && $_POST['username'] != '' && $_POST['email'] != '') {

    $username = $_POST['username'];
    $email    = $_POST['email'];
    $role     = $_POST['role_keuze'];

    //Insert USER in Database
    $sql = "INSERT INTO users ( username, email, role  ) VALUES (:ph_username, :ph_email, :ph_role)";
    $stmt = $db_conn->prepare($sql); //stuur naar mysql.
    $stmt->bindParam(":ph_username", $username); //verbind ALLE placeholders
    $stmt->bindParam(":ph_email", $email); //verbind ALLE placeholders
    $stmt->bindParam(":ph_role", $role); //verbind ALLE placeholders
    $stmt->execute();

    header('location: users_index.php'); //stuur gebruiker naar index
}
?>

<?php include 'header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <form method="post">
                <div class="form-group">
                    <label for="usernameInput">Username</label>
                    <input type="text" class="form-control" id="usernameInput" name="username">
                </div>
                <div class="form-group">
                    <label for="emailInput">Email</label>
                    <input type="email" class="form-control" id="emailInput" name="email">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role_keuze" id="manager_keuze" value="2" checked>
                    <label class="form-check-label" for="manager_keuze">
                        Manager
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="role_keuze" id="medewerker_keuze" value="3">
                    <label class="form-check-label" for="medewerker_keuze">
                        Medewerker
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>