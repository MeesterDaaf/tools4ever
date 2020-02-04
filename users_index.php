<?php

require 'database.php';

//selecteer ALLE gebruikers
$sql = "SELECT * FROM users";
$statement = $db_conn->prepare($sql);
$statement->execute();
$database_gegevens = $statement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['role'])) { //bestaat role in get request?

    $role = $_GET['role'];

    //Selecter SPECIFIEKE gebruikers
    $sql = "SELECT * FROM users WHERE role = :ph_role";
    $statement = $db_conn->prepare($sql);
    $statement->bindParam(":ph_role", $role);
    $statement->execute();
    $database_gegevens = $statement->fetchAll(PDO::FETCH_ASSOC);
    // $database_gegevens wordt gebruikt bij foreach
}
?>

<?php include 'header.php'; ?>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>USERNAME</th>
                <th>EMAIL</th>
                <th>ROLE</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($database_gegevens as $key => $users_row) : ?>
                <tr>
                    <td>
                        <?php echo $users_row['id']; ?>
                    </td>
                    <td>
                        <?php echo $users_row['username']; ?>
                    </td>
                    <td>
                        <?php echo $users_row['email']; ?>
                    </td>
                    <td>
                        <?php
                        $roles = ['', 'Admin', 'Manager', 'Medewerker'];
                        echo $roles[$users_row['role']]; ?>
                    </td>
                    <td>
                        <a class="btn btn-warning" href="users_update.php?user_id=<?php echo $users_row['id']; ?>">Edit</a>
                        <a class="btn btn-danger" href="users_delete.php?user_id=<?php echo $users_row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>