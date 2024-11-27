<?php 
include('../components/menu.php');
include('category_operations.php');
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Update Food Category</h1>
        </div>
        <div class="card__body">
            <?php 
            $error_message = '';
            $success_message = '';

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $category = fetchFoodCategoryById($id);

                if (is_array($category)) {
                    $name = $category['name'];
                    $description = $category['description'];
                    $current_image = $category['image_path'];
                    $is_active = $category['is_active'];
                } else {
                    $error_message = "Category not Found.";
                }
            } else {
                $error_message = "Invalid request. Category ID not provided.";
            }

            if (isset($_POST['submit'])) {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $is_active = isset($_POST['is_active']) ? 1 : 0;

                $result = updateFoodCategory($id, $name, $description, $current_image, $is_active);

                if ($result === true) {
                    $success_message = "Category Updated Successfully.";
                } else {
                    $error_message = "Failed to Update Category. $result";
                }
            }
            ?>

            <?php if (!empty($error_message)): ?>
                <div class="text-accent mb-3"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <div class="text-secondary mb-3"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <?php if (empty($error_message)): ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description:</label>
                        <textarea id="description" name="description" class="form-input" rows="5"><?php echo htmlspecialchars($description); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Current Image:</label>
                        <?php 
                        if ($current_image != "") {
                            ?>
                            <img src="../images/category/<?php echo htmlspecialchars($current_image); ?>" width="150" alt="Current Category Image" class="mt-2">
                            <?php
                        } else {
                            echo "<div class='text-accent mt-2'>Image Not Added.</div>";
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <input type="checkbox" name="is_active" value="1" <?php if($is_active==1) echo "checked"; ?> class="mr-2">
                            Active
                        </label>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn btn--primary">
                    </div>
                </form>
            <?php endif; ?>

            <div class="mt-4">
                <a href="index.php" class="btn btn--secondary">Back to Categories</a>
            </div>
        </div>
    </div>
</main>

<?php include('../components/footer.php'); ?>