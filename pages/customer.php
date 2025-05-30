<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

// Restrict access for certain user types
$query = 'SELECT ID, t.TYPE FROM users u JOIN type t ON t.TYPE_ID = u.TYPE_ID WHERE ID = ' . $_SESSION['MEMBER_ID'];
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $userType = $row['TYPE'];
    if ($userType == 'User') {
        echo '<script type="text/javascript">
                alert("Restricted Page! You will be redirected to POS");
                window.location = "pos.php";
              </script>';
    }
}
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Customers &nbsp;
            <a href="#" data-toggle="modal" data-target="#customerModal" type="button"
                class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;">
                <i class="fas fa-fw fa-plus"></i>
            </a>
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Adresse</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT * FROM customer';
                    $result = mysqli_query($db, $query) or die(mysqli_error($db));

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['FIRST_NAME'] . '</td>';
                        echo '<td>' . $row['LAST_NAME'] . '</td>';
                        echo '<td>' . $row['PHONE_NUMBER'] . '</td>';
                        echo '<td align="right">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary" href="cust_searchfrm.php?action=edit&id=' . $row['CUST_ID'] . '">
                                        <i class="fas fa-fw fa-list-alt"></i> Details
                                    </a>
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">
                                            ... <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu text-center" role="menu">
                                            <li>
                                                <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="cust_edit.php?action=edit&id=' . $row['CUST_ID'] . '">
                                                    <i class="fas fa-fw fa-edit"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a type="button" class="btn btn-danger bg-gradient-danger btn-block" style="border-radius: 0px;" href="cust_del.php?type=customer&id=' . $row['CUST_ID'] . '">
                                                    <i class="fas fa-fw fa-trash-alt"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                              </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>