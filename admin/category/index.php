<?php 
include('../components/menu.php');
include('category_operations.php');
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Manage Food Categories</h1>
        </div>
        <div class="card__body">
            <div class="mb-4">
                <a href="add-category.php" class="btn btn--primary">Add Food Category</a>
            </div>

            <div class="table-responsive">
                <table class="table table--striped">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $categories = fetchAllFoodCategories();
                        if (is_array($categories)) {
                            $sn = 1;
                            foreach ($categories as $category) {
                        ?>
                                <tr>
                                    <td><?php echo $sn++; ?>.</td>
                                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                                    <td><?php echo htmlspecialchars($category['description']); ?></td>
                                    <td>
                                        <img src="../images/category/<?php echo htmlspecialchars($category['image_path']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" width="100" class="img-thumbnail">
                                    </td>
                                    <td><?php echo $category['is_active'] ? 'Yes' : 'No'; ?></td>
                                    <td>
                                        <a href="update-category.php?id=<?php echo $category['id']; ?>" class="btn btn--secondary mb-2">Update Category</a>
                                        <a href="delete-category.php?id=<?php echo $category['id']; ?>" class="btn btn--accent">Delete Category</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text--center'>{$categories}</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include('../components/footer.php'); ?>