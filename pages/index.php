<?php
include'../includes/connection.php';

include'../includes/sidebar.php';
?><?php 

                $query = 'SELECT ID, t.TYPE
                          FROM users u
                          JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = '.$_SESSION['MEMBER_ID'].'';
                $result = mysqli_query($db, $query) or die (mysqli_error($db));
      
                while ($row = mysqli_fetch_assoc($result)) {
                          $Aa = $row['TYPE'];
                   
if ($Aa=='User'){
           
             ?> <script type="text/javascript">
//then it will be redirected
alert("Restricted Page! You will be redirected to POS");
window.location = "pos.php";
</script>
<?php   }
                         
           
}   
            ?>
<div class="row show-grid">
    <!-- Customer ROW -->
    <div class="col-md-3">
        <!-- Customer record -->
        <div class="col-md-12 mb-3" onclick="location.href='customer.php';" style="cursor: pointer;">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Customers</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?php 
                        $query = "SELECT COUNT(*) FROM customer";
                        $result = mysqli_query($db, $query) or die(mysqli_error($db));
                        while ($row = mysqli_fetch_array($result)) {
                            echo "$row[0]";
                          }
                        ?> Record(s)
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

 

    </div>
    <!-- Employee ROW -->
    <div class="col-md-3">
        <!-- Employee record -->
        <div class="col-md-12 mb-3" onclick="location.href='employee.php';" style="cursor: pointer;">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Employees</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?php 
                        $query = "SELECT COUNT(*) FROM employee";
                        $result = mysqli_query($db, $query) or die(mysqli_error($db));
                        while ($row = mysqli_fetch_array($result)) {
                            echo "$row[0]";
                          }
                        ?> Record(s)
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      

    </div>
    <!-- PRODUCTS ROW -->
    <div class="col-md-3">
        <!-- Product record -->
        <div class="col-md-12 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body" style="cursor: pointer;" onclick="location.href='product.php';">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Products</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                                        <?php 
                          $query = "SELECT COUNT(*) FROM product";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Record(s)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

<div class="col-lg-3">
    <div class="card shadow h-100">
        <div class="card-body">
            <div class="row no-gutters align-items-center">

                <div class="col-auto">
                    <i class="fa fa-th-list fa-fw"></i>
                </div>

                <div class="panel-heading"> Recent Products
                </div>
                <div class="row no-gutters align-items-center mt-1">
                    <div class="col-auto">
                        <div class="h6 mb-0 mr-0 text-gray-800">
                            <div class="panel-body">
                                <div class="list-group">
                                    <?php
                                    // Query to get each product with its total quantity, ordered by PRODUCT_ID descending
                                    // LIMIT 8 to show the 8 most recently added products
                                    $query = "SELECT PRODUCT_ID, PRODUCT_NAME, TOTAL_QTY FROM product ORDER BY PRODUCT_ID DESC LIMIT 8";
                                    $result = mysqli_query($db, $query) or die(mysqli_error($db));

                                    // Loop through the results and display each product with its total quantity
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Generate a clickable link for each product, passing PRODUCT_ID as a query parameter
                                        // Ensure pro_searchfrm.php expects 'id=' for PRODUCT_ID
                                        $productDetailUrl = "pro_searchfrm.php?id=" . urlencode($row['PRODUCT_ID']);
                                        echo "<a href='{$productDetailUrl}' class='list-group-item text-gray-800'>
                                                <i class='fa fa-tasks fa-fw'></i> {$row['PRODUCT_NAME']} ({$row['TOTAL_QTY']} UNITS)
                                              </a>";
                                    }
                                    ?>
                                </div>
                                </div>
                            <a href="product.php" class="btn btn-default btn-block">View All Products</a>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="col-md-12 mb-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
    </div>
</div>


</div>

<?php
include'../includes/footer.php';
?>