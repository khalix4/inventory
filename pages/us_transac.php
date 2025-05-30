<?php
include'../includes/connection.php';

// Handle the action parameter and perform the respective database operations
switch($_GET['action']) {
    case 'add':
        // Handle adding a user
        $emp = $_POST['empid'];
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // Insert new user into the database
        $query = "INSERT INTO users (ID, EMPLOYEE_ID, USERNAME, PASSWORD, TYPE_ID)
                  VALUES (Null, '{$emp}', '{$user}', sha1('{$pass}'), '2')";
        mysqli_query($db, $query) or die('Error in updating users in ' . $query);
        break;

    case 'delete':
        // Handle deleting a user
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $userId = $_GET['id'];

            // Delete the user from the database
            $query = "DELETE FROM users WHERE ID = {$userId}";
            $result = mysqli_query($db, $query);

            if ($result) {
                echo "<script type='text/javascript'>alert('User deleted successfully'); window.location = 'user.php';</script>";
            } else {
                echo "<script type='text/javascript'>alert('Error deleting user'); window.location = 'user.php';</script>";
            }
        }
        break;
}
?>