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

// Check if 'id' and 'type' are set in the URL
if (isset($_GET['id']) && $_GET['type'] === 'customer') {
    $customerId = $_GET['id'];

    // Delete all transactions related to the customer
    $deleteTransactionsQuery = 'DELETE FROM transaction WHERE CUST_ID = ' . $customerId;
    mysqli_query($db, $deleteTransactionsQuery) or die(mysqli_error($db));

    // Delete the customer record
    $deleteCustomerQuery = 'DELETE FROM customer WHERE CUST_ID = ' . $customerId;
    mysqli_query($db, $deleteCustomerQuery) or die(mysqli_error($db));

    // Redirect with a success message
    echo '<script type="text/javascript">
            alert("Customer and related transactions successfully deleted.");
            window.location = "customer.php";
          </script>';
} else {
    echo '<script type="text/javascript">
            alert("Invalid operation.");
            window.location = "customer.php";
          </script>';
}
?>