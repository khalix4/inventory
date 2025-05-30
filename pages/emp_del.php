<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

// Check if user has appropriate permissions
$query = 'SELECT ID, t.TYPE FROM users u JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = ' . $_SESSION['MEMBER_ID'];
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $Aa = $row['TYPE'];
    if ($Aa == 'User') {
        echo '<script type="text/javascript">
                alert("Restricted Page! You will be redirected to POS");
                window.location = "pos.php";
              </script>';
    }
}

if (isset($_GET['type']) && $_GET['type'] == 'employee' && isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // First, delete the associated records in the 'users' table
    $delete_user_query = 'DELETE FROM users WHERE EMPLOYEE_ID = ' . $employee_id;
    $delete_user_result = mysqli_query($db, $delete_user_query) or die(mysqli_error($db));

    // Then, delete the employee record
    $delete_employee_query = 'DELETE FROM employee WHERE EMPLOYEE_ID = ' . $employee_id;
    $delete_employee_result = mysqli_query($db, $delete_employee_query) or die(mysqli_error($db));

    // Show success message and redirect
    echo '<script type="text/javascript">
            alert("Employee and associated user successfully deleted.");
            window.location = "employee.php";
          </script>';
}
?>