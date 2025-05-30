<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

$query = 'SELECT ID, t.TYPE
            FROM users u
            JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = ' . $_SESSION['MEMBER_ID'] . '';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $Aa = $row['TYPE'];

    if ($Aa == 'User') {
?>
<script type="text/javascript">
    //then it will be redirected
    alert("Restricted Page! You will be redirected to POS");
    window.location = "pos.php";
</script>
<?php
    }
}

$sql = "SELECT DISTINCT CNAME, CATEGORY_ID FROM category order by CNAME asc";
$result = mysqli_query($db, $sql) or die("Bad SQL: $sql");

$aaa = "<select class='form-control' name='category' required>
            <option disabled selected hidden>Select Category</option>";
while ($row = mysqli_fetch_assoc($result)) {
    $aaa .= "<option value='" . $row['CATEGORY_ID'] . "'>" . $row['CNAME'] . "</option>";
}
$aaa .= "</select>";

?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Products &nbsp;<a href="#" data-toggle="modal"
                data-target="#aModal" type="button" class="btn btn-primary bg-gradient-primary"
                style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Cost Per Item</th>
                        <th>Selling Price Per Item</th>
                        <th>Total Quantity</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $query = 'SELECT p.PRODUCT_ID, p.PRODUCT_NAME, p.COST_PER_ITEM, p.SELLING_PRICE_PER_ITEM, p.TOTAL_QTY, c.CNAME
                                FROM product p
                                JOIN category c ON p.CATEGORY_ID = c.CATEGORY_ID
                                ORDER BY p.PRODUCT_ID ASC';
                    $result = mysqli_query($db, $query) or die(mysqli_error($db));

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['PRODUCT_ID'] . '</td>';
                        echo '<td>' . $row['PRODUCT_NAME'] . '</td>';
                        echo '<td>' . $row['COST_PER_ITEM'] . '</td>';
                        echo '<td>' . $row['SELLING_PRICE_PER_ITEM'] . '</td>';
                        echo '<td>' . $row['TOTAL_QTY'] . '</td>';
                        echo '<td>' . $row['CNAME'] . '</td>';
                        echo '<td align="right"> <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary" href="pro_searchfrm.php?action=edit & id=' . $row['PRODUCT_ID'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                                <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">
                                    ... <span class="caret"></span></a>
                                <ul class="dropdown-menu text-center" role="menu">
                                    <li>
                                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="pro_edit.php?action=edit & id=' . $row['PRODUCT_ID'] . '">
                                            <i class="fas fa-fw fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a type="button" class="btn btn-danger bg-gradient-danger btn-block" style="border-radius: 0px;" href="pro_del.php?do=1&id=' . $row['PRODUCT_ID'] . '" onclick="return confirm(\'Are you sure you want to delete this product?\')">
                                            <i class="fas fa-fw fa-trash"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                                </div>
                            </div> </td>';
                        echo '</tr> ';
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>

<div class="modal fade" id="aModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="pro_transac.php?action=add" enctype="multipart/form-data">
                    <div class="form-group">
                        <input class="form-control" placeholder="Product Name" name="product_name" required>
                    </div>
                    <div class="form-group">
                        <input type="number" step="0.01" min="0" class="form-control" placeholder="Cost Per Carton"
                            name="cost_per_carton" id="cost_per_carton" required>
                    </div>
                    <div class="form-group">
                        <input type="number" min="1" class="form-control" placeholder="Quantity Per Carton"
                            name="qty_per_carton" id="qty_per_carton" required>
                    </div>
                    <div class="form-group">
                        <input type="number" step="0.01" min="0" class="form-control" placeholder="Profit Percentage (%)"
                            name="profit_percentage" id="profit_percentage" required>
                    </div>
                    <div class="form-group">
                        <label for="cost_per_item">Cost Price per Item</label>
                        <input type="text" class="form-control" id="cost_per_item" name="cost_per_item" readonly>
                    </div>
                    <div class="form-group">
                        <label for="selling_price_per_item">Selling Price per Item</label>
                        <input type="text" class="form-control" id="selling_price_per_item" name="selling_price_per_item"
                            readonly>
                    </div>
                    <div class="form-group">
                        <input type="number" min="0" class="form-control" placeholder="Total Quantity" name="total_qty" required>
                    </div>
                    <div class="form-group">
                        <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control"
                            placeholder="Manufacture Date" name="manufacture_date" required>
                    </div>
                    <div class="form-group">
                        <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control"
                            placeholder="Expiry Date (Optional)" name="expiry_date">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Barcode Text (Optional)" name="barcode_text">
                    </div>
                    <div class="form-group">
                        <label for="barcode_image">Barcode Image (Optional)</label>
                        <input type="file" class="form-control-file" id="barcode_image" name="barcode_image" accept="image/*">
                    </div>
                    <div class="form-group">
                        <textarea rows="3" cols="50" class="form-control" placeholder="Notes (Optional)"
                            name="notes"></textarea>
                    </div>
                    <div class="form-group">
                        <?php echo $aaa; ?>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Save</button>
                    <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Reset</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
            if (costPerCarton > 0 && qtyPerCarton > 0) {
                costPerItem = costPerCarton / qtyPerCarton;
            }
            costPerItemInput.value = costPerItem.toFixed(2);

            let sellingPricePerItem = 0;
            if (costPerItem > 0 && profitPercentage >= 0) {
                sellingPricePerItem = costPerItem * (1 + profitPercentage / 100);
            }
            sellingPricePerItemInput.value = sellingPricePerItem.toFixed(2);
        }

        costPerCartonInput.addEventListener('input', calculatePrices);
        qtyPerCartonInput.addEventListener('input', calculatePrices);
        profitPercentageInput.addEventListener('input', calculatePrices);
    });
</script>