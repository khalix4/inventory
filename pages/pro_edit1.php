<?php
include '../includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Collect and Sanitize Form Data
    // Use mysqli_real_escape_string to prevent SQL injection
    $productID = mysqli_real_escape_string($db, $_POST['id']);
    $productName = mysqli_real_escape_string($db, $_POST['product_name']);
    $costPerCarton = floatval($_POST['cost_per_carton']);
    $qtyPerCarton = (int)$_POST['qty_per_carton'];
    $profitPercentage = floatval($_POST['profit_percentage']);
    $totalQty = (int)$_POST['total_qty'];
    $manufactureDate = mysqli_real_escape_string($db, $_POST['manufacture_date']);

    // Handle optional fields, setting to NULL if empty
    $expiryDate = !empty($_POST['expiry_date']) ? "'" . mysqli_real_escape_string($db, $_POST['expiry_date']) . "'" : "NULL";
    $barcodeText = !empty($_POST['barcode_text']) ? "'" . mysqli_real_escape_string($db, $_POST['barcode_text']) . "'" : "NULL";
    $notes = !empty($_POST['notes']) ? "'" . mysqli_real_escape_string($db, $_POST['notes']) . "'" : "NULL";
    $categoryId = (int)$_POST['category'];

    // 2. Perform Server-Side Calculations (Important for consistency)
    $costPerItem = 0;
    if ($qtyPerCarton > 0) {
        $costPerItem = $costPerCarton / $qtyPerCarton;
    }

    $sellingPricePerItem = $costPerItem * (1 + ($profitPercentage / 100));

    // 3. Handle Barcode Image Upload (Optional)
    $barcodeImagePath = ""; // Initialize empty, will get value from DB or new upload

    // First, fetch the existing barcode image path from the database
    $currentImagePathQuery = "SELECT BARCODE_IMAGE FROM product WHERE PRODUCT_ID = '$productID'";
    $currentImagePathResult = mysqli_query($db, $currentImagePathQuery);
    if ($currentImagePathResult && $row = mysqli_fetch_assoc($currentImagePathResult)) {
        $barcodeImagePath = $row['BARCODE_IMAGE']; // Set to current path
    }

    // Check if a new image was uploaded and there's no error
    if (isset($_FILES['barcode_image']) && $_FILES['barcode_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/barcodes/'; // Define your upload directory

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmpPath = $_FILES['barcode_image']['tmp_name'];
        $fileName = $_FILES['barcode_image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // More robust way to get extension

        $newFileName = uniqid('barcode_', true) . '.' . $fileExtension; // Generate a unique file name
        $destPath = $uploadDir . $newFileName;

        $allowedFileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedFileExtensions)) {
            // Delete old image if it exists and a new one is being uploaded
            if (!empty($barcodeImagePath) && file_exists($barcodeImagePath)) {
                unlink($barcodeImagePath); // Delete the old file
            }

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $barcodeImagePath = mysqli_real_escape_string($db, $destPath); // Update path to new file
            } else {
                echo "<script>alert('Error moving new barcode image. Please check directory permissions.'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid file type for barcode image. Only JPG, JPEG, PNG, GIF are allowed.'); window.history.back();</script>";
            exit();
        }
    }

    // Format barcodeImagePath for SQL query (NULL if empty, or quoted string)
    $finalBarcodeImagePath = !empty($barcodeImagePath) ? "'" . $barcodeImagePath . "'" : "NULL";

    // 4. Construct the UPDATE SQL Query
    $query = "UPDATE product SET
                PRODUCT_NAME = '$productName',
                CATEGORY_ID = $categoryId,
                COST_PER_CARTON = $costPerCarton,
                QTY_PER_CARTON = $qtyPerCarton,
                PROFIT_PERCENTAGE = $profitPercentage,
                TOTAL_QTY = $totalQty,
                MANUFACTURE_DATE = '$manufactureDate',
                EXPIRY_DATE = $expiryDate,
                BARCODE_TEXT = $barcodeText,
                BARCODE_IMAGE = $finalBarcodeImagePath,
                NOTES = $notes,
                COST_PER_ITEM = $costPerItem,
                SELLING_PRICE_PER_ITEM = $sellingPricePerItem
              WHERE PRODUCT_ID = '$productID'";

    // 5. Execute the Query and Handle Result
    if (mysqli_query($db, $query)) {
        echo '<script type="text/javascript">
                alert("You\'ve Updated Product Successfully.");
                window.location = "product.php";
              </script>';
        exit();
    } else {
        die("Error updating product: " . mysqli_error($db));
    }
} else {
    die("Invalid request.");
}
?>