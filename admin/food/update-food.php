<?php 
include('../components/menu.php');
include('food_operations.php');
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Update Food Item</h1>
        </div>
        <div class="card__body">
            <?php 
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $food = fetchFoodItemById($id);

                if($food) {
                    $name = $food['name'];
                    $description = $food['description'];
                    $price = $food['price'];
                    $current_image = $food['image_path'];
                    $current_category = $food['category_id'];
                    $is_active = $food['is_active'];
                } else {
                    echo "<div class='text-accent mb-3'>Food not found.</div>";
                    include('../components/footer.php');
                    exit();
                }
            } else {
                header('location: index.php');
                exit();
            }

            if(isset($_POST['submit'])) {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category_id = $_POST['category'];
                $is_active = isset($_POST['is_active']) ? 1 : 0;

                // Handle image update
                if(isset($_FILES['image']['name'])) {
                    $image_name = $_FILES['image']['name'];
                    if($image_name != "") {
                        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                        $image_name = "Food-Name-".rand(0000, 9999).".".$ext;
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;
                        $upload = move_uploaded_file($src_path, $dest_path);

                        if($upload == false) {
                            $_SESSION['upload'] = "Failed to Upload new Image.";
                            header('location: update-food.php?id='.$id);
                            exit();
                        }

                        if($current_image != "" && file_exists("../images/food/".$current_image)) {
                            unlink("../images/food/".$current_image);
                        }
                    } else {
                        $image_name = $current_image;
                    }
                } else {
                    $image_name = $current_image;
                }

                $result = updateFood($id, $category_id, $name, $description, $price, $image_name, $is_active);

                if($result === true) {
                    $_SESSION['update'] = "Food Updated Successfully.";
                    header('location: index.php');
                } else {
                    $_SESSION['update'] = "Failed to Update Food. $result";
                    header('location: update-food.php?id='.$id);
                }
                exit();
            }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required class="form-input">
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" class="form-input" rows="5"><?php echo htmlspecialchars($description); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" step="0.01" required class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Current Image:</label>
                    <?php 
                    if($current_image != "") {
                    ?>
                        <img src="../images/food/<?php echo htmlspecialchars($current_image); ?>" width="150" alt="Current Food Image" class="mt-2">
                    <?php
                    } else {
                        echo "<div class='text-accent mt-2'>Image not Added.</div>";
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label for="new_image" class="form-label">Select New Image:</label>
                    <input type="file" id="new_image" name="image" class="form-input">
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Category:</label>
                    <select id="category" name="category" class="form-input">
                        <?php 
                        $categories = fetchAllFoodCategories();
                        foreach($categories as $category) {
                            $selected = ($category['id'] == $current_category) ? "selected" : "";
                            echo "<option value='".htmlspecialchars($category['id'])."' ".$selected.">".htmlspecialchars($category['name'])."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="is_active" value="1" <?php echo ($is_active == 1) ? "checked" : ""; ?> class="mr-2">
                        Active
                    </label>
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($current_image); ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn btn--primary">
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('../components/footer.php'); ?>