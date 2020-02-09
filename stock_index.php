<?php

require 'database.php';

//selecteer ALLE Voorraad
$sql = "SELECT *, products.name as product_name, locations.name as location_name FROM stock 
            JOIN products ON products.id = stock.product_id 
            JOIN locations ON locations.id = stock.location_id";
// WHERE location = :ph_location";
$statement = $db_conn->prepare($sql);
$statement->execute();
$database_gegevens = $statement->fetchAll(PDO::FETCH_ASSOC);

print_r($database_gegevens);
?>

<?php include 'header.php'; ?>
<div class="container">
    <h3 class="display-4">Voorraad</h3>
    <table class="table mb-3 mt-3">
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