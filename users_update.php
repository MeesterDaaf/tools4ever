<?php include 'header.php'; //hier staat de sessie_start() functie in

require 'database.php';
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}


$id = $_GET['user_id'];

//check button press en of de velden gevuld zijn
if (isset($_POST['submit']) && $_POST['username'] != '' && $_POST['email'] != '') {

    $username = $_POST['username'];
    $email    = $_POST['email'];
    $role     = $_POST['role_keuze'];

    //UPDATE EEN WAARDE IN EEN DATABASE TABEL
    $sql = "UPDATE users SET username = :ph_username, email = :ph_email, role = :ph_role WHERE id = :ph_id ";
    $stmt = $db_conn->prepare($sql); //stuur naar mysql.
    $stmt->bindParam(":ph_username", $username);
    $stmt->bindParam(":ph_email", $email); //verbind variabelen met ALLE placeholders: 3 stuks in query = 3 stuks met bindParam
    $stmt->bindParam(":ph_role", $role); //verbind ALLE placeholders
    $stmt->bindParam(":ph_id", $id);
    $stmt->execute();

    //als dit hierboven succesvol is??? dan sturen we de gebruiker naar de index
    header('location: users_index.php');
}


$sql = "SELECT * FROM users WHERE id = :ph_id";
$statement = $db_conn->prepare($sql);
$statement->bindParam(":ph_id", $id);
$statement->execute();
$database_gegevens = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col">
            <form method="post">
                <div class="form-group">
                    <label for="usernameInput">Username</label>
                    <input type="text" class="form-control" id="usernameInput" name="username" value="<?php echo $database_gegevens['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="emailInput">Email</label>
                    <input type="email" class="form-control" id="emailInput" name="email" value="<?php echo $database_gegevens['email']; ?>">
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