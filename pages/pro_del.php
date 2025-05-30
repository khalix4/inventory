<?php
include '../includes/connection.php';

// Check if "do" parameter is set and if "id" is a valid number
if (isset($_GET['do']) && $_GET['do'] == 1) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $product_id = $_GET['id'];

        // SQL query to delete the product
        $query = 'DELETE FROM product WHERE PRODUCT_ID = ' . $product_id;
        $result = mysqli_query($db, $query);

        // Check if the query executed successfully
        if ($result) {
            // Redirect to product list with success message
            header('Location: product.php?msg=success');
            exit();
        } else {
            // Redirect to product list with error message
            header('Location: product.php?msg=error');
            exit();
        }
    } else {
        // Invalid product ID, redirect with an error message
        header('Location: product.php?msg=invalid');
        exit();
    }
} else {
    // If "do" parameter is not set, redirect to product list
    header('Location: product.php');
    exit();
}
?>