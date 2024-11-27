<?php 
include('../components/menu.php');
include('admin_operations.php'); 

// Assuming you have the admin ID from a GET request
$admin_id = $_GET['id'];

// Fetch the current admin details based on the ID
$sql = "SELECT * FROM admin WHERE id = ?";
$conn = getDbConnection();
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $full_name = $row['full_name'];
    $user_name = $row['user_name'];
} else {
    // Redirect if admin not found
    header('Location: manage-admin.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $full_name = $_POST['full_name'];
    $user_name = $_POST['user_name'];
    
    // Call the update function (no password update in this case)
    $result = updateAdmin($admin_id, $full_name, $user_name);
    
    if ($result === true) {
        // Success message and redirect
        $_SESSION['update'] = "Admin updated successfully.";
        header('Location: index.php');
        exit();
    } else {
        // Handle the error message
        $error_message = $result;
    }
}
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Update Admin</h1>
        </div>
        <div class="card__body">
            <?php if (isset($error_message)): ?>
                <div class="mb-3 text-accent"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="full_name" class="form-label">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required class="form-input">
                </div>
                <div class="form-group">
                    <label for="user_name" class="form-label">Username:</label>
                    <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user_name); ?>" required class="form-input">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Update Admin" class="btn btn--primary">
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('../components/footer.php') ?>