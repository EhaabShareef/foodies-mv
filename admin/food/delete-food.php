<?php
include('../components/menu.php');
include('food_operations.php');

$error_message = '';
$success_message = '';

if(isset($_GET['id']) && isset($_GET['image_path'])) {
    $id = $_GET['id'];
    $image_path = $_GET['image_path'];

    if($image_path != "") {
        $path = "../images/food/".$image_path;
        if (file_exists($path)) {
            $remove = unlink($path);
            if($remove == false) {
                $error_message = "Failed to remove food image.";
            }
        }
    }

    if(empty($error_message)) {
        $result = deleteFood($id);

        if($result === true) {
            $success_message = "Food Deleted Successfully.";
        } else {
            $error_message = "Failed to Delete Food. $result";
        }
    }
} else {
    $error_message = "Invalid request. Food ID or image path not provided.";
}
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Delete Food Item</h1>
        </div>
        <div class="card__body">
            <?php if (!empty($error_message)): ?>
                <div class="text-accent mb-3"><?php echo htmlspecialchars($error_message); ?></div>
            <?php elseif (!empty($success_message)): ?>
                <div class="text-secondary mb-3"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <p class="mb-3">
                <?php 
                if (!empty($success_message)) {
                    echo "The food item has been deleted successfully.";
                } elseif (empty($error_message)) {
                    echo "Are you sure you want to delete this food item?";
                }
                ?>
            </p>

            <div class="mt-4">
                <a href="index.php" class="btn btn--primary">Back to Food Items</a>
            </div>
        </div>
    </div>
</main>

<?php
if (!empty($success_message) || !empty($error_message)) {
    $_SESSION['delete'] = !empty($success_message) ? 
        "<div class='text-secondary'>" . htmlspecialchars($success_message) . "</div>" : 
        "<div class='text-accent'>" . htmlspecialchars($error_message) . "</div>";
    header('location: index.php');
    exit();
}

include('../components/footer.php');
?>