<?php include 'header.php'; //hier staat de sessie_start() functie in


require 'database.php';
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}

//selecteer ALLE Producten
$sql = "SELECT *, products.name as product_name, factories.name as factory_name  FROM products 
                JOIN factories ON factories.id = products.factory_id";

$statement = $db_conn->prepare($sql);
$statement->execute();
$database_gegevens = $statement->fetchAll(PDO::FETCH_ASSOC);

// print_r($database_gegevens);


?>


<div class="container">
    <h3 class="display-4">Product Prijzen</h3>
    <table class="table mb-3 mt-3">
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>Factory</th>
                <th>Inkoopsprijs</th>
                <th>Verkoopsprijs</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($database_gegevens as $key => $product_row) : ?>
                <tr>
                    <td>
                        <?php echo $product_row['id']; ?>
                    </td>
                    <td>
                        <?php echo $product_row['product_name']; ?>
                    </td>
                    <td>
                        <?php echo $product_row['factory_name']; ?>
                    </td>
                    <td>
                        <?php echo $product_row['purchase_price']; ?>
                    </td>
                    <td>
                        <?php echo $product_row['selling_price']; ?>
                    </td>
                    <td>
                        <a class="btn btn-warning" href="products_update.php?product_id=<?php echo $product_row['id']; ?>">Edit</a>
                        <a class="btn btn-danger" href="products_delete.php?product_id=<?php echo $product_row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>