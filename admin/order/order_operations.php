<?php
// order_operations.php
//include('../db_connection.php');

// Fetch All Orders Function
function fetchAllOrders() {
    $conn = getDbConnection();
    
    $sql = "SELECT o.*, 
            GROUP_CONCAT(CONCAT(f.name, ' (', oi.quantity, ')') SEPARATOR ', ') AS food_items
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN food f ON oi.food_id = f.id
            GROUP BY o.id
            ORDER BY o.created_at DESC";
    
    $result = $conn->query($sql);

    $orders = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }

    $conn->close();
    return $orders;
}

// Fetch Single Order Function
function fetchOrderById($order_id) {
    $conn = getDbConnection();
    
    $sql = "SELECT o.*, 
            oi.food_id, f.name AS food_name, oi.quantity, oi.item_price
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN food f ON oi.food_id = f.id
            WHERE o.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $order = null;
    if ($result->num_rows > 0) {
        $order = [
            'details' => null,
            'items' => []
        ];
        while ($row = $result->fetch_assoc()) {
            if ($order['details'] === null) {
                $order['details'] = [
                    'id' => $row['id'],
                    'customer_name' => $row['customer_name'],
                    'customer_email' => $row['customer_email'],
                    'customer_phone' => $row['customer_phone'],
                    'total_amount' => $row['total_amount'],
                    'status' => $row['status'],
                    'created_at' => $row['created_at']
                ];
            }
            $order['items'][] = [
                'food_id' => $row['food_id'],
                'food_name' => $row['food_name'],
                'quantity' => $row['quantity'],
                'item_price' => $row['item_price']
            ];
        }
    }

    $stmt->close();
    $conn->close();
    return $order;
}

// Update Order Status Function
function updateOrderStatus($order_id, $new_status) {
    $conn = getDbConnection();

    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return "Error: " . $error;
    }
}
?>