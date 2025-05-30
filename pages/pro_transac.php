<?php
include '../includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'add') {

    // Collect form data safely
    $productName = mysqli_real_escape_string($db, $_POST['product_name']);
    $categoryId = (int)$_POST['category'];
    $costPerCarton = floatval($_POST['cost_per_carton']);
    $qtyPerCarton = (int)$_POST['qty_per_carton'];
    $profitPercentage = floatval($_POST['profit_percentage']);
    $totalQty = (int)$_POST['total_qty'];
    $manufactureDate = mysqli_real_escape_string($db, $_POST['manufacture_date']);
    $expiryDate = !empty($_POST['expiry_date']) ? "'" . mysqli_real_escape_string($db, $_POST['expiry_date']) . "'" : "NULL";
    $barcodeText = !empty($_POST['barcode_text']) ? "'" . mysqli_real_escape_string($db, $_POST['barcode_text']) . "'" : "NULL";
    $notes = !empty($_POST['notes']) ? "'" . mysqli_real_escape_string($db, $_POST['notes']) . "'" : "NULL";

    // Calculate COST_PER_ITEM and SELLING_PRICE_PER_ITEM
    $costPerItem = 0;
    if ($qtyPerCarton > 0) {
        $costPerItem = $costPerCarton / $qtyPerCarton;
    }

    $sellingPricePerItem = $costPerItem * (1 + ($profitPercentage / 100));

    // Handle Barcode Image Upload (Optional)
    $barcodeImagePath = "NULL"; // Default to NULL if no image is uploaded

    if (isset($_FILES['barcode_image']) && $_FILES['barcode_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/barcodes/'; // Define your upload directory
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmpPath = $_FILES['barcode_image']['tmp_name'];
        $fileName = $_FILES['barcode_image']['name'];
        $fileSize = $_FILES['barcode_image']['size'];
        $fileType = $_FILES['barcode_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension; // Generate a unique file name
        $destPath = $uploadDir . $newFileName;

        // Allowed file extensions
        $allowedFileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedFileExtensions)) {
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $barcodeImagePath = "'" . mysqli_real_escape_string($db, $destPath) . "'"; // Store the path
            } else {
                // Handle upload error (e.g., permissions)
                echo "Error moving uploaded file.";
            }
        } else {
            // Invalid file type
            echo "Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.";
        }
    }

    // Construct the INSERT query
    $query = "INSERT INTO product (
                PRODUCT_NAME, CATEGORY_ID, COST_PER_CARTON, QTY_PER_CARTON, PROFIT_PERCENTAGE, TOTAL_QTY, MANUFACTURE_DATE, EXPIRY_DATE, BARCODE_TEXT, BARCODE_IMAGE, NOTES, COST_PER_ITEM, SELLING_PRICE_PER_ITEM
              ) VALUES (
                '$productName', $categoryId, $costPerCarton, $qtyPerCarton, $profitPercentage, $totalQty, '$manufactureDate', $expiryDate, $barcodeText, $barcodeImagePath, $notes, $costPerItem, $sellingPricePerItem
              )";

    if (mysqli_query($db, $query)) {
        // Success - redirect to product list or show success message
        header("Location: product.php");
        exit();
    } else {
        die("Error inserting product: " . mysqli_error($db));
    }
} else {
    die("Invalid request.");
}
?>