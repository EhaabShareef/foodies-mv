<?php
include('../db_connection.php');
include('admin_operations.php');


// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    // Call the deleteAdmin function
    $result = deleteAdmin($admin_id);

    // Check if deletion was successful
    if ($result === true) {
        // Redirect to manage-admin page with success message
        header("Location: index.php?message=AdminDeleted");
    } else {
        // Redirect to manage-admin page with error message
        header("Location: index.php?message=ErrorDeletingAdmin");
    }
} else {
    // If no ID is passed, redirect to manage-admin page
    header("Location: index.php");
}
?>
