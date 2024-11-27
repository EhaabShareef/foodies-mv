<?php
// food_operations.php
//include('../db_connection.php');

// Add Food Function
function addFood($category_id, $name, $description, $price, $image_path, $is_active) {
    $conn = getDbConnection();
    
    $sql = "INSERT INTO food (category_id, name, description, price, image_path, is_active) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdsi", $category_id, $name, $description, $price, $image_path, $is_active);

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

// Delete Food Function
function deleteFood($food_id) {
    $conn = getDbConnection();
    
    $sql = "DELETE FROM food WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $food_id);

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

// Update Food Function
function updateFood($food_id, $category_id, $name, $description, $price, $image_path, $is_active) {
    $conn = getDbConnection();

    $sql = "UPDATE food 
            SET category_id = ?, name = ?, description = ?, price = ?, image_path = ?, is_active = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdsii", $category_id, $name, $description, $price, $image_path, $is_active, $food_id);

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

// Fetch All Food Items Function
function fetchAllFoodItems() {
    $conn = getDbConnection();
    
    $sql = "SELECT f.*, c.name as category_name 
            FROM food f 
            JOIN food_category c ON f.category_id = c.id 
            ORDER BY f.name";
    $result = $conn->query($sql);

    $food_items = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $food_items[] = $row;
        }
    }

    $conn->close();
    return $food_items;
}

// Fetch Single Food Item by ID Function
function fetchFoodItemById($food_id) {
    $conn = getDbConnection();

    $sql = "SELECT f.*, c.name as category_name 
            FROM food f 
            JOIN food_category c ON f.category_id = c.id 
            WHERE f.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $food_item = $result->fetch_assoc();
    } else {
        $food_item = null;
    }

    $stmt->close();
    $conn->close();
    return $food_item;
}

// Fetch All Food Categories Function
function fetchAllFoodCategories() {
    $conn = getDbConnection();
    
    $sql = "SELECT * FROM food_category WHERE is_active = 1 ORDER BY name";
    $result = $conn->query($sql);

    $categories = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    $conn->close();
    return $categories;
}
?>