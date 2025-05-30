<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

// Check user type and redirect if necessary
$query = 'SELECT ID, t.TYPE
          FROM users u
          JOIN type t ON t.TYPE_ID = u.TYPE_ID
          WHERE ID = ?';
$stmt = $db->prepare($query);
$stmt->bind_param('i', $_SESSION['MEMBER_ID']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $userType = $row['TYPE'];
    if ($userType == 'User') {
        echo "<script>
            alert('Restricted Page! You will be redirected to POS');
            window.location = 'pos.php';
        </script>";
        exit();
    }
}

// Fetch job titles for the dropdown
$sql = "SELECT DISTINCT JOB_TITLE, JOB_ID FROM job";
$jobResult = $db->query($sql) or die("Bad SQL: $sql");

$jobOptions = "<select class='form-control' name='jobs' required>
                <option value='' disabled selected>Select Role</option>";
while ($row = $jobResult->fetch_assoc()) {
    $jobOptions .= "<option value='" . $row['JOB_ID'] . "'>" . $row['JOB_TITLE'] . "</option>";
}
$jobOptions .= "</select>";

// Fetch employee details
$query = 'SELECT EMPLOYEE_ID, FIRST_NAME, LAST_NAME, EMAIL, PHONE_NUMBER, j.JOB_TITLE, HIRED_DATE, l.PROVINCE, l.CITY, e.GENDER
          FROM employee e
          JOIN location l ON l.LOCATION_ID = e.LOCATION_ID
          JOIN job j ON j.JOB_ID = e.JOB_ID
          WHERE EMPLOYEE_ID = ?';
$stmt = $db->prepare($query);
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $zz = $row['EMPLOYEE_ID'];
    $fname = $row['FIRST_NAME'];
    $lname = $row['LAST_NAME'];
    $email = $row['EMAIL'];
    $phone = $row['PHONE_NUMBER'];
    $jobb = $row['JOB_TITLE'];
    $hdate = $row['HIRED_DATE'];
    $prov = $row['PROVINCE'];
    $cit = $row['CITY'];
    $gender = $row['GENDER'];
}
?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Edit Employee</h4>
        </div>
        <a type="button" class="btn btn-primary bg-gradient-primary btn-block" href="employee.php">
            <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Back
        </a>
        <div class="card-body">
            <form role="form" method="post" action="emp_edit1.php">
                <input type="hidden" name="id" value="<?php echo $zz; ?>" />
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">First Name:</div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="First Name" name="firstname"
                            value="<?php echo $fname; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">Last Name:</div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Last Name" name="lastname"
                            value="<?php echo $lname; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">Gender:</div>
                    <div class="col-sm-9">
                        <select class='form-control' name='gender' required>
                            <option value="" disabled hidden>Select Gender</option>
                            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">Email:</div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>"
                            required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">Contact #:</div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Phone Number" name="phone"
                            value="<?php echo $phone; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">Role:</div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Role" name="jobs" value="<?php echo $jobb; ?>"
                            disabled>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">Hired Date:</div>
                    <div class="col-sm-9">
                        <input placeholder="Hired Date" type="date" id="FromDate" name="hireddate"
                            value="<?php echo $hdate; ?>" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">Address:</div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Province" name="province" value="<?php echo $prov; ?>"
                            required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">City:</div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="City / Municipality" name="city"
                            value="<?php echo $cit; ?>" required>
                    </div>
                </div>

                <hr>

                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Update</button>
            </form>
        </div>
    </div>
</center>

<?php
include '../includes/footer.php';
?>