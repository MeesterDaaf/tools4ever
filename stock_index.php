<?php include 'header.php'; //hier staat de sessie_start() functie in

require 'database.php';
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}

//selecteer ALLE Voorraad
$sql = "SELECT *, products.name as product_name, locations.name as location_name FROM stock 
            JOIN products ON products.id = stock.product_id 
            JOIN locations ON locations.id = stock.location_id";
// WHERE location = :ph_location";
$statement = $db_conn->prepare($sql);
$statement->execute();
$database_gegevens = $statement->fetchAll(PDO::FETCH_ASSOC);

// print_r($database_gegevens);


$location_name = '';


if (isset($_GET['location'])) {

    $location = $_GET['location'];

    //get stock data
    $sql = "SELECT *, locations.name as location_name, products.name as product_name
    FROM stock 
    JOIN locations ON locations.id = stock.location_id
    JOIN products ON products.id = stock.product_id
    WHERE locations.id = :ph_location";
    $statement = $db_conn->prepare($sql);
    $statement->bindParam(":ph_location", $location);
    $statement->execute();
    $database_gegevens = $statement->fetchAll(PDO::FETCH_ASSOC);


    //get location data
    $sql = "SELECT * FROM locations WHERE id = :ph_id";
    $statement = $db_conn->prepare($sql);
    $statement->bindParam(":ph_id", $location);
    $statement->execute();
    $location = $statement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['location'] = $location;

    $location_name = $location['name'];
}

$_SESSION['database_gegevens'] = $database_gegevens;

?>
<div class="container">
    <h3 class="display-4">Voorraad <?php echo $location_name ?></h3>
    <table class="table mb-3 mt-3">
        <caption><a href="pdf.php">Genereer PDF</a></caption>
        <thead>
            <tr>
                <th>locatie</th>
                <th>Product</th>
                <th>Inkoopsprijs</th>
                <th>Verkoopsprijs</th>
                <th>Aantal</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_products = 0;
            foreach ($database_gegevens as $key => $stock_row) : ?>
                <tr>
                    <td>
                        <?php echo $stock_row['location_name']; ?>
                    </td>
                    <td>
                        <?php echo $stock_row['product_name']; ?>
                    </td>
                    <td>
                        <?php echo $stock_row['purchase_price']; ?>
                    </td>
                    <td>
                        <?php echo $stock_row['selling_price']; ?>
                    </td>
                    <td>
                        <?php echo $stock_row['amount']; ?>
                    </td>
                    <td>
                        <?php $total_products = $total_products + $stock_row['amount']; ?>
                    </td>

                </tr>
            <?php endforeach ?>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2"><strong>Totale aantal producten:</strong></td>
                <td><strong><?php echo $total_products; ?></strong></td>
            </tr>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>