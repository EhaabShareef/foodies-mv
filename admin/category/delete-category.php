<?php
include('../components/menu.php');
include('category_operations.php');

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $id = $_POST['id'];
    $image_name = $_POST['image_name'];

    if ($image_name != "") {
        $path = "../images/category/".$image_name;
        if (file_exists($path)) {
            $remove = unlink($path);
            if ($remove == false) {
                $error_message = "Failed to remove category image.";
            }
        }
    }

    if (empty($error_message)) {
        $result = deleteFoodCategory($id);

        if ($result === true) {
            $success_message = "Category Deleted Successfully.";
        } else {
            $error_message = "Failed to Delete Category. $result";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $category = fetchFoodCategoryById($id);
    if (!$category) {
        $error_message = "Category not found.";
    }
} else {
    $error_message = "Invalid request. Category ID not provided.";
}
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Delete Food Category</h1>
        </div>
        <div class="card__body">
            <?php if (!empty($error_message)): ?>
                <div class="text-accent mb-3"><?php echo $error_message; ?></div>
            <?php elseif (!empty($success_message)): ?>
                <div class="text-secondary mb-3"><?php echo $success_message; ?></div>
            <?php elseif (isset($category)): ?>
                <p class="mb-3">Are you sure you want to delete the category "<?php echo htmlspecialchars($category['name']); ?>"?</p>
                <form action="" method="POST" class="mb-3">
                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                    <input type="hidden" name="image_name" value="<?php echo $category['image_path']; ?>">
                    <div class="form-group">
                        <input type="submit" name="confirm_delete" value="Yes, Delete Category" class="btn btn--accent">
                        <a href="index.php" class="btn btn--secondary ml-2">No, Go Back</a>
                    </div>
                </form>
            <?php endif; ?>

            <div class="mt-4">
                <a href="index.php" class="btn btn--primary">Back to Categories</a>
            </div>
        </div>
    </div>
</main>

<?php include('../components/footer.php'); ?>