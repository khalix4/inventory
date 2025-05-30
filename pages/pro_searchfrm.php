<?php
// Include connection and sidebar files
include '../includes/connection.php';
include '../includes/sidebar.php';

// Check user type for access control
$query = 'SELECT ID, t.TYPE
          FROM users u
          JOIN type t ON t.TYPE_ID = u.TYPE_ID
          WHERE ID = ' . $_SESSION['MEMBER_ID'];
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $userType = $row['TYPE'];
    if ($userType == 'User') {
        echo '<script type="text/javascript">
                alert("Restricted Page! You will be redirected to POS");
                window.location = "pos.php";
              </script>';
        exit;
    }
}

// Fetch product details using the product ID from the URL
if (isset($_GET['id'])) {
    $productID = mysqli_real_escape_string($db, $_GET['id']); // Sanitize input
    $query = "SELECT p.PRODUCT_ID, p.PRODUCT_NAME, p.COST_PER_CARTON, p.QTY_PER_CARTON,
                     p.PROFIT_PERCENTAGE, p.TOTAL_QTY, p.MANUFACTURE_DATE, p.EXPIRY_DATE,
                     p.BARCODE_TEXT, p.BARCODE_IMAGE, p.NOTES, p.COST_PER_ITEM,
                     p.SELLING_PRICE_PER_ITEM, c.CNAME AS CATEGORY_NAME
              FROM product p
              JOIN category c ON p.CATEGORY_ID = c.CATEGORY_ID
              WHERE p.PRODUCT_ID = '$productID' LIMIT 1"; // Limit 1 as PRODUCT_ID is primary key
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        // Assign values for display
        $productID = $product['PRODUCT_ID'];
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
        $costPerItem = $product['COST_PER_ITEM'];
        $sellingPricePerItem = $product['SELLING_PRICE_PER_ITEM'];
        $categoryName = $product['CATEGORY_NAME'];
    } else {
        echo '<div class="alert alert-danger">Product not found.</div>';
        exit;
    }
} else {
    echo '<div class="alert alert-danger">No product selected.</div>';
    exit;
}
?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Product Detail</h4>
        </div>
        <a href="product.php" class="btn btn-primary bg-gradient-primary btn-block">
            <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Back to Product List
        </a>
        <div class="card-body">
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Product ID</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $productID; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Product Name</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $productName; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Category</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $categoryName; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Cost Per Carton</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: ₦<?php echo number_format($costPerCarton, 2); ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Quantity Per Carton</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $qtyPerCarton; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Profit Percentage</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo number_format($profitPercentage, 2); ?>%</h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Cost Per Item</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: ₦<?php echo number_format($costPerItem, 2); ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Selling Price Per Item</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: ₦<?php echo number_format($sellingPricePerItem, 2); ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Total Quantity</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo $totalQty; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Manufacture Date</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo date('M d, Y', strtotime($manufactureDate)); ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Expiry Date</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo ($expiryDate ? date('M d, Y', strtotime($expiryDate)) : 'N/A'); ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Barcode Text</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo ($barcodeText ? $barcodeText : 'N/A'); ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Barcode Image</h5>
                </div>
                <div class="col-sm-9">
                    <h5>:
                        <?php if ($barcodeImage): ?>
                            <img src="<?php echo $barcodeImage; ?>" alt="Barcode Image" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;">
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Notes</h5>
                </div>
                <div class="col-sm-9">
                    <h5>: <?php echo ($notes ? nl2br($notes) : 'N/A'); ?></h5>
                </div>
            </div>
        </div>
    </div>
</center>

<hr>

<?php
include '../includes/footer.php';
?>