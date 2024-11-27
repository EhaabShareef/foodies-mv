<?php include('../components/menu.php'); ?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Manage Admin</h1>
        </div>
        <div class="card__body">
            <div class="mb-3">
                <a href="add-admin.php" class="btn btn--primary">Add Admin</a>
            </div>

            <table class="table table--striped">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = getDbConnection();
                    $sql = "SELECT * FROM admin";
                    $res = mysqli_query($conn, $sql);

                    if ($res == TRUE) {
                        $rows = mysqli_num_rows($res);
                        $sn = 1;

                        if ($rows > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $full_name = $row['full_name'];
                                $username = $row['user_name'];
                    ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td>
                                        <a href="update-password.php?id=<?php echo $id; ?>" class="btn btn--secondary">Update Password</a>
                                        <a href="update-admin.php?id=<?php echo $id; ?>" class="btn btn--primary">Update Admin</a>
                                        <a href="delete-admin.php?id=<?php echo $id; ?>" class="btn btn--accent">Delete Admin</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="4" class="text--center">No Admins Found</td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include('../components/footer.php') ?>