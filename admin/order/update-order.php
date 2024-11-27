<?php 
include('../components/menu.php');
include('order_operations.php');
?>

<main class="container mt-4">
    <div class="card animate-fadeIn">
        <div class="card__header">
            <h1 class="heading heading--large">Update Order Status</h1>
        </div>
        <div class="card__body">
            <?php 
            if(isset($_GET['id'])) {
                $order_id = $_GET['id'];
                $order = fetchOrderById($order_id);

                if(!$order) {
                    $_SESSION['update'] = "Order not found.";
                    header('location: index.php');
                    exit();
                }
            } else {
                header('location: index.php');
                exit();
            }

            if(isset($_POST['submit'])) {
                $order_id = $_POST['id'];
                $status = $_POST['status'];

                $result = updateOrderStatus($order_id, $status);

                if($result === true) {
                    $_SESSION['update'] = "Order Status Updated Successfully.";
                    header('location: index.php');
                } else {
                    $_SESSION['update'] = "Failed to Update Order Status. $result";
                    header('location: update-order.php?id='.$order_id);
                }
                exit();
            }
            ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label class="form-label">Order ID:</label>
                    <p><?php echo htmlspecialchars($order['details']['id']); ?></p>
                </div>

                <div class="form-group">
                    <label class="form-label">Customer Name:</label>
                    <p><?php echo htmlspecialchars($order['details']['customer_name']); ?></p>
                </div>

                <div class="form-group">
                    <label class="form-label">Total Amount:</label>
                    <p>$<?php echo number_format($order['details']['total_amount'], 2); ?></p>
                </div>

                <div class="form-group">
                    <label class="form-label">Order Items:</label>
                    <ul class="list-unstyled">
                        <?php foreach($order['items'] as $item): ?>
                            <li>
                                <?php echo htmlspecialchars($item['food_name']); ?> 
                                (<?php echo htmlspecialchars($item['quantity']); ?>) - 
                                $<?php echo number_format($item['item_price'] * $item['quantity'], 2); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Status:</label>
                    <p><?php echo htmlspecialchars($order['details']['status']); ?></p>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">New Status:</label>
                    <select id="status" name="status" class="form-input">
                        <option value="Pending" <?php echo ($order['details']['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="Processing" <?php echo ($order['details']['status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                        <option value="Delivered" <?php echo ($order['details']['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                        <option value="Cancelled" <?php echo ($order['details']['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['details']['id']); ?>">
                    <input type="submit" name="submit" value="Update Status" class="btn btn--primary">
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('../components/footer.php'); ?>