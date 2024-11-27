<?php
// admin_operations.php no need since i declared it in menu level
//include('../db_connection.php');

function addAdmin($full_name, $user_name, $password) {
    $conn = getDbConnection();
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    $sql = "INSERT INTO admin (full_name, user_name, password) VALUES ('$full_name', '$user_name', '$hashed_password')";
   

    if (mysqli_query($conn, $sql)) {
        return true; 
    } else {

        return "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}


// Delete Admin Function
function deleteAdmin($admin_id) {
    $conn = getDbConnection();
    
    // Delete query
    $sql = "DELETE FROM admin WHERE id = '$admin_id'";

    if (mysqli_query($conn, $sql)) {
        return true; 
    } else {
        return "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

// Update Admin Function
function updateAdmin($admin_id, $full_name, $user_name, $password = null) {
    $conn = getDbConnection();

    if ($password) {
        // If password is provided, update it with the new one
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE admin SET full_name = '$full_name', user_name = '$user_name', password = '$hashed_password' WHERE id = '$admin_id'";
    } else {
        // If no password is provided, only update full name and username
        $sql = "UPDATE admin SET full_name = '$full_name', user_name = '$user_name' WHERE id = '$admin_id'";
    }

    if (mysqli_query($conn, $sql)) {
        return true; 
    } else {
        return "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

function updateAdminPassword($admin_id, $new_password) {
    $conn = getDbConnection();
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // SQL query to update the password
    $sql = "UPDATE admin SET password = '$hashed_password' WHERE id = '$admin_id'";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        return true; // Successfully updated
    } else {
        mysqli_close($conn);
        return "Error: " . mysqli_error($conn); // Return the error message
    }
}
?>