<?php

require 'database.php';

//selecteer ALLE Producten
$sql = "SELECT * FROM products";
$statement = $db_conn->prepare($sql);
$statement->execute();
$database_gegevens = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include 'header.php'; ?>
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
                        <?php echo $product_row['name']; ?>
                    </td>
                    <td>
                        <?php echo $product_row['factory_id']; ?>
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