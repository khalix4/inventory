<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

// Check user type for access control
$query = 'SELECT ID, t.TYPE
            FROM users u
            JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = ' . $_SESSION['MEMBER_ID'] . '';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $Aa = $row['TYPE'];

    if ($Aa == 'User') {
?>
<script type="text/javascript">
    alert("Restricted Page! You will be redirected to POS");
    window.location = "pos.php";
</script>
<?php
    }
}

// Fetch categories for the dropdown
$sql = "SELECT DISTINCT CNAME, CATEGORY_ID FROM category ORDER BY CNAME ASC";
$result = mysqli_query($db, $sql) or die("Bad SQL: $sql");

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Fetch product details for editing based on PRODUCT_ID
if (isset($_GET['id'])) {
    $productID = mysqli_real_escape_string($db, $_GET['id']);
    $query = "SELECT p.PRODUCT_ID, p.PRODUCT_NAME, p.COST_PER_CARTON, p.QTY_PER_CARTON,
                     p.PROFIT_PERCENTAGE, p.TOTAL_QTY, p.MANUFACTURE_DATE, p.EXPIRY_DATE,
                     p.BARCODE_TEXT, p.BARCODE_IMAGE, p.NOTES, p.COST_PER_ITEM,
                     p.SELLING_PRICE_PER_ITEM, p.CATEGORY_ID
              FROM product p
              WHERE p.PRODUCT_ID = '$productID' LIMIT 1"; // Limit 1 as PRODUCT_ID is primary key
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        // Assign fetched values to variables
        $zz = $product['PRODUCT_ID'];
        $productName = $product['PRODUCT_NAME'];
        $costPerCarton = $product['COST_PER_CARTON'];
        $qtyPerCarton = $product['QTY_PER_CARTON'];
        $profitPercentage = $product['PROFIT_PERCENTAGE'];
        $totalQty = $product['TOTAL_QTY'];
        $manufactureDate = $product['MANUFACTURE_DATE'];
        $expiryDate = $product['EXPIRY_DATE'];
        $barcodeText = $product['BARCODE_TEXT'];
        $barcodeImage = $product['BARCODE_IMAGE'];
        $notes = $product['NOTES'];
        $costPerItem = $product['COST_PER_ITEM']; // Calculated, but fetched for display
        $sellingPricePerItem = $product['SELLING_PRICE_PER_ITEM']; // Calculated, but fetched for display
        $selectedCategoryId = $product['CATEGORY_ID'];
    } else {
        echo '<div class="alert alert-danger">Product not found.</div>';
        exit;
    }
} else {
    echo '<div class="alert alert-danger">No product selected for editing.</div>';
    exit;
}
?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Edit Product</h4>
        </div>
        <a href="product.php" type="button" class="btn btn-primary bg-gradient-primary">Back to Product List</a>
        <div class="card-body">

            <form role="form" method="post" action="pro_edit1.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $zz; ?>" />

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Product Name:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Product Name" name="product_name"
                            value="<?php echo $productName; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Cost Per Carton:
                    </div>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" min="0" class="form-control" placeholder="Cost Per Carton"
                            name="cost_per_carton" id="cost_per_carton" value="<?php echo $costPerCarton; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Quantity Per Carton:
                    </div>
                    <div class="col-sm-9">
                        <input type="number" min="1" class="form-control" placeholder="Quantity Per Carton"
                            name="qty_per_carton" id="qty_per_carton" value="<?php echo $qtyPerCarton; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Profit Percentage (%):
                    </div>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" min="0" class="form-control" placeholder="Profit Percentage (%)"
                            name="profit_percentage" id="profit_percentage" value="<?php echo $profitPercentage; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left">
                    <div class="col-sm-3 text-primary" style="padding-top: 5px;">
                        Cost Price per Item:
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="cost_per_item" name="cost_per_item"
                            value="<?php echo number_format($costPerItem, 2); ?>" readonly>
                    </div>
                </div>

                <div class="form-group row text-left">
                    <div class="col-sm-3 text-primary" style="padding-top: 5px;">
                        Selling Price per Item:
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="selling_price_per_item" name="selling_price_per_item"
                            value="<?php echo number_format($sellingPricePerItem, 2); ?>" readonly>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Total Quantity:
                    </div>
                    <div class="col-sm-9">
                        <input type="number" min="0" class="form-control" placeholder="Total Quantity"
                            name="total_qty" value="<?php echo $totalQty; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Manufacture Date:
                    </div>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" placeholder="Manufacture Date"
                            name="manufacture_date" value="<?php echo $manufactureDate; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Expiry Date (Optional):
                    </div>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" placeholder="Expiry Date (Optional)"
                            name="expiry_date" value="<?php echo $expiryDate; ?>">
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Barcode Text (Optional):
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Barcode Text (Optional)" name="barcode_text"
                            value="<?php echo $barcodeText; ?>">
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Barcode Image (Optional):
                    </div>
                    <div class="col-sm-9">
                        <?php if ($barcodeImage && file_exists($barcodeImage)): ?>
                            <img src="<?php echo $barcodeImage; ?>" alt="Current Barcode"
                                style="max-width: 150px; height: auto; margin-bottom: 10px; border: 1px solid #ddd; padding: 3px;">
                            <br>
                            <small class="text-muted">Current image. Upload new to change.</small>
                        <?php else: ?>
                            <small class="text-muted">No barcode image uploaded.</small>
                        <?php endif; ?>
                        <input type="file" class="form-control-file mt-2" id="barcode_image" name="barcode_image" accept="image/*">
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Notes (Optional):
                    </div>
                    <div class="col-sm-9">
                        <textarea rows="3" cols="50" class="form-control" placeholder="Notes (Optional)"
                            name="notes"><?php echo $notes; ?></textarea>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Category:
                    </div>
                    <div class="col-sm-9">
                        <select class="form-control" name="category" required>
                            <option value="" disabled hidden>Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['CATEGORY_ID']; ?>"
                                    <?php echo ($cat['CATEGORY_ID'] == $selectedCategoryId) ? 'selected' : ''; ?>>
                                    <?php echo $cat['CNAME']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Update</button>
            </form>
        </div>
    </div>
</center>

<?php include '../includes/footer.php'; ?>

<script>
    // JavaScript to automatically calculate Cost Per Item and Selling Price Per Item
    document.addEventListener('DOMContentLoaded', function () {
        const costPerCartonInput = document.getElementById('cost_per_carton');
        const qtyPerCartonInput = document.getElementById('qty_per_carton');
        const profitPercentageInput = document.getElementById('profit_percentage');
        const costPerItemInput = document.getElementById('cost_per_item');
        const sellingPricePerItemInput = document.getElementById('selling_price_per_item');

        function calculatePrices() {
            const costPerCarton = parseFloat(costPerCartonInput.value);
            const qtyPerCarton = parseInt(qtyPerCartonInput.value);
            const profitPercentage = parseFloat(profitPercentageInput.value);

            let costPerItem = 0;
            if (!isNaN(costPerCarton) && !isNaN(qtyPerCarton) && qtyPerCarton > 0) {
                costPerItem = costPerCarton / qtyPerCarton;
            }
            costPerItemInput.value = costPerItem.toFixed(2);

            let sellingPricePerItem = 0;
            if (!isNaN(costPerItem) && !isNaN(profitPercentage) && costPerItem > 0 && profitPercentage >= 0) {
                sellingPricePerItem = costPerItem * (1 + profitPercentage / 100);
            }
            sellingPricePerItemInput.value = sellingPricePerItem.toFixed(2);
        }

        // Call once on load to populate if values exist
        calculatePrices();

        // Attach event listeners
        costPerCartonInput.addEventListener('input', calculatePrices);
        qtyPerCartonInput.addEventListener('input', calculatePrices);
        profitPercentageInput.addEventListener('input', calculatePrices);
    });
</script>