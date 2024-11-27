<?php
// Include the menu and other necessary files
include_once('../components/menu.php');
include_once('admin_operations.php'); // Include the admin operations file

// Get the admin ID from the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Get the current password from the database
    $conn = getDbConnection();
    $sql = "SELECT password FROM admin WHERE id = '$id'";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $stored_password = $row['password'];

        // Verify current password
        if (password_verify($current_password, $stored_password)) {
            // Check if new password and confirm password match
            if ($new_password == $confirm_password) {
                // Call the function to update the password
                $update_result = updateAdminPassword($id, $new_password);
                if ($update_result === true) {
                    echo "Password updated successfully!";
                } else {
                    echo $update_result; // Display error message from the function
                }
            } else {
                echo "New password and confirm password do not match.";
            }
        } else {
            echo "Current password is incorrect.";
        }
    } else {
        echo "Admin not found.";
    }

    // Close the connection
    mysqli_close($conn);
}

?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Change Password</h1>
        </div>
        <div class="card__body">
            <?php if (isset($error_message)): ?>
                <div class="mb-3 text-accent"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <?php if (isset($success_message)): ?>
                <div class="mb-3 text-secondary"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password:</label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password" 
                        placeholder="Enter current password" 
                        required 
                        class="form-input"
                    >
                </div>

                <div class="form-group">
                    <label for="new_password" class="form-label">New Password:</label>
                    <input 
                        type="password" 
                        id="new_password" 
                        name="new_password" 
                        placeholder="Enter new password" 
                        required 
                        class="form-input"
                    >
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm Password:</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        placeholder="Confirm new password" 
                        required 
                        class="form-input"
                    >
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input 
                        type="submit" 
                        name="submit" 
                        value="Change Password" 
                        class="btn btn--primary"
                    >
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('../components/footer.php'); ?>
