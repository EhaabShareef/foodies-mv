<?php 
include('../components/menu.php');
include('category_operations.php');
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Add Food Category</h1>
        </div>
        <div class="card__body">
            <?php 
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $is_active = isset($_POST['is_active']) ? 1 : 0;

                // Handle file upload
                $image_path = '';
                if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                    $image_name = $_FILES['image']['name'];
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    $image_name = "Food_Category_".rand(000, 999).'.'.$ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    // Check if directory exists, if not create it
                    if (!file_exists("../images/category/")) {
                        mkdir("../images/category/", 0777, true);
                    }

                    $upload = move_uploaded_file($source_path, $destination_path);
                    if ($upload == false) {
                        echo "<div class='text-accent mb-3'>Failed to Upload Image. Error: " . error_get_last()['message'] . "</div>";
                    } else {
                        $image_path = $destination_path;
                        echo "<div class='text-secondary mb-3'>Image uploaded successfully.</div>";
                    }
                } else {
                    echo "<div class='text-accent mb-3'>No image selected.</div>";
                }

                if ($image_path != '') {
                    $result = addFoodCategory($name, $description, $image_name, $is_active);

                    if ($result === true) {
                        echo "<div class='text-secondary mb-3'>Category Added Successfully.</div>";
                    } else {
                        echo "<div class='text-accent mb-3'>Failed to Add Category. $result</div>";
                    }
                }
            }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Category Name" required class="form-input">
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" placeholder="Category Description" class="form-input" rows="5"></textarea>
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Select Image:</label>
                    <input type="file" id="image" name="image" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="is_active" value="1" class="mr-2">
                        Active
                    </label>
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" value="Add Category" class="btn btn--primary">
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('../components/footer.php'); ?>