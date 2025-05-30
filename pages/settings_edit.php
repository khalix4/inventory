<?php
include('../includes/connection.php');
require_once('session.php');

$zz = $_POST['id']; // User ID
$a = $_POST['firstname'];
$b = $_POST['lastname'];
$c = $_POST['gender'];
$d = $_POST['username'];
$e = $_POST['password'];
$g = $_POST['phone'];
$i = $_POST['hireddate'];
$j = $_POST['province'];
$k = $_POST['city'];

// Ensure all column references are prefixed with table aliases
$query = 'UPDATE users u 
          JOIN employee e ON e.EMPLOYEE_ID = u.EMPLOYEE_ID
          JOIN location l ON l.LOCATION_ID = e.LOCATION_ID
          SET e.FIRST_NAME = "' . $a . '", 
              e.LAST_NAME = "' . $b . '", 
              e.GENDER = "' . $c . '", 
              u.USERNAME = "' . $d . '", 
              u.PASSWORD = SHA1("' . $e . '"), 
              l.PROVINCE = "' . $j . '", 
              l.CITY = "' . $k . '", 
              e.PHONE_NUMBER = "' . $g . '", 
              e.HIRED_DATE = "' . $i . '" 
          WHERE u.ID = "' . $zz . '"';

$result = mysqli_query($db, $query) or die(mysqli_error($db));

// Feedback and redirection based on session type
$sql = 'SELECT ID FROM users';
$result2 = mysqli_query($db, $sql) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result2)) {
    $a = $row['ID'];

    if ($_SESSION['TYPE'] == 'Admin') { ?>
<script type="text/javascript">
alert("You've updated your account successfully.");
window.location = "index.php";
</script>
<?php } elseif ($_SESSION['TYPE'] == 'User') { ?>
<script type="text/javascript">
alert("You've updated your account successfully.");
window.location = "pos.php";
</script>
<?php }
} ?>