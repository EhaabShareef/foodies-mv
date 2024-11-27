<?php include('../components/menu.php'); ?>
<?php include('admin_operations.php'); ?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Add Admin</h1>
        </div>
        <div class="card__body">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter Your Name" required class="form-input">
                </div>
                <div class="form-group">
                    <label for="user_name" class="form-label">Username</label>
                    <input type="text" id="user_name" name="user_name" placeholder="Your Username" required class="form-input">
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" placeholder="Your Password" required class="form-input">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Add Admin" class="btn btn--primary">
                </div>
            </form>

            <?php 
            if (isset($_POST['submit'])) {
                $full_name = $_POST['full_name'];
                $user_name = $_POST['user_name'];
                $password = $_POST['password'];

                $result = addAdmin($full_name, $user_name, $password);

                if ($result === true) {
                    echo "<p class='mt-3 text-secondary'>Admin added successfully!</p>";
                } else {
                    echo "<p class='mt-3 text-accent'>Error adding admin: " . $result . "</p>";
                }
            }
            ?>
        </div>
    </div>
</main>

<?php include('../components/footer.php'); ?>