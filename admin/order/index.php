<?php 
include('../components/menu.php');
include('order_operations.php');
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Manage Orders</h1>
        </div>
        <div class="card__body">
            <?php 
            if(isset($_SESSION['update'])) {
                echo "<div class='text-secondary mb-3'>" . htmlspecialchars($_SESSION['update']) . "</div>";
                unset($_SESSION['update']);
            }
            ?>

            <div class="table-responsive">
                <table class="table table--striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Food Items</th>
                            <th>Total Amount</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $orders = fetchAllOrders();
                        if(!empty($orders)) {
                            foreach($orders as $order) {
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                    <td><?php echo htmlspecialchars($order['food_items']); ?></td>
                                    <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                    <td><?php echo date('Y-m-d H:i', strtotime($order['created_at'])); ?></td>
                                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                                    <td>
                                        <a href="update-order.php?id=<?php echo $order['id']; ?>" class="btn btn--secondary">Update Status</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="8" class="text--center">No Orders Found</td>
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