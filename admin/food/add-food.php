<?php 
include('../components/menu.php');
include('food_operations.php');
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Add Food Item</h1>
        </div>
        <div class="card__body">
            <?php 
            if(isset($_SESSION['upload'])) {
                echo "<div class='text-accent mb-3'>" . $_SESSION['upload'] . "</div>";
                unset($_SESSION['upload']);
            }
            if(isset($_SESSION['add'])) {
                echo "<div class='text-accent mb-3'>" . $_SESSION['add'] . "</div>";
                unset($_SESSION['add']);
            }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Name of the Food" required class="form-input">
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" placeholder="Description of the Food" class="form-input" rows="5"></textarea>
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" placeholder="Price of the Food" required class="form-input">
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Select Image:</label>
                    <input type="file" id="image" name="image" class="form-input">
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Category:</label>
                    <select id="category" name="category" required class="form-input">
                        <?php 
                        $categories = fetchAllFoodCategories();
                        foreach($categories as $category) {
                            echo "<option value='" . htmlspecialchars($category['id']) . "'>" . htmlspecialchars($category['name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                        Active
                    </label>
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" value="Add Food" class="btn btn--primary">
                </div>
            </form>
        </div>
    </div>
</main>

<?php
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Handle image upload
    $image_path = '';
    if(isset($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        
        if($image_name != "") {
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_name = "Food-Name-".rand(0000,9999).".".$ext;
            $src = $_FILES['image']['tmp_name'];
            $dst = "../images/food/".$image_name;
            $upload = move_uploaded_file($src, $dst);

            if($upload == false) {
                $_SESSION['upload'] = "Failed to Upload Image.";
                header('location: add-food.php');
                exit();
            }
            $image_path = $image_name;
        }
    }

    $result = addFood($category_id, $name, $description, $price, $image_path, $is_active);

    if($result === true) {
        $_SESSION['add'] = "Food Added Successfully.";
        header('location: index.php');
    } else {
        $_SESSION['add'] = "Failed to Add Food. $result";
        header('location: add-food.php');
    }
    exit();
}
?>

<?php include('../components/footer.php'); ?>