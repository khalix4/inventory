<?php
include '../includes/connection.php';

if (isset($_POST['add_admin'])) {
  $empid = mysqli_real_escape_string($db, $_POST['empid']);
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = sha1($_POST['password']); // Simple hash; consider using password_hash() instead
  $type_id = 1; // Admin type

  // Check if user already exists for this employee
  $checkQuery = "SELECT * FROM users WHERE EMPLOYEE_ID = '$empid'";
  $checkResult = mysqli_query($db, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    echo "<script>alert('User already exists for this employee!'); window.location.href='user.php';</script>";
    exit;
  }

  // Insert new admin
  $query = "INSERT INTO users (EMPLOYEE_ID, USERNAME, PASSWORD, TYPE_ID) 
            VALUES ('$empid', '$username', '$password', '$type_id')";
  if (mysqli_query($db, $query)) {
    echo "<script>alert('New Admin added successfully!'); window.location.href='user.php';</script>";
  } else {
    echo "<script>alert('Error adding admin.'); window.location.href='user.php';</script>";
  }
}
?>
