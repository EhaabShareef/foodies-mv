<?php 
include('../components/menu.php');
include('food_operations.php');
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Manage Food Items</h1>
        </div>
        <div class="card__body">
            <div class="mb-4">
                <a href="add-food.php" class="btn btn--primary">Add Food Item</a>
            </div>

            <?php 
            if(isset($_SESSION['add'])) {
                echo "<div class='text-secondary mb-3'>" . $_SESSION['add'] . "</div>";
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['delete'])) {
                echo "<div class='text-accent mb-3'>" . $_SESSION['delete'] . "</div>";
                unset($_SESSION['delete']);
            }
            if(isset($_SESSION['update'])) {
                echo "<div class='text-secondary mb-3'>" . $_SESSION['update'] . "</div>";
                unset($_SESSION['update']);
            }
            ?>

            <div class="table-responsive">
                <table class="table table--striped">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $food_items = fetchAllFoodItems();
                        $sn = 1;

                        if(!empty($food_items)) {
                            foreach($food_items as $item) {
                        ?>
                                <tr>
                                    <td><?php echo $sn++; ?>.</td>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($item['category_name']); ?></td>
                                    <td>
                                        <?php 
                                        if($item['image_path'] != "") {
                                        ?>
                                            <img src="../images/food/<?php echo htmlspecialchars($item['image_path']); ?>" width="100" alt="<?php echo htmlspecialchars($item['name']); ?>" class="img-thumbnail">
                                        <?php
                                        } else {
                                            echo "No image available";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $item['is_active'] ? 'Yes' : 'No'; ?></td>
                                    <td>
                                        <a href="update-food.php?id=<?php echo $item['id']; ?>" class="btn btn--secondary mb-2">Update Food</a>
                                        <a href="delete-food.php?id=<?php echo $item['id']; ?>&image_path=<?php echo urlencode($item['image_path']); ?>" class="btn btn--accent">Delete Food</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="7" class="text--center">No Food Items Found</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include('../components/footer.php'); ?>