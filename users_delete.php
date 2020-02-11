<?php include 'header.php'; //hier staat de sessie_start() functie in

require 'database.php';
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}


$id  = $_GET['user_id'];

//Verwijder een USER uit de database
$sql = "DELETE FROM users WHERE id = :ph_id";
$stmt = $db_conn->prepare($sql); //stuur naar mysql.
$stmt->bindParam(":ph_id", $id);
$stmt->execute();

header('location: users_index.php');
