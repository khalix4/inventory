<?php
require('../includes/connection.php');
require('session.php');

if (isset($_POST['btnregister'])) {
    // Get form inputs and trim spaces
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $type_admin = trim($_POST['type_admin']);
    $secret_code = isset($_POST['secret_code']) ? trim($_POST['secret_code']) : '';

    // Validate inputs
    if ($username == '' || $password == '' || $confirm_password == '' || $type_admin == '') {
        echo "<script>alert('Please fill all the fields!'); window.location = 'register.php';</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.location = 'register.php';</script>";
    } elseif ($type_admin == '1' && $secret_code !== 'admin') {
        echo "<script>alert('Invalid secret code for admin account!'); window.location = 'register.php';</script>";
    } else {
        // Hash the password
        $h_password = sha1($password);

        // Check if the username already exists
        $sql_check_user = "SELECT * FROM users WHERE USERNAME = '$username'";
        $result_check_user = $db->query($sql_check_user);

        if ($result_check_user->num_rows > 0) {
            echo "<script>alert('Username already exists! Please choose another username.'); window.location = 'register.php';</script>";
        } else {
            // Generate a new unique EMPLOYEE_ID
            $sql_latest_employee = "SELECT MAX(EMPLOYEE_ID) AS LAST_ID FROM employee";
            $result_latest_employee = $db->query($sql_latest_employee);

            if ($result_latest_employee->num_rows > 0) {
                $latest_employee = $result_latest_employee->fetch_assoc();
                $new_employee_id = $latest_employee['LAST_ID'] + 1;
            } else {
                $new_employee_id = 1;
            }

            // Ensure a valid LOCATION_ID
            $sql_check_location = "SELECT LOCATION_ID FROM location LIMIT 1";
            $result_check_location = $db->query($sql_check_location);

            if ($result_check_location->num_rows == 0) {
                $sql_insert_location = "INSERT INTO location (LOCATION_ID, PROVINCE, CITY) VALUES (1, 'Default Province', 'Default City')";
                if (!$db->query($sql_insert_location)) {
                    echo "<script>alert('Error adding default location: " . $db->error . "'); window.location = 'register.php';</script>";
                    exit;
                }
                $location_id = 1;
            } else {
                $location_id = $result_check_location->fetch_assoc()['LOCATION_ID'];
            }

            // Insert the new employee
            $sql_insert_employee = "INSERT INTO employee (EMPLOYEE_ID, FIRST_NAME, LAST_NAME, JOB_ID, LOCATION_ID)
                                     VALUES ($new_employee_id, 'New', 'User', 1, $location_id)";
            if (!$db->query($sql_insert_employee)) {
                echo "<script>alert('Error adding new employee: " . $db->error . "'); window.location = 'register.php';</script>";
                exit;
            }

            // Insert the new user into the users table
            $sql_insert_user = "INSERT INTO users (USERNAME, PASSWORD, EMPLOYEE_ID, TYPE_ID)
                                 VALUES ('$username', '$h_password', $new_employee_id, $type_admin)";
            if ($db->query($sql_insert_user)) {
                echo "<script>alert('Registration successful! Please log in.'); window.location = 'login.php';</script>";
            } else {
                echo "<script>alert('Error: " . $db->error . "'); window.location = 'register.php';</script>";
            }
        }
    }
}
$db->close();
?>