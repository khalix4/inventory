<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone_number = mysqli_real_escape_string($db, $_POST['phone_number']);
    $job_id = intval($_POST['job_id']);
    $hired_date = mysqli_real_escape_string($db, $_POST['hired_date']);
    $location_id = intval($_POST['location_id']);

    // Simple validation (add more as needed)
    if (empty($first_name) || empty($last_name) || empty($job_id) || empty($hired_date)) {
        $error = "Please fill in all required fields.";
    } else {
        // Insert query
        $query = "INSERT INTO employee (FIRST_NAME, LAST_NAME, GENDER, EMAIL, PHONE_NUMBER, JOB_ID, HIRED_DATE, LOCATION_ID)
                  VALUES ('$first_name', '$last_name', '$gender', '$email', '$phone_number', $job_id, '$hired_date', $location_id)";
        if (mysqli_query($db, $query)) {
            $success = "Employee added successfully.";
        } else {
            $error = "Error adding employee: " . mysqli_error($db);
        }
    }
}

// Fetch jobs for dropdown
$jobs_result = mysqli_query($db, "SELECT JOB_ID, JOB_TITLE FROM job ORDER BY JOB_TITLE ASC");

// Fetch locations for dropdown
$locations_result = mysqli_query($db, "SELECT LOCATION_ID, PROVINCE, CITY FROM location ORDER BY PROVINCE ASC");
?>

<div class="container mt-4">
    <h2>Add New Employee</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" action="empadd.php">
        <div class="form-group">
            <label for="first_name">First Name *</label>
            <input type="text" class="form-control" name="first_name" id="first_name" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name *</label>
            <input type="text" class="form-control" name="last_name" id="last_name" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control">
                <option value="" selected>-- Select Gender --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com">
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" id="phone_number" maxlength="11" placeholder="01234567890">
        </div>

        <div class="form-group">
            <label for="job_id">Job Role *</label>
            <select name="job_id" id="job_id" class="form-control" required>
                <option value="">-- Select Job Role --</option>
                <?php while ($job = mysqli_fetch_assoc($jobs_result)): ?>
                    <option value="<?= $job['JOB_ID'] ?>"><?= htmlspecialchars($job['JOB_TITLE']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="hired_date">Hired Date *</label>
            <input type="date" class="form-control" name="hired_date" id="hired_date" required>
        </div>

        <div class="form-group">
            <label for="location_id">Location</label>
            <select name="location_id" id="location_id" class="form-control">
                <option value="">-- Select Location --</option>
                <?php while ($loc = mysqli_fetch_assoc($locations_result)): ?>
                    <option value="<?= $loc['LOCATION_ID'] ?>"><?= htmlspecialchars($loc['PROVINCE'] . ', ' . $loc['CITY']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Employee</button>
        <a href="employee.php" class="btn btn-secondary">Back to Employees</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
